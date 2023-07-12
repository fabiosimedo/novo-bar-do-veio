<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SaledProducts;
use App\Models\Sales;
use App\Models\User;
use App\Http\Controllers\User as UserController;

class CreateCient extends Controller
{
    public function createClientForm(){
        return view('components.forms.cad-form-create');
    }

    public function createClient(){

        if(request()->input('client_without_password')) {
            return request()->input('name');

            $attributes = request()->validate([
                'name' => 'required|min:4|unique:users,name'
            ]);

            $attributes['celular'] = NULL;
            $attributes['created_at'] = date(now());

            User::create($attributes);

        } else {

            $attributes = request()->validate([
                'name' => 'required|min:4',
                'celular' => 'required|max:11|unique:users,celular',
                'password' => 'required|min:6|max:8',
            ]);

            $attributes['password'] = bcrypt($attributes['password']);
            $attributes['created_at'] = date(now());

            User::create($attributes);

        }


        return redirect('/autenticado')
                ->with('logado', 'OK novo usuário cadastrado!');

    }

    public function createClientAvulso() {

        return view('components.forms.cad-form-create', [
            'products' => Product::all()
        ]);

    }

    public function clientAvulsoRegister() {

        return view('components.forms.confirm-sale', [
            'products' => request()->input('products')
        ]);

    }

    public function clientAvulsoConfirm() {
        $currDate = date(now()->format('Y-m-d'));

        $date = Sales::where('sale_date', $currDate)
                    ->where('sale_user_fk', request()->input('user_id'))->get();

        if(empty($date[0])) {

            Sales::create([
                'sale_date' => date(now()),
                'sale_user_fk' => 0
            ]);

            UserController::store();

            return redirect('/autenticado')
                ->with('venda_a_vulsa', 'OK venda avulsa cadastrada!');

        } else {

            UserController::store();

            return redirect('/autenticado')
                ->with('venda_a_vulsa', 'OK venda avulsa cadastrada!');
        }

    }

    public function checkVendaAvulsa(){
        return view('check-vendas-avulsa');
    }
    public function deleteClientForm(){}
}
