@extends("../dashboard")

@section('content')
@php 
    $name= ($achat ?? null) != null ? "update" : "store";
@endphp



<form action="{{route('achats.'.$name, $achat  ?? '' )}}" method="post">
    @if ($produit ?? null)
    @method("PUT")
    @endif
    @csrf
    <div>
        
        <h2>Enregistrement d'un nouveau achat</h2>

        <label for="">Date d'achat : </label>
        <input type="date" value="{{ $achat->date_achat ?? ''}}" class="@error('date_achat') is-invalid @enderror" name="date_achat">
      
        <button id="btn" type="submit">Enregistrer</button>
    </div>
    <table border="3" >
    <caption>Liste des achats</caption>
    <thead>
        <tr>
            <th>ID achat </th>
            <th>Date d'achat</th>
           
            <th>Actions</th>
           
        </tr>
       
    </thead>
    <tbody>
    @forelse ($achats as $achat)
        <tr>
          <td>{{ $achat->id}}</td>
            <td>{{ $achat->date_achat }}</td>
            <td>
                <form action="{{route('ligneachats.create')}}" method="get">

                   <button type="submit">Ajouter une ligne d'achat</button>
                   
                </form>
            
                <form action="{{route('achats.edit',$achat)}}" method="get">

                   <button type="submit">Editer</button>
                </form>
                
                <form action="{{route('achats.destroy',$achat)}}" method="post">
                    @csrf
                    @method("DELETE")
                    <button type="submit">Supprimer</button> 
                </form>
           </td>
        </tr>

    @empty
        <p>Aucun achat</p>
    @endforelse
        
    </tbody>
    <tfoot> 
    </tfoot>
</table>

</form>

@endsection