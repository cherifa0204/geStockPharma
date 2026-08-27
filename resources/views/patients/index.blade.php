
<button id="btn"><a href="{{ route('patients.create')}}">Ajouter un patient</a></button>
<br>
<table border="2">
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>DateNaissance</th>
            <th>Editer</th>
            <th>Supprimer</th>
        </tr>
       
    </thead>
    <tbody>
    @forelse ($patients as $patient)
        <tr>
            <td>{{ $patient->nom }}</td>
            <td>{{ $patient->prenom }}</td>
            <td>{{ $patient->dateNaiss }}</td>
           
            <td>
                <form action="{{route('patients.edit',$patient)}}" method="get">

                   <button type="submit">Editer</button>
                </form>
            </td>
            <td>
                <form action="{{route('patients.destroy',$patient)}}" method="post">
                    @csrf
                    @method("DELETE")
                    <button type="submit">Supprimer</button> 
                </form>
           </td>
        </tr>
        

    @empty
        <p>Aucun patient</p>
    @endforelse
        
    </tbody>
    <tfoot></tfoot>
</table>

