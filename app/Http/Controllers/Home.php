<?php

namespace App\Http\Controllers;

class Home extends Controller
{
    public function index() {
        return view('home');
    }

    public function enterForm() {
        return view('components.forms.enterform');
    }

    public function userAccess() {
        $attributes = request()->validate([
            'celular' => 'required|min:11|max:11',
            'password' => 'required|min:6|max:6'
        ]);


        if(auth()->attempt($attributes)) {
            $user = auth()->user()->name;

            return redirect('/autenticado')
                    ->with('logado', "$user entrou no sistema!");
        }

        return back()->withErrors([ 'celular' => 'Suas credenciais estão incorretas...']);

    }

}
