<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return view("users.index")->with(['users'=>User::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function  assign()
    {
        $users=User::all();
        $roles=Role::all();
        return view("users.assign_role")->with(["users"=>$users, "roles"=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $user=User::find($request->user_id);
        $role=Role::find($request->role_id);
        //dd($role);
       // $user->addRole();
        
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
