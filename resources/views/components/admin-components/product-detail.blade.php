<x-header-and-nav>

    <div>
        <button class="btn btn-primary my-4"
                    onclick="history.back()">Voltar</button>
    </div>

    @foreach ($products as $product)

        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between">
                <a href="/editproduct/{{ $product->product_id }}">
                    {{ $product->product_name }}
                </a>
            </li>
        </ul>

    @endforeach

    <script>

        const deletar = document.querySelector('#deletar')

        deletar.addEventListener('click', e => {
            if(confirm('Você quer mesmo deletar este produto?')) {
                return window.location.href =
                    `http://127.0.0.1:8000/product-delete/${e.target.value}`

            }
        })

    </script>
</x-header-and-nav>
