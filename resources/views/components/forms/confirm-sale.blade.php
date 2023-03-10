<x-header-and-nav>

<div>
    @if (request()->routeIs('create-client-avulso-confirm'))
        <form action="/create/avulso" method="post">
    @endif
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


                @if (request()->routeIs('create-client-avulso-confirm'))

                    <p class="mt-4 mb-4 h4" id="user-confirm">
                        <span class="text-info">{{ auth()->user()->name }}</span>
                        registrando venda Avulsa
                    </p>

                @else
                    <p id="user-confirm" class="mt-4">
                        {{-- {{ auth()->user()->name }} --}}
                        Esta quantidade está correta para
                       <p><span class="text-info h1">
                            {{ request()->input('user_name') }}?</span></p>
                    </p>


                @endif


            </ul>

            <input type="hidden"
                    name="user_id"
                    value="{{ request()->user_id }}">

            <input type="hidden"
                    name="name"
                    value="{{ request()->name }}">

            <div class="d-flex justify-content-around">

                <button type="submit"
                        class="btn btn-primary py-2"
                        id="submit-button">
                    <span class="h1 px-5">OK</span>
                </button>

                <div class="text-center mt-4">
                    <a onclick="history.back()"
                        class="btn btn-primary-outline mt-3">
                        <span class="h1 px-5">Voltar</span></a>
                </div>

            </div>
        </div>
    </form>


</div>

<script>

    const form_group = document.querySelector('#form-group')
    const submit_button = document.querySelector('#submit-button')
    const warning = document.querySelector('#user-confirm')
    const exampleModalLabel = document.querySelector('#exampleModalLabel')

    console.log(form_group.children.length)

    if(form_group.children.length == 0) {
        form_group.innerHTML = `
        <div class="alert alert-secondary mt-5 mb-5" role="alert">
            Volte para a tela anterior e insira pelo menos um produto...</div>`

        exampleModalLabel.remove()
        warning.remove()
        submit_button.remove()
    }

</script>
</x-header-and-nav>
