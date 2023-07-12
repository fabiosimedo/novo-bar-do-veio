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

    public function updatePasswdAndCellPhone() {

        $newPassword = request()->validate([
            'celular' => 'required|min:11|max:11|unique:users,celular',
            'password' => 'required|min:6|max:8'
        ]);

        $newPassword['password'] = bcrypt(request()->input('password'));

        User::where('user_id', request()->input('user_id'))
                ->update([
                    'password' => $newPassword['password'],
                    'celular' => request()->input('celular')
                ]);

        $route = 'user/' . request()->input('user_id');

        return redirect($route)
            ->with('newpassword', 'Celular e senha cadastrados com sucesso!');
    }

    public function editClientName($id) {
        if(! auth()->user()->isadmin) {
            return back();
        }
        return view('components.admin-components.edit-client-name', [
            'user' => User::where('user_id', $id)->get()[0]
        ]);
    }

    public function editClientNameOnDatabase() {
        $userToRename =  request()->input('user_id');
        $nameToUpdate = request()->input('user_new_name');

        User::where('user_id', $userToRename)->update([
            'name' => $nameToUpdate
        ]);

        return redirect('/autenticado');
    }
}
