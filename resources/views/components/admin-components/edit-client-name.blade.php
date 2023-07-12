<x-header-and-nav>

    <p class="h2 mt-3 mb-3">{{ $user->name }}</p>

    <div class="mt-4">
        <form action="/editusername/{{ $user->user_id }}" method="post" class="form-group">
            @csrf

            <input  type="text"
                    name="user_new_name"
                    class="form-control">

            <input type="hidden" name="user_id" value="{{ $user->user_id }}">

            <input type="submit" value="Mudar Nome" class="btn btn-secondary mt-4">

        </form>
    </div>

</x-header-and-nav>
