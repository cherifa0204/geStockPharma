<?php

namespace App\Imports;

use App\Models\Produit;
use Maatwebsite\Excel\Concerns\ToModel;

class ProduitsImport implements ToModel
{
    public $createdCount = 0;
    public $updatedCount = 0;

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // 1. Skip header row if present
        $firstCell = isset($row[0]) ? trim((string)$row[0]) : '';
        $secondCell = isset($row[1]) ? trim((string)$row[1]) : '';

        $firstCellLower = mb_strtolower($firstCell, 'UTF-8');
        $secondCellLower = mb_strtolower($secondCell, 'UTF-8');

        if (
            $firstCellLower === 'id' || 
            $firstCellLower === 'désignation' || 
            $firstCellLower === 'designation' || 
            $secondCellLower === 'désignation' || 
            $secondCellLower === 'designation'
        ) {
            return null; // Skip header row
        }

        // 2. Detect column mapping based on layout
        // If the first cell is numeric or empty, it matches the 6-column export layout (ID, Designation, Achat, Vente, Stock, Valeur)
        // If the first cell is a non-numeric string (e.g., product name), it matches the 4-column layout (Designation, Achat, Vente, Stock)
        $isSixColumnLayout = is_numeric($firstCell) || $firstCell === '';

        if ($isSixColumnLayout) {
            $id = $firstCell !== '' ? (int)$firstCell : null;
            $nom = isset($row[1]) ? trim((string)$row[1]) : '';
            $prixAchat = isset($row[2]) ? $this->cleanNumber($row[2]) : 0;
            $prixVente = isset($row[3]) ? $this->cleanNumber($row[3]) : 0;
            $quantite = isset($row[4]) ? $this->cleanNumber($row[4]) : 0;
        } else {
            $id = null;
            $nom = $firstCell;
            $prixAchat = isset($row[1]) ? $this->cleanNumber($row[1]) : 0;
            $prixVente = isset($row[2]) ? $this->cleanNumber($row[2]) : 0;
            $quantite = isset($row[3]) ? $this->cleanNumber($row[3]) : 0;
        }

        if (empty($nom)) {
            return null; // Skip empty row
        }

        // 3. Find if product already exists to update it, otherwise create new
        $produit = null;
        if ($id) {
            $produit = Produit::find($id);
        }
        if (!$produit) {
            $produit = Produit::where('nom_produit', $nom)->first();
        }

        if ($produit) {
            $produit->fill([
                'prix_unitaire_achat' => $prixAchat,
                'prix_unitaire_vente' => $prixVente,
            ]);
            $produit->quantite_stock = $quantite;
            $produit->save();
            $this->updatedCount++;
            return null; // Return null so Laravel Excel doesn't insert a duplicate row
        }

        // Create new product
        $newProduit = new Produit([
            'nom_produit'         => $nom,
            'prix_unitaire_achat' => $prixAchat,
            'prix_unitaire_vente' => $prixVente,
        ]);
        // Set quantite_stock manually because it is not fillable
        $newProduit->quantite_stock = $quantite;

        $this->createdCount++;
        return $newProduit;
    }

    /**
     * Cleans number strings, removing thousands separators and spaces
     */
    private function cleanNumber($val)
    {
        if (is_null($val) || $val === '') {
            return 0;
        }

        if (is_numeric($val)) {
            return (int)$val;
        }

        // Remove any type of spaces/whitespace characters
        $cleaned = preg_replace('/\s+/u', '', $val);

        // Convert decimal comma to dot
        $cleaned = str_replace(',', '.', $cleaned);

        if (is_numeric($cleaned)) {
            return (int)round((float)$cleaned);
        }

        // Remove any remaining non-digit and non-dot characters
        $cleaned = preg_replace('/[^\d.]/', '', $cleaned);
        if (is_numeric($cleaned)) {
            return (int)round((float)$cleaned);
        }

        return 0;
    }
}
