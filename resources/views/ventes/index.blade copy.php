<button id="btn"><a href="{{ route('ventes.create')}}">+ Ajouter une vente</a></button>
<br>

    <table border="3" >
    <caption>Liste des ventes</caption>
    <thead>
        <tr>
            <th>ID </th>
            <th>Date de vente</th>
           <th>Montant total</th>
            <th>Actions</th>
           
        </tr>
       
    </thead>
    <tbody>
    @forelse ($ventes ?? [] as $vente)
        <tr>
          <td>{{ $vente->id}}</td>
            <td>{{ $vente->date_vente}}</td>
            <td>{{ $vente->montant_total }} F</td>
            <td>
                <form action="{{route('ventes.show',$vente)}}" method="get">

                   <button type="submit">Details vente</button>
                   
                </form><form action="{{route('ventes.edit',$vente)}}" method="get">

                   <button type="submit">Editer</button>
                </form>
                
                <form action="{{route('ventes.destroy',$vente)}}" method="post">
                    @csrf
                    @method("DELETE")
                    <button type="submit">Supprimer</button> 
                </form>
           </td>
        </tr>

    @empty
        <p>Aucune vente</p>
    @endforelse
        
    </tbody>
    <tfoot> 
    </tfoot>
</table>


