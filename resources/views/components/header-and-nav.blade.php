<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="{{ url('bootstrap.min.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous" defer></script>
        <link rel="icon" href="favicon.png" type="image/x-icon">
        <title>Bar do Véio</title>
    </head>

    <body>
        <div class="container">
            @if (session()->has('logado'))
                <div class="alert alert-warning" role="alert" id="alertMessage">
                    {{ session('logado') }}
                </div>
            @endif

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">Clientela Bar do Véio</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>

                    @auth
                        <div class="collapse navbar-collapse" id="navbarColor02">
                            <form class="d-flex bt-5">
                                <input class="form-control me-sm-2" type="text" placeholder="Procurar por nome">
                                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Busca</button>
                            </form>
                        </div>
                    @endauth

                </div>
            </nav>

            <h2 class="mt-2">Área de acesso</h2>
            <p class="text-primary">Cadastramento e consulta de clientes.</p>


                {{ $slot }}

            {{-- aqui faço a lógica para renderizar os forms
                1- página inicial sem forms sem funcionalidade de pesquisa por clientes                 !!!!!! check
                2- obrigatório logar para ter acesso a ferramenta de pesquisa                           !!!!! check
                2.1- form para cadastramento de clientes acessível somente para admins                  !!!! check

                3- rota de pesquisa para clientes somente mostra valores e data dos débitos
                4- rota de pesquisa para funcionários adiciona funcionalidade de incluir produtos
                editar apagar (produtos)
                5- nessa rota a tabela com nome dos clientes será clicável nas respectivas datas
                podendo ser editadas e acrecentados valores e mercadorias por funcionários
                6- rota para criar novos clientes e deletar clientes somente admin (essa rota tbm terá todas funcionalidades da rota de funcionários)

            --}}


        </div>
    </body>
</html>
