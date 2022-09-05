<?php

namespace App\Http\Controllers;

use App\Models\User;

class Home extends Controller
{
    public function index() {
        return view('home', [ 'user' => User::all() ]);
    }

    public function enterForm() {
        return view('components.forms.enterform');
    }

    public function userAccess() {
        $attributes = request()->validate([
            'celular' => 'required|min:9|max:9',
            'password' => 'required|min:6|max:8'
        ]);


        if(auth()->attempt($attributes)) {
            return redirect('/')->with('logado', 'Você entrou no sistema!');
        }

        return back()->withErrors([ 'celular' => 'Suas credenciais estão incorretas...']);

    }

    public function logout(User $user) {
        auth()->logout($user);
        return redirect('/')->with('logado', 'Até logo...');
    }


    public function showClientDetail(User $user) {
        return view('components.single-client', [ 'user' => $user ]);
    }

}
