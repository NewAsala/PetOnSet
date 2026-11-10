<nav class="mb-2" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-sa-simple">

        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">
                {{ __('Dashboard') }}
            </a>
        </li>

        @foreach ($items as $item)

            @if (isset($item['url']) && !$loop->last)
                <li class="breadcrumb-item">
                    <a href="{{ $item['url'] }}">
                        {{ __($item['label']) }}
                    </a>
                </li>
            @else
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __($item['label']) }}
                </li>
            @endif

        @endforeach

    </ol>
</nav>
