<?php

namespace App\Exports;

use App\Models\Produit;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProduitsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Produit::all();
    }

    public function title(): string
    {
        return 'Catalogue Produits';
    }

    public function headings(): array
    {
        return [
            'ID',
            'Désignation',
            'Prix d\'Achat (FCFA)',
            'Prix de Vente (FCFA)',
            'Quantité en Stock',
            'Valeur Stock (FCFA)'
        ];
    }

    public function map($produit): array
    {
        $valeurStock = ($produit->prix_unitaire_achat ?? 0) * ($produit->quantite_stock ?? 0);
        return [
            $produit->id,
            $produit->nom_produit,
            number_format($produit->prix_unitaire_achat ?? 0, 0, ',', ' '),
            number_format($produit->prix_unitaire_vente ?? 0, 0, ',', ' '),
            $produit->quantite_stock,
            number_format($valeurStock, 0, ',', ' '),
        ];
    }

    public function styles(Worksheet $worksheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0D9488']
                ],
            ],
        ];
    }
}

