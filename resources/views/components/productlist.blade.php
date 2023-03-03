<x-header-and-nav>
    <div class="d-flex justify-content-between">
        <div>
            <ul class="list-group">
                <li class="list-group-item">{{ $user->name }}</li>
            </ul>
        </div>
        <div>
            <a href="/user/{{ $user->name }}" class="btn btn-primary-outline">Voltar</a>
        </div>
    </div>

    <div class="mt-4">
        @foreach($userProducts as $userProduct)

            <ul class="list-group mt-3">
                <li class="list-group-item mt-3">

                    <div class="d-flex justify-content-between">
                        <div>
                            {{ $userProduct->product_name }}
                        </div>
                        <div>
                            {{ $userProduct->qtde }}
                        </div>
                    </div>
                    <div class="alert alert-danger mt-3 text-center" role="alert">
                        {{ $userProduct->total }}
                    </div>


                    <p class="text-center mt-4">
                        {{ DATE_FORMAT($userProduct->created_at, 'd/m/Y') }}
                    </p>
                </li>
            </ul>

        @endforeach
    </div>
</x-header-and-nav>
