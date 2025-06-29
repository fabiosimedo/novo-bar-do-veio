<?php

namespace App\Http\Controllers;

class Home extends Controller
{
    public function index() {
        return view('home');
    }

    public function userAccess() {
        $attributes = request()->validate([
            'celular' => 'required|min:11|max:11',
            'password' => 'required|min:6'
        ], [
            'celular.required' => 'O número de celular é obrigatório.',
            'celular.min' => 'O número de celular deve conter exatamente 11 dígitos.',
            'celular.max' => 'O número de celular deve conter exatamente 11 dígitos.',

            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve conter no mínimo 6 caracteres.'
        ]);

        if(auth()->attempt($attributes)) {
            $user = auth()->user()->name;

            return redirect('/autenticado')
                    ->with('logado', "$user entrou no sistema!");
        }

        return back()
                ->withErrors([
                    'celular' => 'Suas credenciais estão incorretas...'
                ]);

    }

}
