{{-- @dd(request()->input()) --}}
<x-header-and-nav>

<div>
    <form action="/finish-sale" method="post">
        @csrf
        <div class="container">
            <h5 class="modal-title py-3"
                id="exampleModalLabel">
                Confira as informações da venda</h5>

            <ul class="modal-ul list-group" id="confirm-products">

                <div class="form-group" id="form-group">
                    @php
                    foreach($products as $key => $product){
                        if($product === null || $key === '_token'
                            || $key === 'user_id' || $key === 'name') {
                            echo '';
                        } else {
                            echo "
                            <li class='d-flex mt-2
                                       justify-content-center'>

                                <div class='col-8'>
                                    <input type='text' value='$key'
                                        class='form-control'
                                        readonly>
                                </div>

                                <div class=''>
                                    <input type='text' name='products[$key]'
                                           value='$product'
                                           class='form-control'
                                           placeholder='$key'
                                           readonly>
                                </div>
                            </li>";
                        }
                    }
                    @endphp
                </div>

                <p class="mt-4 h4">
                    Essa quatidade está correta para
                    <p>
                        <span class="text-info h1">
                            {{ request()->input('user_name') }}?</span>
                    </p>
                </p>
            </ul>

            <input type="hidden"
                    name="user_id"
                    value="{{ request()->user_id }}">

            <input type="hidden"
                    name="name"
                    value="{{ request()->name }}">

            <div class="d-flex justify-content-between">
                <button onclick="history.back()"
                        type="button"
                        class="btn btn-secondary py-2"
                        data-dismiss="modal" id="corrigir">
                    <span class="h1 px-3">Corrigir</span>
                </button>

                <button type="submit"
                        class="btn btn-primary py-2"
                        id="submit-button">
                    <span class="h1 px-5">OK</span>
                </button>
            </div>
        </div>
    </form>

    <div class="text-center mt-4">
        <a onclick="history.back()"
            class="btn btn-primary-outline mt-3">
            <span class="h1 px-5">Voltar</span></a>
    </div>
</div>

<script>

    const form_group = document.querySelector('#form-group')
    const submit_button = document.querySelector('#submit-button')
    const corrigir = document.querySelector('#corrigir')
    const small = document.querySelector('#small')

    if(form_group.children.length === 0) {
        form_group.innerHTML = `
        <div class="alert alert-secondary mt-5 mb-5" role="alert">
            Volte para a tela anterior e insira pelo menos um produto...</div>`

        small.remove()
        corrigir.remove()
        submit_button.remove()
    }

</script>
</x-header-and-nav>
