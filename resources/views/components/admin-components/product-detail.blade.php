<x-header-and-nav>

    <div>
        <a href="{{ route('user-area') }}" class="btn btn-primary my-4">Voltar</a>
    </div>

    @foreach ($products as $product)
        <ul class="list-group">
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="/editproduct/{{ $product->product_id }}">
                    {{ $product->product_name }}
                </a>

                {{-- Botão de deletar com confirmação --}}
                <form method="POST"
                      action="{{ route('deleteproduct', $product->product_id) }}"
                      class="ml-2 delete-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn btn-sm btn-danger"
                            data-name="{{ $product->product_name }}">
                        Deletar
                    </button>
                </form>
            </li>
        </ul>
    @endforeach

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if(session('deleted'))
        <div class="alert alert-warning mt-3">
            {!! session('deleted') !!}
        </div>
    @endif

    {{-- Script de confirmação --}}
    <script>
        const deleteForms = document.querySelectorAll('.delete-form');

        deleteForms.forEach(form => {
            form.addEventListener('submit', function (e) {
                const name = form.querySelector('button').dataset.name;
                const confirmed = confirm(`Tem certeza que deseja deletar o produto "${name}"?`);
                if (!confirmed) e.preventDefault();
            });
        });
    </script>

</x-header-and-nav>
