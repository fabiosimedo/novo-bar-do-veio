@if (session()->has('logado'))
    <div class="alert alert-warning sticky-top mt-2 example"
            role="alert" id="alertMessage">
            {{ session('logado') }}
    </div>
@endif

@if (session()->has('cadastrado'))
    <div class="alert alert-success mt-3"
            role="alert" id="alertMessage">
        {{ session('cadastrado') }}
    </div>
@endif

@if (session()->has('deletado'))
    <div class="alert alert-success sticky-top mt-2"
            role="alert" id="alertMessage">
            {{ session('deletado') }}
    </div>
@endif

@if (session()->has('deletadata'))
    <div class="alert alert-success sticky-top mt-2"
            role="alert" id="alertMessage">
            {{ session('deletadata') }}
    </div>
@endif

@if (session()->has('entrar'))
    <div class="alert alert-danger sticky-top mt-2"
            role="alert" id="alertMessage">
            {{ session('entrar') }}
    </div>
@endif

@if (session()->has('venda_cadastrada'))
    <div class="alert alert-success mt-3"
         role="alert" id="alertMessage">
        {{ session('venda_cadastrada') }}
    </div>
@endif

@if (session()->has('newpassword'))
    <div class="alert alert-success mt-3"
         role="alert" id="alertMessage">
        {{ session('newpassword') }}
    </div>
@endif

@if (session()->has('pagamento'))
    <div class="alert alert-info mt-3"
         role="alert" id="alertMessage">
        {{ session('pagamento') }}
    </div>
@endif

@if (session()->has('venda_a_vulsa'))
    <div class="alert alert-info mt-3"
         role="alert" id="alertMessage">
        {{ session('venda_a_vulsa') }}
    </div>
@endif

@if (session()->has('deslogado'))
    <div class="alert alert-info mt-3"
         role="alert" id="alertMessage">
        {{ session('deslogado') }}
    </div>
@endif

@if (session()->has('payment-deleted'))
    <div class="alert alert-warning mt-3"
         role="alert" id="alertMessage">
        {{ session('payment-deleted') }}
    </div>
@endif

@if (session()->has('payment-for-single-purshase'))
    <div class="alert alert-warning mt-3"
         role="alert" id="alertMessage">
        {{ session('payment-for-single-purshase') }}
    </div>
@endif

@if (session()->has('primeira_venda'))
    <div class="alert alert-warning mt-3"
         role="alert" id="alertMessage">
        {{ session('primeira_venda') }}
    </div>
@endif

@if (session()->has('pagamento-mensal'))
    <div class="alert alert-warning mt-3"
         role="alert" id="alertMessage">
        {{ session('pagamento-mensal') }}
    </div>
@endif

