<section>

    {{-- Send Verification Email --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Profile Form --}}
    <form method="POST" action="{{ route('profile.update') }}" class="row g-4">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div class="col-md-6">
            <label for="name" class="form-label">
                {{ __('Name') }}
            </label>

            <input
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                id="name"
                name="name"
                value="{{ old('name', $user->name) }}"
                required
                autofocus
                autocomplete="name"
            >

            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Email --}}
        <div class="col-md-6">
            <label for="email" class="form-label">
                {{ __('Email') }}
            </label>

            <input
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                id="email"
                name="email"
                value="{{ old('email', $user->email) }}"
                
                autocomplete="username"
            >

            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Phone --}}
        <div class="col-md-6">
            <label for="phone" class="form-label">
                {{ __('Phone') }}
            </label>

            <input
                type="text"
                class="form-control @error('phone') is-invalid @enderror"
                id="phone"
                name="phone"
                value="{{ old('phone', $user->phone) }}"
                autocomplete="tel"
            >

            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Address --}}
        <div class="col-md-6">
            <label for="address" class="form-label">
                {{ __('Address') }}
            </label>

            <input
                type="text"
                class="form-control @error('address') is-invalid @enderror"
                id="address"
                name="address"
                value="{{ old('address', $user->address) }}"
                autocomplete="street-address"
            >

            @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Email Verification --}}
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())

            <div class="col-12">

                <div class="alert alert-warning mb-0">

                    <p class="mb-2">
                        {{ __('Your email address is unverified.') }}
                    </p>

                    <button
                        form="send-verification"
                        type="submit"
                        class="btn btn-link p-0"
                    >
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                </div>

            </div>

        @endif

        {{-- Save --}}
        <div class="col-12">

            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>

        </div>

    </form>

</section>