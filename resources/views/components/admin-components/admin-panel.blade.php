<x-header-and-nav>
    <div>
        <p class="h2 text-info mt-3">
            {{ auth()->user()->name }}
            <p> Está visualizando a página de clientes</p>
        </p>
    </div>

    <form action="/logout" method="post" class="d-flex justify-content-end" >
        @csrf

        <button
            type="submit"
            class="btn btn-primary-outline text-danger px-5 py-3 mt-3">SAIR</button>
    </form>

    <div class="d-flex flex-wrap mt-4 mb-4">
        @if (auth()->user()->isadmin)
            <a href="/create"
               class="btn btn-primary-outline py-4">Cria Usuário</a>
            <a href="/addproduct"
               class="btn btn-primary-outline py-4">Inserir Produto</a>
            <a href="/checkstorage"
               class="btn btn-primary-outline py-4">Consultar Estoque</a>
        @endif
    </div>

    @foreach ($users as $user)
        <ul class="list-group">
           <a href="user/{{ $user->user_id }}"style="text-decoration: none">

                <li class="list-group-item mt-1 py-3 d-flex justify-content-between">
                    {{ $user->name }}
                </li>


           </a>
        </ul>
    @endforeach
</x-header-and-nav>
