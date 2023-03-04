<?php

namespace App\Http\Controllers;

use App\Models\User;

class CreateCient extends Controller
{
    public function createClientForm(){
        return view('components.forms.cad-form-create');
    }

    public function createClient(){
        $attributes = request()->validate([
            'name' => 'required|min:4',
            'celular' => 'required|max:11|unique:users,celular',
            'password' => 'required|min:6|max:8',
        ]);

        $attributes['password'] = bcrypt($attributes['password']);
        $attributes['created_at'] = date(now());

        User::create($attributes);

        return redirect('/autenticado')
                ->with('logado', 'OK novo usuário cadastrado!');
    }

    public function editClientForm(){}
    public function deleteClientForm(){}
}
