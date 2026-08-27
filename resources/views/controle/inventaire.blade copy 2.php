<h2>Inventaire sur les produits en stock</h2>
<table border="3">
    <thead>
        <tr>
            <th>Nom du medicament</th>
            <th>Quantité Initiale  </th>
            <th>Montant Total Achat (FCFA)</th>
            <th>Quantité Vendue </th>
            <th>Montant Total Vente (FCFA)</th>
            <th>Quantité Actuelle </th>
            <th>Montant Actuel (FCFA)</th>
            
        </tr>
       
    </thead>
    <tbody>
    @forelse ($produits as $prd)
        <tr> 
            <td>{{ $prd->nom_produit}}</td>
            <td>{{ $prd->quantite_initial }}</td>
            <td>{{ $prd->montant_achats}}</td>
            <td>{{ $prd->quantite_vendu }}</td>
            <td>{{ $prd->montant_ventes}}</td>
            <td>{{ $prd->quantite_stock}}</td>
            <td>{{ $prd->montant_achats - $prd->montant_ventes }}</td>
            
            
              
            
    
        </tr>

    @empty
        <p>Pas d'inventaire</p>
    @endforelse
        
    </tbody>
    <tfoot> 
    </tfoot>
</table>

