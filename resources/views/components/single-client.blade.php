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


            <li class="list-group-item d-flex justify-content-between">

                <div>
                    <p class="h3 text-center">
                        {{ $user->name }}
                    </p>
                </div>

                <div>
                    <a href="/autenticado"
                       class="btn btn-primary-outline px-5 py-3">Voltar</a>
                </div>

            </li>

        </ul>

    </div>

    <div class="d-flex justify-content-between mt-3">
        @if (auth()->user()->isadmin || auth()->user()->isfunc)

            <div>
                <a href="/insertproducts/{{ $user->user_id }}"
                class="btn btn-danger py-3">Nova Venda</a>
            </div>

            <div>

                <a href="/pagamentos/{{ $user->user_id }}"
                        class="btn btn-success py-3">Pagamentos</a>

            </div>

            @if (auth()->user()->isadmin)
            <div>

                <form action="/updatepassword" method="get">
                    @csrf

                    <input type="hidden"
                           name="user_id"
                           value="{{ $user->user_id }}">

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

</x-header-and-nav>
