@extends("layouts.base")
@section('title','Liste des Produits')
@section("content")

<!---div><h2>@yield('title')</h2></div--->

<script  src="{{asset('DataTables/jquery.js')}}"></script>
<script src="{{asset('DataTables/moncss.js')}}"></script>
<br>
<button id="btn"><a href="{{ route('produits.create')}}"><i class="bi bi-plus"></i>Ajouter un produit</a></button>
<br>
<br>
<div>
    @if(session('success'))
    <div class="alert-success">
        {{ session('success')}}
    </div>
    @endif
</div>
<br>
<table border="4" id="tble" class="table table-striped">
    <caption>Liste des Produits</caption> 
    <thead>
        <tr>
            <th>Nom du Medicament</th>
            <th>Prix Unitaire achat </th>
            <th>Prix Unitaire vente </th>
            <th>Quantité Stock</th>
            <th>Editer</th>
            <th>Supprimer</th>
        </tr>
       
    </thead>
    <tbody>
    @forelse ($produits ?? [] as $produit)
        <tr>
            <td>{{ $produit->nom_produit }}</td>
            <td>{{number_format($produit->prix_unitaire_achat,thousands_separator:' ')  }} F</td>
            <td>{{ $produit->prix_unitaire_vente }} F</td>
            <td>{{ $produit->quantite_stock}}</td>
            <td>
                <form action="{{route('produits.edit',$produit)}}" method="get">

                   <button type="submit">Editer</button>
                </form>
            </td>
            <td>
                <form action="{{route('produits.destroy',$produit)}}" method="post">
                    @csrf
                    @method("DELETE")
                    <button type="submit">Supprimer</button> 
                </form>
           </td>
        </tr>

    @empty
        <p>Aucun produit</p>
    @endforelse
        
    </tbody>
    <tfoot> 
    </tfoot>
</table>
<br>
<script>
    new DataTable('#tble',{
        info:false,
        paging:false,
        language: {
                 "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/French.json"
             }
    });
</script>

@endsection