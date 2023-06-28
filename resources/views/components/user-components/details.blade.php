<x-header-and-nav>

    <div class="d-flex justify-content-around">
        <div class="py-2">
            <span class="h4">{{ $user->name }}</span>
            <p class="text-center">
                {{ \Carbon\Carbon::parse($date->saled_date)
                    ->format('d/m/Y') }}
            </p>
        </div>

        <div class="text-end">
            <a href="/user/{{ $user->user_id }}"
                class="btn btn-outline-info mt-3 px-5">VOLTAR</a>
        </div>
    </div>


    <ul class="list-group mt-3 mb-3">
        <li class="list-group-item d-flex justify-content-around">

            <div class="text-center">
                <span>
                    @if (($total > 0) || ($monthpayment == 0))
                        <p>R$
                            <span class="text-danger">
                                {{ substr_replace(number_format($total, 2), ',', -3, -2) }}
                                <p>Saldo Devedor</p>
                            </span>
                        </p>
                    @else
                        <span>
                            <span class="h4 text-white" id="total">
                                Tudo pago aqui!
                            </span>
                        </span>
                    @endif
                </span>
            </div>

            @if (auth()->user()->isadmin || auth()->user()->isfunc)

                @if (($total > 0) || ($monthpayment == 0))
                <div>
                    <form action="/payallsale" method="post">
                        @csrf

                        <input type="hidden" name="datavenda"
                                value="{{ $details[0]->saled_date }}">
                        <input type="hidden" name="user_id"
                                value="{{ $user->user_id }}">

                            <button class="btn btn-outline-info p-3 mt-4">
                                Pagar Restante
                            </button>
                    </form>
                </div>
                @endif

            @endif

        </li>
    </ul>



    <table class="table">
        <thead>
          <tr>
            <th scope="col">Produto</th>
            <th scope="col"></th>
            <th scope="col">Total</th>
            <th scope="col">Vendeu</th>
            <th scope="col">Pago</th>
            @if (auth()->user()->isadmin || auth()->user()->isfunc)
                <th scope="col"></th>
            @endif
          </tr>
        </thead>
        <tbody>
            @foreach ($details as $detail)
                <tr class="">
                    <th scope="row">{{ $detail->saled_name }}</th>
                    <td>{{ $detail->saled_qtty }}</td>
                    <td>
                        RS <span  id="single-sale">
                            {{ substr_replace($detail->saled_total, ',', -3, -2) }}
                        </span>
                    </td>
                    <td>{{ substr($detail->saled_saler, 0, 6) }}</td>
                    <td>
                        @if ($detail->saled_receiver)
                            <span class="text-success">
                                    {{ substr($detail->saled_receiver, 0, 6) }}</span>
                        @endif
                    </td>
                    @if (auth()->user()->isadmin || auth()->user()->isfunc)
                        <td>
                            @if (! $detail->saled_receiver)
                            <form method="post" action="/destroysale" id="deleteForm">
                                @csrf

                                <button style="padding: 0;
                                            border: none;
                                            background: none;
                                            color: red">X</button>

                                <input type="hidden" name="saled_id"
                                    value="{{ $detail->saled_id }}">
                                <input type="hidden" name="saled_date"
                                    value="{{ $detail->saled_date }}">
                                <input type="hidden" name="saled_total"
                                    value="{{ $detail->saled_total }}">
                                <input type="hidden" name="user_id"
                                    value="{{ $user->user_id }}">
                            </form>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
      </table>

    <script>

        document.querySelectorAll('#deleteForm').forEach(e => {
            e.addEventListener('submit', e => {

                e.preventDefault()
                const element = e.target.parentElement.parentElement
                console.log(element)
                element.classList.add('border', 'border-danger')
                const productName = element.children[0].innerText
                const qtty = element.children[1].innerText

                setTimeout(() => {
                    if(confirm("DELETAR ESSE PRODUTO?\n\n Produtos - "
                                +productName+"\n Quantidade - "+qtty)) {
                        e.target.submit()
                    } else {
                        e.target.parentElement.parentElement.classList.remove('border', 'border-danger')
                    }
                }, 500);
            })
        })

    </script>

</x-header-and-nav>

