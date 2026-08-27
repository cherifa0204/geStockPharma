@extends("layouts.base")
@section("content")
@php 
    $name= ($produit ?? null) != null ? "update" : "store";
    $title=($produit ?? null) != null ? "Edition d'un " : "Enregistrement d'un nouveau";
@endphp
<form action="{{route('produits.'.$name, $produit  ?? '' )}}" method="post">
    @if ($produit ?? null)
    @method("PUT")

    @endif
    @csrf
    <div>
        
        <h2>{{$title}}  produit</h2>
        
        <label for="">Nom du produit :</label>

        <input type="text" value="{{ $produit->nom_produit ?? ''}}" placeholder="xxx" class="@error('nom_produit') is-invalid @enderror" name="nom_produit">
        @error('nom_produit')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>
        
        <label for="">Prix Unitaire d'achat: </label>
        <input type="number"  value="{{ $produit->prix_unitaire_achat ?? ''}}" name="prix_unitaire_achat" placeholder="0">
        @error('prix_unitaire_achat')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>
        <label for="">Prix Unitaire de Vente : </label>
        <input type="number" value="{{ $produit->prix_unitaire_vente ?? ''}}" name="prix_unitaire_vente" placeholder="0">
        @error('prix_unitaire_vente')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <!-- <br>
        <label for="">Quantité achétée:</label>
        <input type="number" value="{{ $produit->quantite_stock ?? ''}}"  class="@error('quantite_stock') is-invalid @enderror" name="quantite_stock">
        @error('quantite_stock')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      -->
        <br>
        <br>
        <button id="btn" type="submit">Enregistrer</button>
        </div>
    
</form>
@endsection