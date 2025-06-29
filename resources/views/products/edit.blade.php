<x-header-and-nav>
    <div class="container my-5">
        <h2 class="mb-4">Editar Produto</h2>

        <form method="POST" action="{{ route('updateproduct', ['product' => $product->product_id]) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="product_name">Nome do Produto</label>
                <input type="text" class="form-control" id="product_name"
                       name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
            </div>

            <div class="form-group">
                <label for="product_qtty">Quantidade</label>
                <input type="number" class="form-control" id="product_qtty"
                       name="product_qtty" value="{{ old('product_qtty', $product->product_qtty) }}" required>
            </div>

            <div class="form-group">
                <label for="product_cost_price">Preço de Custo (R$)</label>
                <input type="number" step="0.01" class="form-control" id="product_cost_price"
                       name="product_cost_price" value="{{ old('product_cost_price', $product->product_cost_price) }}" required>
            </div>

            <div class="form-group">
                <label for="product_price">Preço de Venda (R$)</label>
                <input type="number" step="0.01" class="form-control" id="product_price"
                       name="product_price" value="{{ old('product_price', $product->product_price) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary ml-2">Cancelar</a>
        </form>
    </div>
</x-header-and-nav>
