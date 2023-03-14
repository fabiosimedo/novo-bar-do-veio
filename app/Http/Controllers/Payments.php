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
                            ->where('payment_date', $date[0])
                            ->sum('payment_value');

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

    public static function showTotalFromDate($date, $user) {
        $sum = SaledProducts::where('saled_date', $date)
                        ->where('saled_client', $user)
                        ->selectRaw('sum(saled_qtty * saled_price) as TotalPayments')
                        ->pluck('TotalPayments');

        return $sum[0];

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

    public static function showSubTotalPayment($date, $user) {

        $subtotal = SaledProducts::where('saled_date', $date)
                            ->where('saled_client', $user)
                            ->where('saled_paid', 0)
                            ->selectRaw('sum(saled_qtty * saled_price) as TotalPayments')
                            ->pluck('TotalPayments');

        return $subtotal[0];

    }


    public static function paymentReceiver($date, $user) {
        $paid = SaledProducts::where('saled_date', $date)
                        ->where('saled_client', $user)
                        ->where('saled_paid', 0)
                        ->get();

                        return $paid;

        $allpaids = [];

        foreach($paid as $teste) {
            array_push($allpaids, $teste->saled_paid);

        }

        // foreach($allpaids as $notpaid)
            // var_dump($notpaid);

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

        $saleDate = Sales::where('sale_date', request()->input('datavenda'))
                    ->where('user_fk', request()->input('client'))
                    ->get();

        $notpaid = SaledProducts::where('saled_date', $saleDate[0]->sale_date)
                    ->where('saled_client', request()->input('client'))
                    ->where('saled_paid', 0)
                    ->get();

        foreach($notpaid as $paiyng) {

            Sales::where('sale_date', request()->input('datavenda'))
                    ->where('user_fk', request()->input('client'))
                    ->update([ 'sale_paid' => 1 ]);

            SaledProducts::where('saled_date', $saleDate[0]->sale_date)
                            ->where('saled_client', request()->input('client'))
                            ->where('saled_receiver', '')
                            ->where('saled_paid', 0)
                            ->update(['saled_receiver' => auth()->user()->name]);

            SaledProducts::where('saled_date', $saleDate[0]->sale_date)
                            ->where('saled_client', request()->input('client'))
                            ->where('saled_paid', 0)
                            ->update(['saled_paid' => 1]);

        }

        return back()
                ->with('payment-for-single-purshase', 'Pagamento realizado para essa data');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payments  $payments
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payments $payments)
    {


        ####### tabela de excluir produtos
        ############### atualizar tabela de datas de acordo com as vendas
        ######## sem vendas pra receber ok com vendas pra receber débito

        // $saleDate = Sales::where('sale_date', request()->input('datavenda'))
        //             ->where('user_fk', request()->input('client'))
        //             ->get();

        // $notpaid = SaledProducts::where('saled_date', $saleDate[0]->sale_date)
        //             ->where('saled_client', request()->input('client'))
        //             ->where('saled_paid', 0)
        //             ->get();

        // $paid = SaledProducts::where('saled_date', $saleDate[0]->sale_date)
        //             ->where('saled_client', request()->input('client'))
        //             ->where('saled_paid', 1)
        //             ->get();

        // if($notpaid) {
        //     Sales::where('sale_date', request()->input('datavenda'))
        //             ->where('user_fk', request()->input('client'))
        //             ->update([ 'sale_paid' => 0 ]);
        // }

        // elseif($paid) {
        //     Sales::where('sale_date', request()->input('datavenda'))
        //             ->where('user_fk', request()->input('client'))
        //             ->update([ 'sale_paid' => 1 ]);
        // }

        ModelsPayments::where('payment_id', request()->input('payment_id'))->delete();

        return back()->with('payment-deleted', 'Pagamento deletado da lista!');
    }
}
