<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Payments;
use App\Models\Product;
use App\Models\User as ModelsUser;
use App\Models\SaledProducts;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mockery\Undefined;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ModelsUser $user)
    {

        $userDetail = ModelsUser::where('user_id', auth()->user()->user_id)->get();

        $sale = Sales::where('saled_products_fk', auth()->user()->user_id)->get();

        $products = SaledProducts::where('saled_client', auth()->user()->user_id)->get();


        if(!auth()->user()) {
            return redirect()->back()
                    ->with('logado', 'Não autorizado...');
        }

        if(auth()->user()->isadmin || auth()->user()->isfunc) {
            return view('components.admin-components.admin-panel', [
                'users' => $user->orderBy('name', 'ASC')->get()
            ]);
        } else {
            return view('components.user-components.user-page',  [
                'sales' => $sale,
                'user' => $userDetail,
                'products' => $products,
                'sum' =>
                    Payments::showTotalClientDebit($userDetail[0]->user_id),
                'payments' =>
                    Payments::showPayments($userDetail[0]->user_id)
            ]);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // return Payments::show($id);

        $saled = SaledProducts::where('saled_client', $id)->get();

        $user = ModelsUser::where('user_id', $id)->get();

        if(!auth()->user()) {
            return redirect()->back()
                    ->with('logado', 'Não autorizado...');
        }

        return view('components.single-client', [
            'user' => $user,
            'sales' =>  Payments::show($id),
            'products' => $saled,
            'sum' => Payments::showTotalClientDebit($id),
            'payments' => Payments::showPayments($id)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if(!auth()->user()) {
            return redirect()->back()
                    ->with('logado', 'Não autorizado...');
        }

        $userDetail = ModelsUser::where('user_id', $id)->get();

        return view('components.forms.insertProducts', [
            'products' => Product::all(),
            'user' => $userDetail
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currDate = date(now()->format('Y-m-d'));

        $date = Sales::where('sale_date', $currDate)
                    ->where('user_fk', $request->input('user_id'))
                    ->pluck('sale_date');

        if(empty($date[0])) {

            $attributes = [
                'user_fk' => $request->input('user_id'),
                'saled_products_fk' => $request->input('user_id'),
                'sale_date' => date(now())
            ];

            if(isset($date[0]) === $currDate) {
                $attributes['sale_date'] =
                    Sales::where('sale_date', $currDate)
                         ->where('user_fk', $request->input('user_id'))
                         ->update(['sale_date' => $currDate]);
            }

            Sales::create($attributes);

            foreach(request()->input('products') as $key => $value) {

                $teste =  Product::where('product_name', $key)->pluck('product_price');

                SaledProducts::create([
                    'saled_name' =>  $key,
                    'saled_qtty' => $value,
                    'saled_price' => $teste[0],
                    'saled_client' => $request->input('user_id'),
                    'saler' => auth()->user()->name,
                    'saled_date' => date(now())
                ]);
            }

        } else {

            foreach(request()->input('products') as $key => $value) {

                $teste =  Product::where('product_name', $key)->pluck('product_price');

                SaledProducts::create([
                    'saled_name' =>  $key,
                    'saled_qtty' => $value,
                    'saled_price' => $teste[0],
                    'saled_client' => $request->input('user_id'),
                    'saler' => auth()->user()->name,
                    'saled_date' => date(now())
                ]);
            }
        }

        $route = 'user/' . $request->input('user_id');

        return redirect($route)
                ->with('logado', 'OK nova venda cadastrada!');

    }

    public function purshaseDetail(Request $request) {

        $saledate = request()->input('date');

        $user = request()->input('user');

        $details = SaledProducts::where('saled_date', $saledate)
                            ->where('saled_client', $user)
                            ->get();

        return view('components.user-components.details', [
            'details' => $details,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        return view('components.forms.confirm-sale', [
            'products' => $request->input('products')
        ]);
    }

    public function destoydate() {

        $redirect = 'user/' . request()->input('user_id');

        Sales::where('sale_date', request()->input('date'))
                ->where('user_fk', request()->input('user_id'))
                ->delete();

        return redirect($redirect)->with('deletadata', 'Data deletada!');

    }


    public function destroysale() {

       $redirect = 'user/'. request()->input('user_id');

        SaledProducts::where('saled_id', request()->input('saled_id'))
        ->delete();

        return redirect($redirect)->with('deletado', 'Venda deletada!');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        return $request->input();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelsUser $user)
    {
        auth()->logout($user);
        return redirect('/')->with('logado', 'Até logo...');
    }
}