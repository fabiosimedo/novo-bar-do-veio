<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class EditClient extends Controller
{
    public function index(User $user) {

        return view('components.forms.cad-form-create', [
            'user' =>
            $user->where('user_id', request()->input('user_id'))->get()
        ]);
    }


    public function editClientPassword(User $user) {

        $newPassword = request()->validate([
            'password' => 'required|min:6|max:8'
        ]);

        $newPassword['password'] = bcrypt(request()->input('password'));

        $user->where('user_id', request()->input('user_id'))
                ->update(['password' => $newPassword['password'] ]);

        $route = 'user/' . request()->input('user_id');

        return redirect($route)
            ->with('newpassword', 'Senha alterada com sucesso!');

    }
}