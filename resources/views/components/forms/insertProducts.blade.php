<x-header-and-nav>
    <div class="form mt-2 mb-2">
        <div class="pb-2 text-bold">
            <button class="btn btn-outline-info mb-2">
                {{ auth()->user()->name }}</button>

               <span class="h4">registrando venda para</span>

            <p class="h2 text-secondary text-center">{{ $user[0]->name }}</p>
        </div>

        <form method="post"
              action="{{ request()->routeIs('insertproducts-post') }}"
              id="form"
              class="form-group mt-3">
              @csrf

            <div class="d-flex justify-content-around flex-wrap" id="form-div">
              @foreach ($products as $product)
                <div class="mt-2 col-6 p-3">
                  <p class="h4" id="product-name">{{ $product->product_name }}</p>
                  <input type="text"
                         name="products[{{ $product->product_name }}]"
                         value="{{ old('products[]') }}"
                         placeholder="Quantidade"
                         class="form-control-lg"
                         style="display: block;
                                margin-left: auto;
                                margin-right: auto;
                                width: 110%;"
                    >
                </div>
              @endforeach
            </div>

                    <input type="hidden"
                           name="user_id"
                           value="{{ $user[0]->user_id }}">
                    <input type="hidden"
                           name="user_name"
                           value="{{ $user[0]->name }}">

              <button type="submit"
                      class="btn btn-outline-primary mt-4 btn-lg py-3"
                      style="width: 100%" id="formbtn"
                      data-toggle="modal"
                      data-target="#exampleModal">Cadastrar Venda</button>
        </form>

    </div>

    <div class="text-center mt-4 pb-3">
        <a onclick="history.back()"
           class="btn btn-primary-outline mt-3 py-3 px-5">Voltar</a>
    </div>

    <script>

        if (window.location.href.split('/').includes('insertproducts')) {
                document.querySelector('#bring-user-up')
                    .addEventListener('input', e => {
                        const formDiv = document.querySelector('#form-div')
                        const allProducts = document.querySelectorAll('#product-name')
                        const navBar = document.querySelector('#nav-bar')
                        navBar.classList.add('fixed-top')
                        if(e.target.value ===  '') navBar.classList.remove('fixed-top')

                        allProducts.forEach(el => {
                            if(e.target.value === el.innerText[0]) {
                                formDiv.style = 'margin-top: 5.5rem;'
                                el.classList.add('text-danger')
                                el.nextElementSibling.classList.add('border', 'border-danger')
                            }

                            if(e.target.value ===  '') {
                                formDiv.style = ''
                                el.classList.remove('text-danger')
                                el.nextElementSibling.classList.remove('border', 'border-danger')
                            }
                        })

                    })
            }

    </script>

</x-header-and-nav>
