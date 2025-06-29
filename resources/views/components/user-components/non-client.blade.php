<x-header-and-nav>

    <div class="d-flex justify-content-between align-items-center my-4">
        <h2>Vendas Avulsas</h2>
        <a href="{{ route('create-client-avulso') }}" class="btn btn-outline-secondary">Voltar</a>
    </div>

    {{-- Total geral das vendas avulsas --}}
    <div class="text-end mb-3">
        <span class="h4">Total Vendido: R$
            {{ number_format($salesWithProducts->sum('saled_total'), 2, ',', '.') }}
        </span>
    </div>

    @if ($salesWithProducts->isEmpty())
        <div class="alert alert-warning">Nenhuma venda avulsa registrada.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Vendedor</th>
                    <th>Total (R$)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesWithProducts as $sale)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($sale->sale_date)->format('d/m/Y') }}</td>
                        <td>{{ $sale->saled_name }}</td>
                        <td>{{ $sale->saled_qtty }}</td>
                        <td>{{ $sale->saled_saler }}</td>
                        <td>{{ number_format($sale->saled_total, 2, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</x-header-and-nav>
