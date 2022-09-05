<x-header-and-nav>
<form action="/entrar" method="post">
    @csrf

    <fieldset>

    <div class="form-group">
        <label for="exampleInputEmail1" class="form-label mt-4">Telefone (sem ddd)</label>
        <input type="text" name="celular" class="form-control" id="telefone" aria-describedby="telefoneHelp" placeholder="Digite seu telefone (ex: xxxxxxxxx) nove dígitos" value="{{ old('celular') }}">
        <small id="emailHelp" class="form-text text-muted">Use um telefone válido caso perca sua senha.</small>
        @error('celular')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1" class="form-label mt-4">Senha</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Digite sua senha (mínimo seis dígitos)">
        @error('password')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit" class="btn btn-outline-primary mt-4 btn-lg">Entrar</button>
    </fieldset>
</form>
</x-header-and-nav>
