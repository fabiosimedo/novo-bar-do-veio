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

<div class="d-flex justify-content-around">

    <div class="col-5">
    <p class="h3 text-center">Compras</p>
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
    </div>

    <div class="col-5">
        <p class="h3 text-center">Pagamentos</p>
        <ul class="list-group">
        @foreach ($payments as $payment)

            <li class="list-group-item text-secondary">
                {{ \Carbon\Carbon::parse($payment->payment_date)
                                    ->format('d M Y D') }}
                    <span class="badge badge-pill badge-secondary mt-2">
                        R$ {{ $payment->payment_value }}
                    </span>

                {{-- <p>
                    <span class="badge badge-pill badge-secondary">
                            {{ $payment->payment_receiver }}</span></p> --}}
            </li>

        @endforeach
        </ul>
    </div>

</div>





