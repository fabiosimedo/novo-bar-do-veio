<x-header-and-nav>
    <div class="d-flex justify-content-between">
        <div class="mt-3">
            <p>Bem Vindo(a)</p>
            <p class="h1 text-success">{{ auth()->user()->name }}</p>
        </div>
        <form action="/logout" method="post" >
            @csrf

            <button
                type="submit"
                class="btn btn-primary-outline text-danger px-5 py-3">SAIR</button>
        </form>
    </div>

    <x-client-product-list
            :sales="$sales"
            :user="$user"
            :products="$products"
            :sum="$sum"
            :payments="$payments"
            :totalsum="$totalsum"
    />

</x-header-and-nav>
