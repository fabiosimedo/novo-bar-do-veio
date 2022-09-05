<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;

class CreateCient extends Controller
{
    public function createClientForm(){
        return view('components.forms.cad-form-create');
    }

    public function createClient(){
        $attributes = request()->validate([
            'name' => 'required|min:4',
            'celular' => 'required|max:9|unique:users,celular',
            'password' => 'required|min:6|max:8'
        ]);

        $attributes['created_at'] = Carbon::now()->format('d \\of F Y l');
        $attributes['password'] = bcrypt($attributes['password']);

        User::create($attributes);

        return redirect('/')->with('logado', 'Parabéns você se cadastrou no sistema!');
    }


}
