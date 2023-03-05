<?php

namespace App\Http\Controllers;

use App\Models\Payments as ModelsPayments;
use App\Models\SaledProducts;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class Payments extends Controller
{

    public static function showTotalClientDebit($id)
    {
        $date = Sales::where('user_fk', $id)
                        ->pluck('sale_date');

        if(empty($date[0])) {

            $sum = '0,00';

        } else {

            $payment = ModelsPayments::where('payment_client', $id)
                            ->where('payment_date', $date)
                            ->sum('payment_value');
                            // return $payment;

            if(empty($payment[0])) {

                $sum = SaledProducts::where('saled_client', $id)
                        ->selectRaw('sum(saled_qtty * saled_price) as TotalPayments')
                        ->pluck('TotalPayments');

                return $sum[0];

            } else {

                $total = SaledProducts::where('saled_client', $id)
                        ->selectRaw('sum(saled_qtty * saled_price) as TotalPayments')
                        ->pluck('TotalPayments');

                $sum = ($total[0] - $payment);

            }


        }

        return $sum;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {

        return view('components.user-components.user-payments', [
            'payments' =>
                SaledProducts::where('saled_client', $id)->get(),
            'user' =>
                User::where('user_id', $id)->get(),
            'total' => $this->showTotalClientDebit($id)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $client = request()->input('payment_client');

        ModelsPayments::create([
            'payment_client' => $client,
            'payment_receiver' => request()->input('payment_receiver'),
            'payment_value' => request()->input('payment_value'),
            'payment_remainder' => $this->showTotalClientDebit($client),
            'payment_date' => date(now())
        ]);

        return redirect('user/' . $client)
                ->with('pagamento', 'Pagamento realizado com successo!');
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function edit(Payments $payments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payments $payments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payments $payments)
    {
        //
    }
}
