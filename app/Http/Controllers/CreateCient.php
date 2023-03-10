<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SaledProducts;
use App\Models\Sales;
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
                    ->where('user_fk', '')
                    ->pluck('sale_date');

        if(empty($date[0])) {

            $attributes = [
                'user_fk' => 0,
                'saled_products_fk' => 0,
                'sale_date' => date(now())
            ];

            if(isset($date[0]) === $currDate) {
                $attributes['sale_date'] =
                    Sales::where('sale_date', $currDate)
                         ->where('user_fk', 0)
                         ->update(['sale_date' => $currDate]);
            }

            Sales::create($attributes);
        } else {

            foreach(request()->input('products') as $key => $value) {

                $teste =  Product::where('product_name', $key)->pluck('product_price');

                SaledProducts::create([
                    'saled_name' =>  $key,
                    'saled_qtty' => $value,
                    'saled_price' => $teste[0],
                    'saled_client' => 0,
                    'saler' => auth()->user()->name,
                    'saled_date' => date(now())
                ]);
            }

        }

        return redirect('autenticado')
        ///////// redirecionar para check venda a vulsa por data (cria view para visualizar)
                ->with('venda_a_vulsa', 'OK venda avulsa cadastrada!');

    }

    public function checkVendaAvulsa(){
        return view('check-vendas-avulsa');
    }
    public function deleteClientForm(){}
}
