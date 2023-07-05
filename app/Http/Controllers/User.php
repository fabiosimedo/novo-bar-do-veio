<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Payments;
use App\Models\GlobalPayments;
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

        if(auth()->user()->isadmin || auth()->user()->isfunc) {


            return view('components.admin-components.admin-panel', [
                'users' => $user->orderBy('name', 'ASC')->get(),
                // 'total' => Total pra saber queem está devendo
            ]);
        }

        return $this->show(auth()->user()->user_id);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = ModelsUser::where('user_id', $id)->get()[0];

        $totals = Sales::where('sale_user_fk', $user->user_id)
                        ->join('global_payments', 'monthly_payment_date', '=', 'sale_id')
                        ->sum('monthly_total');

        $totalPaid = Sales::where('sale_user_fk', $user->user_id)
                        ->join('global_payments', 'monthly_payment_date', '=', 'sale_id')
                        ->sum('monthly_paid');

        $totalFromMothPayment = Sales::where('sale_user_fk', $user->user_id)
                        ->join('global_payments', 'monthly_payment_date', '=', 'sale_id')
                        ->sum('monthly_payment');

        return view('components.single-client', [
            'user' => $user,
            'totals' => ($totals - $totalPaid - $totalFromMothPayment),
            'saledate' =>
            Sales::where('sale_user_fk', $user->user_id)
                ->join('payments', 'payment_date', '=', 'sale_id')
                ->orderBy('sale_date', 'DESC')->get()
        ]);
    }


    public function purshaseDetail(Request $request) {

        $saleDetailsId = Sales::where('sale_user_fk', $request->input('user'))
                        ->where('sale_date', $request->input('date'))
                        ->get()[0];

        $saledProducts = SaledProducts::where('saled_date', $saleDetailsId['sale_id'])
                        ->orderBy('saled_date', 'DESC')->get();

        $user = ModelsUser::where('user_id', $saleDetailsId['sale_user_fk'])->get();

        $totalSaledFromDay = SaledProducts::where('saled_date', $saleDetailsId['sale_id'])
                                                        ->where('saled_receiver', '')
                                                        ->sum('saled_total');

        $totalCalculatedPayment =
                ModelsPayments::where('payment_date', $saleDetailsId['sale_id'])
                    ->selectRaw('(payment_total_day-payment_paid_day) as totalpaymentday')->get()[0];

        $monthPayment = ModelsPayments::where('payment_date', $saleDetailsId['sale_id'])
                                                            ->pluck('payment_month')[0];

        return view('components.user-components.details', [
            'user' => $user[0],
            'date' => $saleDetailsId,
            'details' => $saledProducts,
            'total' => (float) ($totalSaledFromDay),
            'totalpaymentday' => $totalCalculatedPayment['totalpaymentday'],
            'monthpayment' => $monthPayment
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $userDetail = ModelsUser::where('user_id', $id)->get();

        return view('components.forms.insertProducts', [
            'products' => Product::orderBy('product_name', 'ASC')->get(),
            'user' => $userDetail
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
        $currDate = date(now()->format('Y-m-d'));
        $date = Sales::where('sale_date', $currDate)
                        ->where('sale_user_fk', $request['user_id'])
                        ->pluck('sale_date');

        if(empty($date[0])) {
            Sales::create([
                'sale_date' => date(now()->format('Y-m-d')),
                'sale_user_fk' => $request->input('user_id')
            ]);
        }

        return view('components.forms.confirm-sale', [
            'products' => $request->input('products')
        ]);
    }


    static public function seeIfDateExistsForUser($user_id) {
        $currDate = date(now()->format('Y-m-d'));
        $date = Sales::where('sale_date', $currDate)
                        ->where('sale_user_fk', $user_id)->get();

        return $date[0]['sale_id'];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    static public function store()
    {
        foreach(request()->input('products') as $key => $value) {
            $price =  Product::where('product_name', $key)->pluck('product_price');

            SaledProducts::create([
                'saled_name' =>  $key,
                'saled_qtty' => (int) $value,
                'saled_price' => (float) $price[0],
                'saled_total' => (float) ($value * $price[0]),
                'saled_saler' => auth()->user()->name,
                'saled_receiver' => '',
                'saled_date' => User::seeIfDateExistsForUser(request()->input('user_id')),
            ]);
        }

        usleep(0.2);

        User::insertSalesFromDay(request()->input('user_id'));
        User::insertSalesFromMonth(request()->input('user_id'));

        $route = 'user/' . request()->input('user_id');

        return redirect($route)
                ->with('venda_cadastrada', 'OK nova venda cadastrada!');

    }


    static public function insertSalesFromDay($user_id) {

        $idFromDay = User::seeIfDateExistsForUser($user_id);

        $totalFromDay = SaledProducts::where('saled_date', $idFromDay)->sum('saled_total');

        $paymentsTable = ModelsPayments::where('payment_date', $idFromDay)->get();

        if(empty($paymentsTable[0])) {
            ModelsPayments::create([
                'payment_date' => $idFromDay,
                'payment_total_day' => (float) $totalFromDay,
                'payment_paid_day' => 0,
                'payment_month' => 0
            ]);

        } else {
            ModelsPayments::where('payment_date', $idFromDay)
                ->update([
                    'payment_total_day' => (float) $totalFromDay
                ]);
        }

    }

    static public function insertSalesFromMonth($user_id) {

        $dateForUser = User::seeIfDateExistsForUser($user_id);

        $paymentFromMonth =
             GlobalPayments::where('monthly_payment_date', $dateForUser)->get();

        $monthTotal = ModelsPayments::where('payment_date', $dateForUser)
                                                        ->sum('payment_total_day');

        $monthTotalPaid =
                ModelsPayments::where('payment_date', $dateForUser)
                                                        ->sum('payment_paid_day');

        if(empty($paymentFromMonth[0])) {
            GlobalPayments::create([
                'monthly_payment_date' => $dateForUser,
                'monthly_total' => $monthTotal,
                'monthly_paid' => 0,
                'monthly_payment' => 0
            ]);
        } else {
            GlobalPayments::where('monthly_payment_date', $dateForUser)
                ->update([
                    'monthly_total' => $monthTotal,
                ]);
        }

    }


    public function destroysale()
    {
        $dateofTheSale = request()->input('saled_date');
        $valueofTheSale = request()->input('saled_total');

        SaledProducts::where('saled_id', request()->input('saled_id'))->delete();

        $paymentToUpdate = ModelsPayments::where('payment_date', $dateofTheSale)
                                                    ->pluck('payment_total_day')[0];

        $monthPaymentToUpdate =
             GlobalPayments::where('monthly_payment_date', $dateofTheSale)
                                                    ->pluck('monthly_total')[0];

        ModelsPayments::where('payment_date', $dateofTheSale)
                ->update([
                    'payment_total_day' => ($paymentToUpdate - $valueofTheSale)
                ]);

        GlobalPayments::where('monthly_payment_date', $dateofTheSale)
                ->update([
                    'monthly_total' => ($monthPaymentToUpdate - $valueofTheSale)
                ]);

        if(empty(SaledProducts::where('saled_date', $dateofTheSale)->get()[0])) {
            $routeToReturn = "user/". request()->input('user_id');
            Sales::where('sale_id', $dateofTheSale)->delete();

            return redirect($routeToReturn)->with('deletado', 'Venda e data deletados!');
        }

        return back()->with('deletado', 'Venda deletada!');

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteClient($id)
    {

        ModelsUser::where('user_id', $id)->delete();

        return back();
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
