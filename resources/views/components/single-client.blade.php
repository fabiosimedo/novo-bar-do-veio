<x-header-and-nav>

    <div>

        <ul class="list-group">

            @if (auth()->user()->isadmin || auth()->user()->isfunc)

                <li class="list-group-item">
                    <b class="text-info">
                        {{ auth()->user()->name }}
                    </b> está visualizando a página de:
                </li>

                <li class="list-group-item d-flex justify-content-between">

                    <div>

                        <a href="/editusername/{{ $user->user_id }}">
                            <p class="h3 text-center">
                                {{ $user->name }}
                            </p>
                        </a>

                        @if ($user->celular === null)
                            <small id="emailHelp" class="form-text text-muted">
                                Usuário sem celular cadastrado!
                            </small>
                        @endif
                    </div>

                    <div>
                        <a href="/autenticado"
                        class="btn btn-primary-outline px-5 py-3">Voltar</a>
                    </div>

                </li>

            @else
                <div class="d-flex justify-content-between">
                    <div class="mt-3">
                        <p>Bem Vindo(a)</p>
                        <p class="h1 text-success">{{ auth()->user()->name }}</p>
                    </div>
                    <form action="/logout" method="post" >
                        @csrf

                        <button
                            type="submit"
                            class="btn btn-primary-outline text-danger px-5 py-3">SAIR</button>
                    </form>
                </div>
            @endif
        </ul>

    </div>

    <div class="d-flex justify-content-between mt-3">
        @if (auth()->user()->isadmin || auth()->user()->isfunc)

            <div>
                <a href="/insertproducts/{{ $user->user_id }}"
                   class="btn btn-danger py-3">Nova Venda</a>
            </div>

            @if ($totals > 0)
                <div>
                    <a href="/pagamentos/{{ $user->user_id }}"
                            class="btn btn-success py-3">Pagamentos</a>
                </div>
            @endif


            @if (auth()->user()->isadmin || auth()->user()->isfunc)

                @if($user->celular === null)
                    <div>
                        <form action="/updatepasswordandcellphone" method="get">
                            @csrf

                            <input type="hidden"
                                name="user_id"
                                value="{{ $user->user_id }}">

                            <input type="submit"
                                class="btn btn-info py-3" value="Adicionar Celular" />
                        </form>
                    </div>
                @else
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

        @endif

    </div>

    <div>
        <x-client-product-list
            :user="$user"
            :totals="$totals"
            :saledate="$saledate" />
    </div>

</x-header-and-nav>
