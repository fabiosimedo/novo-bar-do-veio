{{-- @dd($details) --}}
<x-header-and-nav>

@if (isset($details[0]))
    <div class="d-flex justify-content-around">
        <div class="h2 py-3">
            {{ \Carbon\Carbon::parse($details[0]->saled_date)
                ->format('d M Y - D') }}

        </div>
        <div class="text-end">
            <button href="/user/{{ $details[0]->saled_client }}"
            class="btn btn-outline-info mt-3 px-5">VOLTAR</button>
        </div>
    </div>

    <ul class="list-group mt-3 mb-3">
        <a href="/user/{{ $details[0]->saled_client }}"
            class="text-decoration-none text-uppercase">
            <li class="list-group-item d-flex justify-content-around">

                <div class="text-start">
                   <p>Total dessa data</p>
                    <span class="btn btn-outline-danger px-3">
                        R$<span class="h3" id="total"></span>,00
                    </span>
                </div>

                <div>
                    <form action="payallsale" method="post">
                        @csrf

                        <input type="hidden" name="datavenda"
                            @foreach ($details as $detail)
                                value="{{ $detail }}"
                            @endforeach >

                        <button class="btn btn-outline-info p-3 mt-4">Pagar</button>
                    </form>
                </div>

            </li>
        </a>
    </ul>

    <ul class="list-group mt-3">
    @foreach ($details as $detail)
        <li class="list-group-item bg-dark">
            <p class="h6">Vendido por
                <span class="text-info px-3">
                    {{ $detail->saler }}
                </span></p>

        </li>
        <li
            class="list-group-item d-flex justify-content-around">
            <span class="h4 col-6">{{ $detail->saled_name }}</span>
            <span class="h4 col-2">{{ $detail->saled_qtty }}</span>
            <span class="h4 col-3 text-white">
                RS <span  id="single-sale">
                    {{ $detail->saled_qtty * $detail->saled_price }}
                </span>,00
            </span>
            @if (auth()->user()->isadmin || auth()->user()->isfunc)
            <form method="post" action="/destroysale" class="col-1" id="deleteForm">
                @csrf

                <button class="btn btn-danger px-3">X</button>
                <input type="hidden" name="saled_id"
                       value="{{ $detail->saled_id }}">
                <input type="hidden" name="user_id"
                       value="{{ $detail->saled_client }}">
            </form>
            @endif
        </li>
    @endforeach
    </ul>

@else

    <p class="h2 py-2 text-danger text-center">Sem registros de venda para esta data </p>
    <p class="h4 text-center">{{ request()->input('date') }}</p>

    <form action="/destoydate" method="post" class="text-center mt-3">
        @csrf

        <input type="hidden" name="user_id" value="{{ request()->input('user') }}">
        <input type="hidden" name="date" value="{{ request()->input('date') }}">

        <input type="submit"
                class="btn btn-info p-5"
                value="Deletar Data">

    </form>

@endif

    <script>

        const span = document.querySelectorAll('#single-sale')
        const spanTotal = document.querySelector('#total')
        const soma = []

        span.forEach(el => {
            soma.push(parseFloat(el.innerText))
        })

        const total = soma.reduce((total, currentElement) => total + currentElement)
        spanTotal.innerText = total

        document.querySelectorAll('#deleteForm').forEach(e => {
            e.addEventListener('submit', e => {
                e.preventDefault()
                const element = e.target.parentElement
                element.classList.add('border', 'border-danger')
                const productName = element.children[0].innerText
                const qtty = element.children[1].innerText

                setTimeout(() => {
                    if(confirm("DELETAR ESSA PRODUTO?\n\n Produtos - "
                                +productName+"\n Quantidade - "+qtty)) {
                        e.target.submit()
                    } else {
                        e.target.parentElement.classList.remove('border', 'border-danger')
                    }
                }, 500);
            })
        })

    </script>

</x-header-and-nav>
