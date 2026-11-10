<section>
    <form class="row g-4" method="POST" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        {{-- Current Password --}}
        <div class="col-12">
            <label for="update_password_current_password" class="form-label">
                {{ __('Current Password') }}
            </label>

            <input
                type="password"
                class="form-control @if($errors->updatePassword->has('current_password')) is-invalid @endif"
                id="update_password_current_password"
                name="current_password"
                autocomplete="current-password"
            >

            @if($errors->updatePassword->has('current_password'))
                <div class="invalid-feedback">
                    {{ $errors->updatePassword->first('current_password') }}
                </div>
            @endif
        </div>

        {{-- New Password --}}
        <div class="col-12">
            <label for="update_password_password" class="form-label">
                {{ __('New Password') }}
            </label>

            <input
                type="password"
                class="form-control @if($errors->updatePassword->has('password')) is-invalid @endif"
                id="update_password_password"
                name="password"
                autocomplete="new-password"
            >

            @if($errors->updatePassword->has('password'))
                <div class="invalid-feedback">
                    {{ $errors->updatePassword->first('password') }}
                </div>
            @endif
        </div>

        {{-- Confirm Password --}}
        <div class="col-12">
            <label for="update_password_password_confirmation" class="form-label">
                {{ __('Confirm Password') }}
            </label>

            <input
                type="password"
                class="form-control @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif"
                id="update_password_password_confirmation"
                name="password_confirmation"
                autocomplete="new-password"
            >

            @if($errors->updatePassword->has('password_confirmation'))
                <div class="invalid-feedback">
                    {{ $errors->updatePassword->first('password_confirmation') }}
                </div>
            @endif
        </div>

        {{-- Submit --}}
        <div class="col-12">
            <button type="submit" class="btn btn-primary">
                {{ __('Save') }}
            </button>
        </div>
    </form>
</section>