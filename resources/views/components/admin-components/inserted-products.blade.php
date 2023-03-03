<div>
    <ul class="group-list">

        @foreach ($product as $products)
        <li class="list-group-item mt-2">

            <a class="btn btn-outline-primary w-100 py-3"
                href="edit/{{  $products->product_id }}">

                {{ $products->product_name }}

            </a>

        </li>
        @endforeach

    </ul>
</div>

