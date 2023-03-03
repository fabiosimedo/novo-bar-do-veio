
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="{{ url('bootstrap.min.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous" defer></script>
        <link rel="icon" href="favicon.png" type="image/x-icon">
        <title>{{ auth()->user()->name ?? 'Bar do Véio' }}</title>
    </head>

    <body>
        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <div class="container-fluid">
                    <a class="navbar-brand" href="/">Clientela Bar do Véio</a>
                    <button class="navbar-toggler"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbarColor02"
                            aria-controls="navbarColor02"
                            aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarColor02">

                        <form class="d-flex bt-5">
                            <input class="form-control me-sm-2 mt-3 py-3"
                                type="text"
                                placeholder="Procurar por nome ou data"
                                {{-- nome admin func data cliente --}}
                                autofocus >
                        </form>

                        <a href=""
                           class="badge badge-warning py-3 mt-3">VOLTAR PARA O SITE DO BAR</a>

                    </div>
                </div>
            </nav>

            <x-alertmessage />


            @if(!auth()->user())
                <h2 class="mt-2 py-4">Área de acesso</h2>
            @endif

                {{ $slot }}

        </div>

        <script>
            const alerta = document.querySelector('#alertMessage')

            if(alerta !== null) {
                setTimeout(() => {
                    alerta.remove()
                }, 4000);
            }
        </script>
    </body>
</html>
