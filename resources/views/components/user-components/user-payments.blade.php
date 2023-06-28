<x-header-and-nav>

    <p class="h1 text-center">Página de Pagamentos</p>

    <div class="border border-light rounded mt-5">
        <div class="px-3 mt-3 pb-3">
            <p class="h2 text-info">{{ auth()->user()->name }}</p>
            <p>Está registrando um pagamento para </p>
            <div class="d-flex justify-content-around">
                <a class="col-6 text-secondary mt-2 h4"
                    href="/user/{{ $user->user_id }}">

                    {{ $user->name }}</a>

                <button
                    class="btn btn-outline col-6 py-4">

                    @if ($total > 0)

                        <p class="text-danger px-3" id="total">SALDO NEGATIVO</p>
                        <p class="text-danger" id="btn">

                    @endif

                        R$ {{ substr_replace(number_format($total, 2), ',', -3, -2) }}
                    </p></button>

            </div>

        </div>
    </div>


    <form action="/pagamentos" method="post" class="mt-4" id="pagar">
        @csrf

        <div class="form-group mt-4 d-flex flex-column align-items-center">
            <label for="">Pagar saldo negativo total.</label>

            <input type="hidden"
                   name="payment_client" value="{{ $user->user_id }}">
            <input type="hidden"
                   name="payment_receiver" value="{{ auth()->user()->name }}">

            <div class="d-flex justify-content-between mt-4">
                <button type="submit"
                        class="btn btn-success py-5"
                        >Pagar Restante</button>

            </div>
            <a onclick="history.back()"
                   class="btn btn-primary-outline py-5 w-50">Voltar</a>
        </div>

    </form>

</x-header-and-nav>

<script>

    const total = document.querySelector('#total')
    const form = document.querySelector('#pagar')
    const btn = document.querySelector('#btn')

    form.addEventListener('submit', e => {
        e.preventDefault()

        if(confirm(`Pagar valor total de débitos?`))
        {
            e.target.submit()
        }

    })

</script>
