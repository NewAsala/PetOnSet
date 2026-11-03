<nav class="mb-2" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-sa-simple">

        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                Dashboard
            </a>
        </li>

        @foreach ($items as $item)

            @if (isset($item['url']) && !$loop->last)
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}">
                        {{ $item['label'] }}
                    </a>
                </li>
            @else
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $item['label'] }}
                </li>
            @endif

        @endforeach

    </ol>
</nav>
