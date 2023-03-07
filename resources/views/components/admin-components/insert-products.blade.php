<x-header-and-nav>

    <form action="/addproduct" method="post" class="mt-2">
        @csrf
        <div class="form-group">
            <input type="text" name="product_name"
                   class="form-control mb-3"
                   placeholder="Nome do Produto"
                   value="{{ old('product_name') }}" required>

            <input type="text" name="product_qtty"
                    class="form-control mb-3"
                    placeholder="Quantidade"
                    value="{{ old('product_qtty') }}" required>

            <input type="number" name="product_cost_price"
                    class="form-control mb-3"
                    placeholder="Preço de Custo"
                    value="{{ old('product_cost_price') }}"
                    pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                    required>

            <input type="number" name="product_price"
                    class="form-control mb-5"
                    placeholder="Preço de Venda"
                    value="{{ old('product_price') }}"
                    pattern="[0-9]+([\.,][0-9]+)?" step="0.01"
                    required>

            <div class="d-flex justify-content-between">
                <button type="submit"
                        class="btn btn-primary">Cadastrar</button>

                <a onclick="history.back()"
                   class="btn btn-primary-outline px-4">Voltar</a>
            </div>
        </div>

        @error('name')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror

        @error('preco')
            <p class="text-danger mt-2">{{ $message }}</p>
        @enderror
    </form>

</x-header-and-nav>
