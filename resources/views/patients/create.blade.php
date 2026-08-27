@php 
    $name= ($patient ?? null) != null ? "update" : "store";
@endphp
<form action="{{route('patients.'.$name, $patient ?? '' )}}" method="post">
    @if ($patient ?? null)
    @method("PUT")
    @endif
    @csrf
    <div>
        
        <h2>Enregistrement d'un patient</h2>
        <label for="">Nom :</label>
        <input type="text" value="{{ $patient->nom ?? ''}}" class="@error('nom') is-invalid @enderror" name="nom">
        @error('nom')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>
        <label for="">Prenom :</label>
        <input type="text" value="{{ $patient->prenom ?? ''}}" class="@error('prenom') is-invalid @enderror" name="prenom">
        <br>
        <label for="">Date de Naissance : </label>
        <input type="date" value="{{ $patient->dateNaiss ?? ''}}" name="dateNaiss"><br>
       

        <button id="btn" type="submit">Enregistrer</button>
        </div>
    
</form>