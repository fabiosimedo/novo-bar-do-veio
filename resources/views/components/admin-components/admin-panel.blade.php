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

        @if (auth()->user()->isadmin)
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

        @if (auth()->user()->isfunc)
            <div class="d-flex justify-content-between py-3">
                    <a href="/create"
                        class="btn btn-primary-outline py-4 px-5 mt-2 mb-3">Usuário</a>

                    <a href="/create/avulso"
                        class="btn btn-primary-outline py-4 px-5 mt-2 mb-3">Venda Avulso</a>

            </div>
        @endif


    </div>

    @foreach ($users as $user)
        <ul class="list-group">
           <a href="user/{{ $user->user_id }}"
              style="text-decoration: none"
              value="{{ $user->name }}"
              id="user-ancor-tag"
              class=""
              >

                @if (! $user->isadmin)
                    <li
                        class="list-group-item mt-1 py-3 d-flex justify-content-between">
                            <span id="user-name">{{ $user->name }}</span>

                        @if (auth()->user()->isadmin)
                            <form action="deleteclient/{{ $user->user_id }}"
                                method="post"
                                style="text-decoration: none"
                                id="delete-client"
                            >
                            @csrf

                                <button
                                    class="text-danger"
                                    style=
                                    "padding: 0;
                                    border: none;
                                    background: none;">Deletar</button>
                            </form>
                        @endif

                    </li>
                @endif

           </a>
        </ul>
    @endforeach

</x-header-and-nav>

<script>
    const deleteClient = document.querySelectorAll('#delete-client')

    deleteClient.forEach(e => {
        e.addEventListener('click', e => {
            e.preventDefault()
            e.target.parentElement.parentElement.classList.add('border', 'border-danger')

            setTimeout(() => {
                if(confirm('Você quer deletar esse usuáio?')) {
                    e.target.parentElement.submit()
                } else {
                    e.target.parentElement.parentElement.classList.remove('border', 'border-danger')
                }
            }, 400)

        })

    })

</script>
