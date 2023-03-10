<x-header-and-nav>

    <p class="h1 text-center">Página de Pagamentos</p>

    <div class="border border-light rounded mt-5">
        <div class="px-3 mt-3 pb-3">
            <p class="h2 text-info">{{ auth()->user()->name }}</p>
            <p>Está registrando um pagamento para </p>
            <div class="d-flex justify-content-around">
                <a class="col-6 text-secondary mt-4"
                    href="/user/{{ $user[0]->user_id }}">

                    {{ $user[0]->name }}</a>

                <button
                    class="btn btn-outline col-6 py-4">

                    @if ($total <= 0)

                        <p class="text-white px-3">SALDO POSITIVO</p>
                        <p class="text-success" id="total">

                    @else

                        <p class="text-danger px-3">SALDO NEGATIVO</p>
                        <p class="text-danger" id="total">

                    @endif
                    R$ {{ $total }}</p></button>
            </div>

        </div>
    </div>


    <form action="/pagamentos" method="post" class="mt-4" id="pagar">
        @csrf
        <div class="form-group mt-4 d-flex flex-column align-items-center">
            <label for="">Adicione um pagamento para data de hoje.</label>

            <input type="hidden"
                   name="payment_client" value="{{ $user[0]->user_id }}">
            <input type="hidden"
                   name="payment_receiver" value="{{ auth()->user()->name }}">

            <input type="number" name="payment_value"
                   class="form-control mb-5 mt-4 w-50 py-3"
                   placeholder="Valor do Pagamento"
                   value="{{ old('payment_value') }}"
                   pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                   id="valor"
                   required>

            <div class="d-flex justify-content-between">
                <button type="submit"
                        class="btn btn-success py-5"
                        id="btn"
                        >Confirmar Pagamento</button>

            </div>
            <a onclick="history.back()"
                   class="btn btn-primary-outline py-5 w-50">Voltar</a>
        </div>

        @error('preco')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror

    </form>

</x-header-and-nav>

<script>

    const valor = document.querySelector('#valor')
    const form = document.querySelector('#pagar')
    const btn = document.querySelector('#btn')

    form.addEventListener('submit', e => {
        e.preventDefault()

        if(confirm(`O valor do pagamento está correto?\n Valor: R$${valor.value}`))
        {
            btn.disabled = true
            e.target.submit()
        }

    })

</script>
