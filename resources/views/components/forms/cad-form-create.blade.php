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
               value="{{ old('celular') }}" required>

        @error('celular')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="senha" class="form-label mt-4">Senha</label>
        <input type="password" name="password"
               class="form-control"
               placeholder="Cadastrar senha" required>

        @error('password')
            <p class="text-danger mt-2">A senha precisa ter entre 6 e 8 caractéres</p>
        @enderror
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

<div class="text-center mt-4">
    <a onclick="history.back()" class="btn btn-primary-outline mt-4">Voltar</a>
</div>

</x-header-and-nav>
