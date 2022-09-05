<x-header-and-nav>
<form method="post" action="/create">
    @csrf

    <fieldset>

    <div class="form-group">
        <label for="nome" class="form-label mt-4">Nome</label>
        <input type="text" name="name" class="form-control" id="nome" placeholder="Cadastrar nome" value="{{ old('name') }}" required>
        @error('name')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="celular" class="form-label mt-4">Celular</label>
        <input type="text" name="celular" class="form-control" id="nome" placeholder="Cadastrar celular" value="{{ old('celular') }}" required>
        @error('celular')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="senha" class="form-label mt-4">Senha</label>
        <input type="password" name="password" class="form-control" id="nome" placeholder="Cadastrar senha" required>
        @error('password')
            <p class="text-danger mt-2">A senha precisa ter entre 6 e 8 caractéres</p>
        @enderror
    </div>


    <button type="submit" class="btn btn-outline-primary mt-4 btn-lg">Cadastrar Cliente</button>
    </fieldset>
</form>
</x-header-and-nav>
