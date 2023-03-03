<x-header-and-nav>

    <form action="edit">

        <x-admin-components.inserted-products
                :product="$products"
                :user="$user" />

        @if (auth()->user()->isadmin &&
                    request()->routeIs('edit-products'))

            <button type="submit"
                    class="btn btn-outline-primary mt-3 ml-2 mb-3"
                    style="width: 80%" id="formbtn"
                    data-toggle="modal"
                    data-target="#exampleModal">Editar</button>
        @endif

    </form>

</x-header-and-nav>
