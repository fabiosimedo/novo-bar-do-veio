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
    public static function updatePaymentFromMonth() {

        $userClient = request()->input('payment_client');
        $currDate = date(now()->format('Y-m-d'));

        $totalDebits = Sales::where('sale_user_fk', $userClient)
                            ->join('saled_products', 'saled_date', '=', 'sale_id')
                            ->where('saled_receiver', '')->sum('saled_total');

        Sales::where('sale_user_fk', $userClient)
                        ->join('payments', 'payment_date', '=', 'sale_id')
                        ->where('payment_month', 0)
                        ->update([
                            'payment_month' => 1
                        ]);

        Sales::where('sale_user_fk', $userClient)
                            ->join('saled_products', 'saled_date', '=', 'sale_id')
                            ->where('saled_receiver', '')
                            ->update([
                                'saled_receiver' => auth()->user()->name
                            ]);

        $alreadyPaidFromMonth = Sales::where('sale_user_fk', $userClient)
                    ->where('sale_date', $currDate)
                    ->join('global_payments', 'monthly_payment_date', '=', 'sale_id')
                    ->pluck('monthly_payment')[0];

        Sales::where('sale_user_fk', $userClient)
                    ->join('global_payments', 'monthly_payment_date', '=', 'sale_id')
                    ->where('sale_date', $currDate)
                    ->update([
                        'monthly_payment' => ((float) $alreadyPaidFromMonth + $totalDebits)
                    ]);


        return redirect('user/'.$userClient)->with('pagamento-mensal', 'Pagamento abatido do total!');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $total = Sales::where('sale_user_fk', $id)
                        ->join('global_payments', 'monthly_payment_date', '=', 'sale_id')
                        ->sum('monthly_total');

        $totalPaid = Sales::where('sale_user_fk', $id)
                        ->join('global_payments', 'monthly_payment_date', '=', 'sale_id')
                        ->sum('monthly_paid');

        $totalFromMothPayment = Sales::where('sale_user_fk', $id)
                        ->join('global_payments', 'monthly_payment_date', '=', 'sale_id')
                        ->sum('monthly_payment');

        return view('components.user-components.user-payments', [
            'user' => User::where('user_id', $id)->get()[0],
            'total' => (float) ($total - $totalPaid - $totalFromMothPayment)
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

        $valueToPay = SaledProducts::where('saled_date', $saleDate)
                                   ->where('saled_receiver', '')
                                   ->sum('saled_total');

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

        SaledProducts::where('saled_date', $saleDate)
                ->where('saled_receiver', '')
                ->update([ 'saled_receiver' => auth()->user()->name ]);

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
