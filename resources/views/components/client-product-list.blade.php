@if (!auth()->user()->isadmin && !auth()->user()->isfunc)
    <div class="alert alert-dark mt-2" role="alert">
        <b>Acompanhe sua situação abaixo.</b>
    </div>
@endif

<div
    {{-- class="alert alert-dark mt-3 d-flex justify-content-around" role="alert"> --}}
    class="alert alert-dark mt-3 d-flex justify-content-end" role="alert">

    {{-- <select id="pagamentos"
            class="form-select form-select w-25">
        @foreach ($payments as $payment)
            <option active>Pagamentos</option>
            <option value="pagamentos">
                @if ($payment->payment_global > 0)
                    R$ {{ $payment->payment_global }}
                    - {{ $payment->payment_receiver }}
                    - Data: {{ $payment->payment_date }}

                @endif

            </option>

        @endforeach
    </select> --}}

    <div>
    @if ($totalsum < 0)

        <span class="text-success px-3">SALDO POSITIVO</span>
        <p class="text-center">
            <span class="text-white">R$</span>
            <span class="badge text-success" id="total">
                {{ $totalsum }}
            </span>

        </p>

    @elseif ($totalsum > 0)

        <span class="text-white px-3">SALDO DEVEDOR</span>
        <p class="text-center">
            <span class="text-white">R$</span>
            <span class="badge text-danger" id="total">
                {{ $totalsum }}
            </span>

        </p>

    @else
        <span class="text-white">Sem Débitos!</span>

    @endif
    </div>
</div>

<div class="d-flex justify-content-around">

    <div class="col-10">
    <p class="h3 text-center">Compras</p>

    <ul class="list-group">
    @foreach ($sales as $sale)

            <form action="/data" method="get">
                @csrf

                <input type="hidden" name="user" value="{{ $user->user_id }}">
                <input type="hidden"
                    name="date"
                    value="{{ $sale->sale_date }}"
                    >

                <button class="btn btn-outline-dark w-100 py-3 mt-2">

                    <li
                        class="d-flex justify-content-around text-secondary">

                        <span>
                            {{ \Carbon\Carbon::parse($sale->sale_date)
                                            ->format('d/m/Y') }}
                        </span>

                        {{-- @if ($sale->sale_paid == 1)
                        <div>
                            <span class="badge text-success">ok</span>
                        </div>
                        @endif --}}

                        {{-- @if ($sale->sale_paid == 0)
                        <div>
                            <span class="badge text-danger">DÉBITOS</span>
                            <span>R$ {{ $sale->sale_not_paid_value }}</span>
                        </div>
                        @endif --}}

                    </li>

                </button>

            </form>

        @endforeach
        </ul>
    </div>

</div>





