<x-header-and-nav>

    <div>

        <ul class="list-group">

            @if (auth()->user()->isadmin || auth()->user()->isfunc)

                <li class="list-group-item">
                    <b class="text-info">
                        {{ auth()->user()->name }}
                    </b> está visualizando a página de:
                </li>

            @endif


            <li class="list-group-item mt-1 d-flex justify-content-between">

                <div>
                    <p class="h3 text-center">
                        {{ $user[0]->name }}
                    </p>
                </div>

                <div>
                    <a href="/autenticado"
                       class="btn btn-primary-outline px-5 py-4 mt-2">Voltar</a>
                </div>

            </li>

        </ul>

    </div>

    <div class="d-flex justify-content-between mt-3">
        @if (auth()->user()->isadmin || auth()->user()->isfunc)

            <div>
                <a href="/insertproducts/{{ $user[0]->user_id }}"
                class="btn btn-danger py-3">Nova Venda</a>
            </div>

            <div>

                {{-- @if($sum > 0) --}}
                <a href="/pagamentos/{{ $user[0]->user_id }}"
                        class="btn btn-success py-3">Pagamentos</a>
                {{-- @endif --}}

            </div>

            @if (auth()->user()->isadmin)
            <div>

                <form action="/updatepassword" method="get">
                    @csrf

                    <input type="hidden"
                           name="user_id"
                           value="{{ $user[0]->user_id }}">

                    <input type="submit"
                            class="btn btn-info py-3" value="Edita Senha" />
                </form>

            </div>
            @endif

        @endif

    </div>

    <div>
        <x-client-product-list
            :user="$user"
            :sales="$sales"
            :products="$products"
            :sum="$sum"
            :payments="$payments"
             />
    </div>

    <script>

        const alerta = document.querySelector('#alertMessage')
        setTimeout(() => {
            alerta.remove()
        }, 5000);

    </script>

</x-header-and-nav>
