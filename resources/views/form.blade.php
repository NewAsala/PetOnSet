@extends('layouts.app')
@section('content')
<div class="py-5">
    <div class="row g-4 align-items-center">
        <div class="col">
            <nav class="mb-2" aria-label="{{ __('dashboard.breadcrumb') }}">
                <ol class="breadcrumb breadcrumb-sa-simple">
                    <li class="breadcrumb-item"><a href="index.html">{{ __('dashboard.dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="app-settings-toc.html">{{ __('dashboard.settings') }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.general') }}</li>
                </ol>
            </nav>
            <h1 class="h3 m-0">{{ __('dashboard.general') }}</h1>
        </div>
        <div class="col-auto d-flex"><a href="#" class="btn btn-secondary me-3">{{ __('dashboard.reset') }}</a><a href="#"
                class="btn btn-primary">{{ __('dashboard.save') }}</a></div>
    </div>
</div>
<div class="card">
    <div class="card-body p-5">
        <div class="mb-4"><label for="form-settings/name" class="form-label">{{ __('dashboard.store_name') }}</label><input type="text" class="form-control" id="form-settings/name" value="Stroyka" /></div>
        <div class="mb-4"><label for="form-settings/description" class="form-label">{{ __('dashboard.store_description') }}</label>
            <textarea class="form-control" id="form-settings/description" rows="4">Tools Store HTML eCommerce Template</textarea>
        </div>
        <div class="mb-n2"><label for="form-settings/email" class="form-label">{{ __('dashboard.email_address') }}</label><input type="email" class="form-control" id="form-settings/email"
                aria-describedby="form-settings/email/help" value="stroyka@example.com" />
            <div id="form-settings/email/help" class="form-text">{{ __('dashboard.store_email_help') }}</div>
        </div>
    </div>
</div>
<div class="card mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
            <h2 class="mb-0 fs-exact-18">{{ __('dashboard.measurements') }}</h2>
            <div class="mt-3 text-muted">{{ __('dashboard.measurements_help') }}</div>
        </div>
        <div class="row g-4">
            <div class="col-6"><label for="form-settings/weight-unit" class="form-label">{{ __('dashboard.weight_unit') }}</label><select id="form-settings/weight-unit" class="form-select">
                    <option selected="">kg</option>
                    <option>g</option>
                    <option>lbs</option>
                    <option>oz</option>
                </select></div>
            <div class="col-6"><label for="form-settings/dimensions-unit" class="form-label">{{ __('dashboard.dimensions_unit') }}</label><select id="form-settings/dimensions-unit" class="form-select">
                    <option selected="">m</option>
                    <option>cm</option>
                    <option>mm</option>
                    <option>in</option>
                    <option>yd</option>
                </select></div>
        </div>
    </div>
</div>
<div class="card mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
            <h2 class="mb-0 fs-exact-18">{{ __('dashboard.date_time') }}</h2>
            <div class="mt-3 text-muted">{{ __('dashboard.date_time_settings_help') }}</div>
        </div>
        <div class="mb-4"><label for="form-settings/timezone" class="form-label">{{ __('dashboard.timezone') }}</label><select
                id="form-settings/timezone" class="form-select">
                <option>Europe/Berlin</option>
                <option selected="">Europe/Kiev</option>
                <option>Europe/London</option>
                <option>Europe/Minsk</option>
                <option>Europe/Moscow</option>
                <option>Europe/Paris</option>
                <option>Europe/Warsaw</option>
            </select></div>
        <div class="mb-4"><label for="form-settings/date-format" class="form-label">{{ __('dashboard.date_format') }}</label><select id="form-settings/date-format" class="form-select">
                <option selected="">{{ __('dashboard.sample_date_format') }}</option>
                <option>2020-11-08 (Y-m-d)</option>
                <option>11/08/2020 (m/d/Y)</option>
                <option>08/11/2020 (d/m/Y)</option>
                <option>{{ __('dashboard.custom') }}</option>
            </select></div>
        <div><label for="form-settings/time-format" class="form-label">{{ __('dashboard.time_format') }}</label><select id="form-settings/time-format" class="form-select">
                <option selected="">{{ __('dashboard.sample_time_format_lower') }}</option>
                <option>{{ __('dashboard.sample_time_format_upper') }}</option>
                <option>10:57 (H:i)</option>
                <option>{{ __('dashboard.custom') }}</option>
            </select></div>
    </div>
</div>
<div class="card mt-5">
    <div class="card-body p-5">
        <div class="mb-5">
            <h2 class="mb-0 fs-exact-18">{{ __('dashboard.reviews_comments') }}</h2>
            <div class="mt-3 text-muted">{{ __('dashboard.reviews_comments_help') }}</div>
        </div>
        <div class="mb-4">
            <div class="form-label">{{ __('dashboard.enable_reviews') }}</div>
            <div><label class="form-check form-check-inline mb-0"><input type="radio" class="form-check-input"
                        name="settings[reviews]" /><span                         class="form-check-label">{{ __('dashboard.no') }}</span></label><label
                    class="form-check form-check-inline mb-0"><input type="radio" class="form-check-input"
                        name="settings[reviews]" checked="" /><span                         class="form-check-label">{{ __('dashboard.yes') }}</span></label>
            </div>
        </div>
        <div>
            <div class="form-label">{{ __('dashboard.product_ratings') }}</div>
            <div><label class="form-check"><input type="checkbox" class="form-check-input" checked="" /><span
                        class="form-check-label">{{ __('dashboard.enable_star_rating') }}</span></label><label class="form-check mb-0"><input type="checkbox"
                        class="form-check-input" /><span                         class="form-check-label">{{ __('dashboard.star_ratings_required') }}</span></label></div>
        </div>
    </div>
</div>
@endsection
