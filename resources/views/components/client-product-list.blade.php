
<div class="alert alert-dark mt-2" role="alert">
    <b>Acompanhe
        {{ (!auth()->user()->isadmin || !auth()->user()->isadmin) ? 'sua' : 'a' }}
       situação abaixo.
    </b>
</div>

<div class="alert alert-dark d-flex justify-content-end" role="alert">

    <div>
        @if ($totals > 0)
            <span class="text-white m-2">Saldo devedor</span>

            <button class="btn btn-outline-danger px-3">
                <span>R$ </span>
                <span>{{ substr_replace(number_format($totals, 2), ',', -3, -2) }}</span>
            </button>
        @else
            <span class="text-white">Sem Débitos!</span>
        @endif
    </div>

</div>

<div class="d-flex justify-content-around">

    <div class="col-10">
        <p class="h3 text-center">Compras por Data</p>

        <ul class="list-group">
        @if (empty($saledate[0]))
            <p class="d-flex justify-content-around text-info h2 mt-3">
                Sem compras ainda!</p>
        @else
            @foreach ($saledate as $sale)
                <form action="/data" method="get">
                    @csrf

                    <input type="hidden" name="user" value="{{ $sale->sale_user_fk }}">
                    <input type="hidden"
                        name="date"
                        value="{{ $sale->sale_date }}">

                    <button class="btn btn-outline-dark w-100 py-3 mt-2">
                        <li class="d-flex justify-content-around text-secondary">
                            <span>
                                {{ \Carbon\Carbon::parse($sale->sale_date)
                                                ->format('d/m/Y') }}
                            </span>
                                    {{-- lógica para descobrir data da dívida --}}
                        </li>
                    </button>
                </form>
            @endforeach
        @endif

        </ul>
    </div>

</div>





