@extends('layouts.app')
@section('content')
    @php
        $breadcrumbItems = [
            [
                'label' => __('dashboard.suppliers'),
                'url' => route('supplier.index'),
            ],
            [
                'label' => __('dashboard.supplier_details'),
            ],
        ];
    @endphp
    <div class="py-5">
        <div class="row g-4 align-items-center">
            <div class="col">
                @include('components.breadcrumb', ['items' => $breadcrumbItems])

                <h1 class="h3 m-0">{{$supplier->name}}</h1>
            </div>
            <div class="col-auto d-flex">
                <button
                    type="button"
                    class="btn btn-secondary me-3"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                    data-delete-url="{{ route('supplier.destroy', $supplier) }}"
                    data-delete-name="{{ $supplier->name }}"
                >
                    {{ __('dashboard.delete') }}
                </button>
                <a href="{{ route('supplier.edit', ['supplier' => $supplier->id]) }}" class="btn btn-primary">{{ __('dashboard.edit') }}</a>
            </div>
            {{-- <div class="col-auto d-flex">
            <a href="{{ route('supplier.create') }}" class="btn btn-primary">{{ __('dashboard.new_supplier') }}</a>
        </div> --}}
        </div>
    </div>
    <div class="sa-entity-layout" data-sa-container-query="{&quot;920&quot;:&quot;sa-entity-layout--size--md&quot;}">
        <div class="sa-entity-layout__body">
            <div class="sa-entity-layout__sidebar">
                <div class="card">
                    <div class="card-body d-flex flex-column align-items-center">
                        {{-- <div class="pt-3">
                            <div class="sa-symbol sa-symbol--shape--circle" style="--sa-symbol--size:6rem">
                                <img
                                    src="images/customers/customer-1-96x96.jpg" width="96" height="96"
                                    alt="" />
                            </div>
                        </div> --}}
                        <div class="text-center mt-4">
                            <div class="fs-exact-16 fw-medium">{{$supplier->name}}</div>
                            <div class="fs-exact-13 text-muted">
                                <div class="mt-1"><a href="mailto:{{$supplier->email}}">{{$supplier->email}}</a></div>
                                <div class="mt-1">{{$supplier->phone}}</div>
                            </div>
                        </div>
                        <div class="sa-divider my-5"></div>
                        <div class="w-100">
                            <dl class="list-unstyled m-0">
                                <dt class="fs-exact-14 fw-medium">{{ __('dashboard.last_order') }}</dt>
                                <dd class="fs-exact-13 text-muted mb-0 mt-1">{{ __('dashboard.seven_days_ago') }} – <a
                                        href="app-order.html">#80294</a></dd>
                            </dl>
                            <dl class="list-unstyled m-0 mt-4">
                                <dt class="fs-exact-14 fw-medium">{{ __('dashboard.average_order_value') }}</dt>
                                <dd class="fs-exact-13 text-muted mb-0 mt-1">$574.00</dd>
                            </dl>
                            <dl class="list-unstyled m-0 mt-4">
                                <dt class="fs-exact-14 fw-medium">{{ __('dashboard.registered') }}</dt>
                                <dd class="fs-exact-13 text-muted mb-0 mt-1">{{$supplier->created_at->format('F j, Y')}}</dd>
                            </dl>
                            <dl class="list-unstyled m-0 mt-4">
                                <dt class="fs-exact-14 fw-medium">{{ __('dashboard.email_marketing') }}</dt>
                                <dd class="fs-exact-13 text-muted mb-0 mt-1">{{ __('dashboard.subscribed') }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sa-entity-layout__main">
                {{-- <div class="sa-card-area">
                    <textarea class="sa-card-area__area" rows="2" placeholder="{{ __('dashboard.additional_information') }}"></textarea>
                    <div class="sa-card-area__card"><svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-edit">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                            </path>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z">
                            </path>
                        </svg></div>
                </div> --}}
                <div class="card"> {{-- mt-5 --}}
                    <div class="card-body px-5 py-4 d-flex align-items-center justify-content-between">
                        <h2 class="mb-0 fs-exact-18 me-4">{{ __('dashboard.orders') }}</h2>
                        <div class="text-muted fs-exact-14 text-end">{{ __('dashboard.total_spent_summary', ['amount' => '$34,980.34', 'count' => 7]) }}</div>
                    </div>
                    <div class="table-responsive">
                        <table class="sa-table text-nowrap">
                            <tbody>
                                <tr>
                                    <td><a href="app-order.html">#80294</a></td>
                                    <td>{{ __('dashboard.today_at') }}</td>
                                    <td>{{ __('dashboard.pending') }}</td>
                                    <td>{{ __('dashboard.four_items') }}</td>
                                    <td>$320.00</td>
                                </tr>
                                <tr>
                                    <td><a href="app-order.html">#63736</a></td>
                                    <td>{{ __('dashboard.may_15_2019') }}</td>
                                    <td>{{ __('dashboard.completed') }}</td>
                                    <td>{{ __('dashboard.seven_items') }}</td>
                                    <td>$2,574.31</td>
                                </tr>
                                <tr>
                                    <td><a href="app-order.html">#63501</a></td>
                                    <td>{{ __('dashboard.january_7_2019') }}</td>
                                    <td>{{ __('dashboard.completed') }}</td>
                                    <td>{{ __('dashboard.one_item') }}</td>
                                    <td>$34.00</td>
                                </tr>
                                <tr>
                                    <td><a href="app-order.html">#40278</a></td>
                                    <td>{{ __('dashboard.october_19_2018') }}</td>
                                    <td>{{ __('dashboard.completed') }}</td>
                                    <td>{{ __('dashboard.two_items') }}</td>
                                    <td>$704.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="sa-divider"></div>
                    <div class="px-5 py-4 text-center"><a href="app-orders-list.html">{{ __('dashboard.view_all_orders') }}</a></div>
                </div>
                <div class="card mt-5">
                    <div class="card-body px-5 py-4 d-flex align-items-center justify-content-between">
                        <h2 class="mb-0 fs-exact-18 me-4">{{ __('dashboard.address') }}</h2>
                    </div>
                    <div class="sa-divider"></div>
                    <div class="px-5 py-3 my-2 d-flex align-items-center justify-content-between">
                        <div>
                            <div>{{$supplier->name}}</div>
                            <div class="text-muted fs-exact-14 mt-1">{{$supplier->address}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
