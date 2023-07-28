<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="{{ url('bootstrap.min.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous" defer></script>
        {{-- <link rel="icon" href="{{ public_path('favicon.png') }}" type="image/x-icon"> --}}
        <title>{{ auth()->user()->name ?? 'Bar do Véio' }}</title>
    </head>

    <body>

        <div class="container">

            <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="nav-bar">
                <div class="container-fluid">
                    <a class="navbar-brand"
                        @auth

                            href="/autenticado"

                        @endif

                    >Clientela Bar do Véio</a>

                    <button class="navbar-toggler"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbarColor02"
                            aria-controls="navbarColor02"
                            aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarColor02">

                        @auth

                            <form class="d-flex bt-5 mb-2">
                                <input class="form-control me-sm-2 mt-3 py-3"
                                    type="text"
                                    placeholder="Procurar por Nome"
                                    id="bring-user-up"
                                    autofocus >
                            </form>

                        @endauth

                        <a href="https://fabiosimedo.github.io/bar-do-veio/index.html"
                           class="py-3 h5 btn btn-dark" target="_blank">
                                                        Ir para Site do Bar do Véio</a>

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

            document.querySelectorAll('#alertMessage').forEach(element => {
                if(element !== null) {
                    setTimeout(() => {
                        element.remove()
                    }, 4000)
                }
            })

            if (window.location.href.substr(-11) === 'autenticado') {
                document.querySelector('#bring-user-up')
                    .addEventListener('input', e => {
                        const allUsers = document.querySelectorAll('#user-name')
                        const navBar = document.querySelector('#nav-bar')
                        navBar.classList.add('fixed-top')
                        if(e.target.value ===  '') navBar.classList.remove('fixed-top')

                        allUsers.forEach(el => {
                            if(e.target.value === el.innerText[0]) {
                                el.parentElement.classList.add('border', 'border-danger')
                                return
                            }

                            if(e.target.value ===  '') {
                                el.parentElement.classList.remove('border', 'border-danger')
                                return
                            }

                            return
                        })

                    })
            }


        </script>

    </body>
</html>
