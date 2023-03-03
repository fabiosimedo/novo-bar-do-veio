<x-header-and-nav>
<form action="/entrar" method="post">
    @csrf

    <fieldset>

        <div class="form-group">
            <label for="exampleInputEmail1"
                   class="form-label mt-4">Telefone (Com ddd)</label>
            <input type="text"
                   name="celular"
                   class="form-control"
                   id="telefone"
                   aria-describedby="telefoneHelp"
                   placeholder="Digite seu telefone (ex: xxxxxxxxxxx) onze dígitos"
                   value="{{ old('celular') }}">
            <small id="emailHelp"
                   class="form-text text-muted"
            >Use um telefone válido caso perca sua senha.</small>
            @error('celular')
                <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1" class="form-label mt-4">
                Senha</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   id="exampleInputPassword1"
                   placeholder="Digite sua senha (mínimo seis dígitos)">
            @error('password')
                <p class="text-danger mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="btn btn-outline-primary mt-3 px-5 py-3"
                style="width: 100%"
        >Entrar</button>

    </fieldset>
</form>

<div>
    <p class="text-center mt-3">OU</p>
        <a onclick="history.back()"
           class="btn btn-outline-primary mt-3 px-5 py-3"
           style="width: 100%"
        >VOLTAR</a>
</div>

</x-header-and-nav>
