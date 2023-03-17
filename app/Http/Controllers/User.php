<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Payments;
use App\Models\Payments as ModelsPayments;
use App\Models\Product;
use App\Models\User as ModelsUser;
use App\Models\SaledProducts;
use App\Models\Sales;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Http\Request;

class User extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ModelsUser $user)
    {

        if(!auth()->user()) {
            return redirect()->back()
                    ->with('logado', 'Não autorizado...');
        }

        if(auth()->user()->isadmin || auth()->user()->isfunc) {

            return view('components.admin-components.admin-panel', [
                'users' => $user->orderBy('name', 'ASC')->get()
            ]);

        } else {

            $userDetail = ModelsUser::where('user_id', auth()->user()->user_id)->get();

            $sale = Sales::where('saled_products_fk', auth()->user()->user_id)->get();

            $products = SaledProducts::where('saled_client', auth()->user()->user_id)->get();

            return view('components.user-components.user-page',  [
                'user' => $userDetail[0],
                'sales' => $sale,
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
        if(!auth()->user()) {
            return redirect()->back()
                    ->with('logado', 'Não autorizado...');
        }

        $saled = SaledProducts::where('saled_client', $id)->get();

        $user = ModelsUser::where('user_id', $id)->get();

        return view('components.single-client', [
            'user' => $user[0],
            'sales' =>  Payments::show($id),
            'products' => $saled,
            'totalsum' => Payments::showTotalClientDebit($id),
            'payments' => Payments::showPayments($id)
        ]);
    }


    public function purshaseDetail(Request $request) {

        $user = ModelsUser::where('user_id', $request->input('user'))->get();

        $saledProducts = SaledProducts::where('saled_date', $request->input('date'))
                            ->where('saled_client', $user[0]->user_id)
                            ->orderBy('saled_id', 'DESC')->get();

        $sum =
        Payments::showTotalFromDate($request->input('date'), $user[0]->user_id);
        $subtotal =
        Payments::showSubTotalPayment($request->input('date'), $user[0]->user_id);

        Payments::updateGlobalPayment($user[0]->user_id);

        if($subtotal > 0) {
            Sales::where('sale_date', $request->input('date'))
            ->where('user_fk', $user[0]->user_id)
            ->update(['sale_paid' => 0 ]);
        }

        if($subtotal == 0) {
            Sales::where('sale_date', $request->input('date'))
            ->where('user_fk', $user[0]->user_id)
            ->update(['sale_paid' => 1 ]);
        }

        return view('components.user-components.details', [
            'user' => $user[0],
            'details' => $saledProducts,
            'sum' => $sum,
            'subtotal' =>$subtotal
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

        $user_id = $request->input('user_id');

        $date = Sales::where('sale_date', $currDate)
                        ->where('user_fk', $user_id)
                        ->pluck('sale_date');

        if(empty($date[0])) {

            foreach(request()->input('products') as $key => $value) {

                $price =  Product::where('product_name', $key)->pluck('product_price');

                SaledProducts::create([
                    'saled_name' =>  $key,
                    'saled_qtty' => $value,
                    'saled_price' => $price[0],
                    'saled_client' => $request->input('user_id'),
                    'saler' => auth()->user()->name,
                    'saled_date' => date(now())
                ]);
            }

            Sales::create([
                'user_fk' => $user_id,
                'saled_products_fk' => $user_id,
                'sale_date' => date(now()),
                'sale_paid' => 0,
                'sale_total_value' =>
                Payments::showTotalFromDate($currDate, $user_id),
                'sale_not_paid_value' =>
                Payments::showSubTotalPayment($currDate, $user_id)
            ]);

            Payments::updateGlobalPayment($user_id);

        } else {

            foreach(request()->input('products') as $key => $value) {

                $price =  Product::where('product_name', $key)->pluck('product_price');

                SaledProducts::create([
                    'saled_name' =>  $key,
                    'saled_qtty' => $value,
                    'saled_price' => $price[0],
                    'saled_client' => $request->input('user_id'),
                    'saler' => auth()->user()->name,
                    'saled_date' => date(now())
                ]);
            }

            Payments::updateGlobalPayment($user_id);

            $updateDateAndPaymentStatus = [
                'sale_date' => $currDate,
                'sale_paid' => 0,
                'sale_total_value' =>
                Payments::showTotalFromDate($currDate, $user_id),
                'sale_paid_value' =>
                Payments::showSubTotalPayment($currDate, $user_id)
            ];

            Sales::where('sale_date', $currDate)
                    ->where('user_fk', $user_id)
                    ->update($updateDateAndPaymentStatus);

        }


        $route = 'user/' . $request->input('user_id');

        return redirect($route)
                ->with('venda_cadastrada', 'OK nova venda cadastrada!');

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

    public function destroysale() {

        SaledProducts::where('saled_id', request()->input('saled_id'))
        ->delete();

        return back()->with('deletado', 'Venda deletada!');
    }

    public function destoydate() {

        $redirect = 'user/' . request()->input('user_id');

        Sales::where('sale_date', request()->input('date'))
                ->where('user_fk', request()->input('user_id'))
                ->delete();

        return redirect($redirect)->with('deletadata', 'Data deletada!');

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
        return redirect('/')->with('deslogado', 'Até logo...');
    }
}
