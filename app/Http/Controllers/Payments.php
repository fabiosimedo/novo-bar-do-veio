<?php

namespace App\Http\Controllers;

use App\Models\Payments as ModelsPayments;
use App\Models\SaledProducts;
use App\Models\Sales;
use App\Models\User;
use App\Models\GlobalPayments;
use App\Http\Controllers\User as UserController;

class Payments extends Controller
{

    public static function updateGlobalPayment($userId, $paymentReceiver) {

        // return Sales::where('sale_user_fk', $userId)
        //     ->join('payments', 'payment_id', '=', 'sale_id')
        //     ->where('sale_date', '<=', date(now()))
        //     ->where('payment_remainder', '>', 0)
        //     ->orderBy('sale_date', 'ASC')->limit(1)
        //     ->get();
        $occurrenceNumberOfLines = Sales::where('sale_user_fk', $userId)
            ->join('payments', 'payment_id', '=', 'sale_id')
            ->where('sale_date', '<=', date(now()))
            ->where('payment_paid', '>', 'payment_day_purchased')
            ->orderBy('sale_date', 'ASC')
            ->get();
        dump($occurrenceNumberOfLines);
        foreach($occurrenceNumberOfLines as $linesToUpdate) {
            // dump($linesToUpdate);
            // Sales::where('sale_user_fk', $userId)
            // ->join('payments', 'payment_id', '=', 'sale_id')
            // ->where('sale_date', '<=', date(now()))
            // ->where('payment_remainder', '>', 0)
            // ->orderBy('sale_date', 'ASC')->limit(1)->update($updates);
        }

    }


    public static function updatePaymentsFromDay() {

        $userId = request()->input('payment_client');
        $paymentReceiver = request()->input('payment_receiver');

        return Payments::updateGlobalPayment($userId, $paymentReceiver) ;

        return back()->with('pagamento-global', 'Ok pagamento recebido!');

    }


    public static function showTotalClientDebit($id)
    {
        return Sales::where('sale_user_fk', $id)
                    ->join('payments', 'payment_id', '=', 'sale_id')
                    ->sum('payment_remainder');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('components.user-components.user-payments', [
            'user' => User::where('user_id', $id)->get()[0],
            'total' => Payments::showTotalClientDebit($id)
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public static function showPayments($id)
    {
        return ModelsPayments::where('payment_paid', $id)->get();
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
        $client = request()->input('user_id');

        $valueToPay = SaledProducts::where('saled_date', $saleDate)
                                   ->where('saled_receiver', '')
                                   ->sum('saled_total');

        SaledProducts::where('saled_date', $saleDate)
                     ->where('saled_receiver', '')
                     ->update([ 'saled_receiver' => auth()->user()->name ]);

        $alreadyPaidFromDay =
         ModelsPayments::where('payment_date', $saleDate)->pluck('payment_paid_day')[0];

        $alreadyPaidFromMonth =
         GlobalPayments::where('monthly_payment_date', $saleDate)->pluck('monthly_paid')[0];

        ModelsPayments::where('payment_date', $saleDate)
                        ->update([
                            'payment_paid_day' => (float) ($alreadyPaidFromDay + $valueToPay)
                        ]);

        GlobalPayments::where('monthly_payment_date', $saleDate)
                ->update([
                    'monthly_paid' => (float) ($alreadyPaidFromMonth + $valueToPay)
                ]);

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
