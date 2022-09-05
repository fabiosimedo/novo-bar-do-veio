<button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Bem vindo {{ auth()->user()->name }}!</button>
<form action="/logout" method="post" class="form-group d-flex flex-row-reverse m-2">
    @csrf

        <button type="submit" class="btn btn-primary-outline">SAIR</button>
</form>

<ul class="list-group">
    @foreach ($user as $users)
        <li class="list-group-item"><a href="user/{{ $users->name }}" style="text-decoration: none">{{ $users->name }}</a></li>
    @endforeach
</ul>
