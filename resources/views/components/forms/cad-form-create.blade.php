<x-header-and-nav>

@if (request()->routeIs('create-client'))
<form method="post" action="/create">

    @csrf

    <div class="form-group">
        <label for="nome" class="form-label mt-4">Nome</label>
        <input type="text" name="name"
               class="form-control"
               placeholder="Cadastrar nome"
               value="{{ old('name') }}" required>

        @error('name')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="celular" class="form-label mt-4">Celular</label>
        <input type="text" name="celular"
               class="form-control" placeholder="Cadastrar celular"
               value="{{ old('celular') }}" id="celular" required>

        @error('celular')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="senha" class="form-label mt-4">Senha</label>
        <input type="password" name="password"
               class="form-control"
               placeholder="Cadastrar senha" id="senha" required>

        @error('password')
            <p class="text-danger mt-2">A senha precisa ter entre 6 e 8 caractéres</p>
        @enderror

        <div class="text-center">
            <input type="checkbox" class="mt-4" name="client_without_password" id="check">
            <span class="py-2 px-4">Cliente sem celular e senha.</span>

        </div>
    </div>

    <button type="submit"
            class="btn btn-outline-primary mt-4 btn-lg"
            style="width: 100%">Cadastrar Cliente</button>

</form>
@endif

@if (request()->routeIs('update-password'))
<form method="post" action="/newpassword">

    @csrf

    <p class="h5 text-secondary mt-3">Alterando a senha de </p>
    <p class="h1 text-secondary">{{ $user[0]->name }}</p>

    <div class="form-group">
        <label for="senha" class="form-label mt-4">
            Editar Senha</label>

        <input type="password" name="password"
                class="form-control"
                placeholder="Nova senha" required>

        @error('password')
            <p class="text-danger mt-2">A senha precisa ter entre 6 e 8 caractéres</p>
        @enderror
    </div>

        <input type="hidden" name="user_id" value="{{ $user[0]->user_id }}">

    <button class="btn btn-outline-info mt-4 btn-lg">Editar Senha</button>
</form>
@endif

@if (request()->routeIs('create-client-avulso'))
<form action="/create/confirm">


    <div class="form mt-2 mb-2">
        <div class="pb-2 text-bold">
            <button class="btn btn-outline-info mb-2">
                {{ auth()->user()->name }}</button>

                <span class="h4"> registrando venda Avulsa</span>

            @if (auth()->user()->isadmin)

                <p class="mt-3 text-center"><a href="/seeavulso"
                        class="btn btn-outline-white">

                        Visualizar Vendas Avulsas</a></p>

            @endif

        </div>

        <form method="post"
                action="{{ request()->routeIs('insertproducts-post') }}"
                id="form"
                class="form-group mt-3">
                @csrf

            <div class="d-flex justify-content-around flex-wrap">
                @foreach ($products as $product)
                <div class="mt-2 col-6 p-3">
                    <p class="h4">{{ $product->product_name }}</p>
                    <input type="text"
                            name="products[{{ $product->product_name }}]"
                            value="{{ old('products[]') }}"
                            placeholder="Quantidade"
                            class="form-control-lg"
                            id="form-avulso"
                            style="display: block;
                                margin-left: auto;
                                margin-right: auto;
                                width: 110%;"
                    >
                </div>
                @endforeach
            </div>

            <button type="submit"
                    class="btn btn-outline-primary mt-4 btn-lg py-3"
                    style="width: 100%"
                    data-toggle="modal"
                    data-target="#exampleModal">Cadastrar Venda</button>
        </form>

    </div>

@endif

<div class="text-center mt-4">
    <a onclick="history.back()" class="btn btn-primary-outline mt-4">Voltar</a>
</div>


<script>
    const check = document.querySelector('#check')
    const celular = document.querySelector('#celular')
    const senha = document.querySelector('#senha')

    check.addEventListener('change', e => {
        console.log(e)
        celular.required = false
        senha.required = false
    })

</script>


</x-header-and-nav>
