<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Patient;
class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $pat=new Patient();
        // $pat->nom="TOUTABIZ";
        // $pat->prenom='aliba';
        // $pat->dateNaiss="12-12-2000";
        $patients=Patient::all();
        
        return view("patients.index")->with(["patients"=> $patients]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("patients.create");   
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
        'nom' =>'required|min:3|max:25',
        'prenom' =>'required|min:3|max:25',
        'dateNaiss' =>'required|date']);
        //
        $pat=Patient::create($request->all());
        dump($pat);
        return redirect()->route("patients.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //dd($patient);
        return view('patients.create',compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Patient $patient)
    {
        //
        $patient->update($request->all());
        return redirect()->route('patients.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        $patient->delete();
        return redirect()->route('patients.index');
    }
    
}
