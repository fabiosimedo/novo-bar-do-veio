@if (!auth()->user()->isadmin && !auth()->user()->isfunc)
    <div class="alert alert-dark mt-2" role="alert">
        <b>Acompanhe sua situação abaixo.</b>
    </div>
@endif

<div
    class="alert alert-dark mt-3 d-flex justify-content-end text-danger" role="alert">

    @if ($sum <= 0)

        <span class="text-white px-3">SALDO POSITIVO</span>
        <span class="text-success" id="total">

    @else

        <span class="text-white px-3">SALDO NEGATIVO</span>
        <span class="text-danger" id="total">

    @endif
        R$ {{ $sum }}
    </span>

</div>

<select class="form-select py-3" aria-label="Default select example">
    <option selected>Consulte aqui seus Pagamentos pela Data</option>
    @foreach ($payments as $payment)

        <option value="1" class="text-secondary h4">
             {{ \Carbon\Carbon::parse($payment->payment_date)
                            ->format('d M Y D') }}
            --------- R$ {{ $payment->payment_value }}
            - ({{ $payment->payment_receiver }})
        </option>

    @endforeach

</select>



@foreach ($sales as $sale)

    @if ($user->user_id === $sale->user_fk)
    <ul class="list-group mt-2">

        <form action="/data" method="post">
            @csrf

            <input type="hidden" name="user" value="{{ $user->user_id }}">
            <input type="hidden"
                   name="date"
                   value="{{ $sale->sale_date }}"
                   >

            <button class="btn btn-outline-dark w-100 py-3">

                <li
                class="d-flex justify-content-around text-secondary">
                    <span>COMPRAS POR DATA</span>
                    <span>
                        {{ \Carbon\Carbon::parse($sale->sale_date)
                                         ->format('d M Y') }}
                    </span>

                </li>

            </button>

        </form>

    </ul>

    @endif

@endforeach
