<x-header-and-nav>
    <div class="d-flex justify-content-between">
        <div>

            <p class="h2 text-info mt-3">
                {{ auth()->user()->name }}
                <p> Está visualizando a página de clientes</p>
            </p>

        </div>
        <form action="/logout" method="post" >
            @csrf

            <button
                type="submit"
                class="btn btn-primary-outline text-danger px-5 py-3 mt-3">SAIR</button>
        </form>
    </div>


    <div>

        @if (auth()->user()->isfunc || auth()->user()->isadmin)
        <div class="d-flex justify-content-between py-3">

            <a href="/create"
                class="btn btn-primary-outline py-2 px-3 mt-2">Usuário</a>
            <a href="/addproduct"
               class="btn btn-primary-outline py-2 px-3 mt-2">Produto</a>
            <a href="/checkstorage"
               class="btn btn-primary-outline py-2 px-3 mt-2">Estoque</a>

        </div>
        <div>

            <a href="/create/avulso"
               class="btn btn-primary-outline py-2 px-3 m-2 w-100">Venda Avulso</a>

        </div>
        @endif

    </div>

    @foreach ($users as $user)
        <ul class="list-group">
           <a href="user/{{ $user->user_id }}" style="text-decoration: none">

                <li class="list-group-item mt-1 py-3 d-flex justify-content-between">
                    {{ $user->name }}
                </li>


           </a>
        </ul>
    @endforeach

</x-header-and-nav>
