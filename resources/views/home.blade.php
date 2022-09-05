<x-header-and-nav>
    @auth
        <x-allclients :user="$user" />
    @else
        <x-link-to-access />
    @endauth
</x-header-and-nav>
