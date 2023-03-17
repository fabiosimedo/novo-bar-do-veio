<?php

namespace App\Http\Controllers;

use App\Models\Payments as ModelsPayments;
use App\Models\SaledProducts;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class Payments extends Controller
{

    public static function updateSalesPayment($currDate, $user_id) {

        $updateDateAndPaymentStatus = [
            'sale_paid' => 0,
            'sale_total_value' =>
            Payments::showTotalFromDate($currDate, $user_id),
            'sale_not_paid_value' =>
            Payments::showSubTotalPayment($currDate, $user_id)
        ];

        Sales::where('sale_date', $currDate)
                ->where('user_fk', $user_id)
                ->update($updateDateAndPaymentStatus);
    }


    public static function updateGlobalPayment($user_id) {

        $currDate = date(now()->format('Y-m-d'));

        $paymentdate = ModelsPayments::where('payment_client', $user_id)
                                    ->where('payment_date', $currDate)->get();

        if(empty($paymentdate[0]->payment_date)) {
            $notpaid = SaledProducts::where('saled_client', $user_id)
                            ->selectRaw('sum(saled_qtty * saled_price) as Total')
                            ->pluck('Total');

            $arrayFromClient = [
                'payment_client' => $user_id,
                'payment_receiver' => '',
                'payment_value' => 0,
                'payment_remainder' => $notpaid[0],
                'payment_global' => 0,
                'payment_date' => date(now())
            ];

            ModelsPayments::create($arrayFromClient);
        }

        if(isset($paymentdate[0]->payment_date)) {

            $paid = SaledProducts::where('saled_client', $user_id)
                         ->where('saled_paid', 1)
                         ->selectRaw('sum(saled_qtty * saled_price) as Total')
                        ->pluck('Total');

            $notpaid = SaledProducts::where('saled_client', $user_id)
                            ->selectRaw('sum(saled_qtty * saled_price) as Total')
                            ->pluck('Total');

            $updatePayment = [
                'payment_value' => $paid[0] ?? 0,
                'payment_remainder' => $notpaid[0]
            ];

            ModelsPayments::where('payment_client', $user_id)
                            ->where('payment_date', $currDate)
                            ->update($updatePayment);
        }

    }

    public static function showTotalClientDebit($id)
    {

        return ModelsPayments::where('payment_client', $id)
                            ->selectRaw('sum(payment_remainder - payment_value) as Total')
                            ->pluck('Total');

    }

    public static function showTotalFromDate($date, $user) {

        $sum = SaledProducts::where('saled_date', $date)
                        ->where('saled_client', $user)
                        ->selectRaw('sum(saled_qtty * saled_price) as TotalPayments')
                        ->pluck('TotalPayments');

        return $sum[0];

    }

    public static function showSubTotalPayment($date, $user) {

        $subtotal = SaledProducts::where('saled_date', $date)
                            ->where('saled_client', $user)
                            ->where('saled_paid', 0)
                            ->selectRaw('sum(saled_qtty * saled_price) as TotalPayments')
                            ->pluck('TotalPayments');

        return $subtotal[0];

    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $total = $this->showTotalClientDebit($id);

        return view('components.user-components.user-payments', [
            'payments' =>
                SaledProducts::where('saled_client', $id)->get(),
            'user' =>
                User::where('user_id', $id)->get(),
            'total' => $total[0]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = request()->input('payment_client');
        $receiver = request()->input('payment_receiver');
        $paidvalue = request()->input('payment_value');
        $currDate = date(now()->format('Y-m-d'));

        $paymentexists =  ModelsPayments::where('payment_client', $user)
                                ->where('payment_date', $currDate)->get();

        $savedPaymmentValue = $paymentexists[0]->payment_value;
        $savedPaymentGlobal = $paymentexists[0]->payment_global;

        if(empty($paymentexists[0])) {

            ModelsPayments::create([
                'payment_client' => $user,
                'payment_receiver' => $receiver,
                'payment_value' => $paidvalue,
                 'payment_remainder' => 0,
                 'payment_global' => $paidvalue,
                 'payment_date' => date(now())
            ]);

            /// classe que vai retirar valores devidos de sales e saledproducts
        }

        if(isset($paymentexists[0])) {

            ModelsPayments::where('payment_client', $user)
                                ->where('payment_date', $currDate)
                                ->update([
                                    'payment_receiver' => $receiver,
                                    'payment_value' => $paidvalue + $savedPaymmentValue,
                                    'payment_global' => $paidvalue + $savedPaymentGlobal
                                ]);


            /// classe que vai retirar valores devidos de sales e saledproducts
        }

        return redirect('user/' . $user)
                ->with('pagamento', 'Pagamento realizado com successo!');



        // $paymentexists =  ModelsPayments::where('payment_client', $user)
        //                         ->where('payment_date', $currDate)->pluck('payment_global');
        //                         // ->sum('payment_global');

        // $saleNotPaid = Sales::where('user_fk', $user)->where('sale_paid', 0)
        //                         ->sum('sale_not_paid_value');

        //                 // return $saleNotPaid;

        // $saledNotPaid =  SaledProducts::where('saled_date', $currDate)
        //                 ->where('saled_client', $user)
        //                 ->where('saled_paid', 0)
        //                 ->selectRaw('sum(saled_qtty * saled_price) as NotPaidDate')
        //                 ->pluck('NotPaidDate');

        //                 return $saledNotPaid[0];



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function showPayments($id)
    {
        return ModelsPayments::where('payment_client', $id)->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public static function show($id)
    {
        return Sales::where('user_fk', $id)
                    ->orderBy('sale_date', 'DESC')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public static function update()
    {
        $saleDate = request()->input('datavenda');
        $client = request()->input('client');

        $updates = [
            'saled_receiver' => auth()->user()->name,
            'saled_paid' => 1
        ];

        SaledProducts::where('saled_date', $saleDate)
                        ->where('saled_client', $client)
                        ->where('saled_paid', 0)
                        ->update($updates);

        // $notpaid = SaledProducts::where('saled_date', $saleDate)
        //                 ->where('saled_client', $client)
        //                 ->where('saled_paid', 0)
        //                 ->selectRaw('sum(saled_qtty * saled_price) as total')
        //                 ->pluck('total');

        // $paid = SaledProducts::where('saled_date', $saleDate)
        //                 ->where('saled_client', $client)
        //                 ->where('saled_paid', 1)
        //                 ->selectRaw('sum(saled_qtty * saled_price) as total')
        //                 ->pluck('total');

        $attributes = [
            'sale_paid' => 1,
            'sale_total_value' => Payments::showTotalFromDate($saleDate, $client),
            'sale_not_paid_value' => Payments::showSubTotalPayment($saleDate, $client)
        ];

        Sales::where('sale_date', $saleDate)
                ->where('user_fk', $client)
                ->update($attributes);


        return back()
                ->with('payment-for-single-purshase', 'Pagamento realizado para essa data');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        ModelsPayments::where('payment_id', request()->input('payment_id'))->delete();

        return back()->with('payment-deleted', 'Pagamento deletado da lista!');
    }
}
