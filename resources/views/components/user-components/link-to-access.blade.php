<a href="{{ auth()->user() ? '/autenticado' : route('login') }}"
   style="text-decoration: none;">
   <div class="card text-white bg-dark mb-3 text-center" >
        <div class="card-header text-center">Para que já é cliente</div>
        <div class="card-body">
            <h4 class="card-title text-center">Link para consultas</h4>
            <button class="btn btn-primary p-5"><h1>Começar</h1></button>
        </div>
    </div>
</a>
