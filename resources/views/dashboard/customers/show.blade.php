@extends('layouts.app')
@section('content')
    @php
        $breadcrumbItems = [
            [
                'label' => 'Customers',
                'url' => route('customer.index'),
            ],
            [
                'label' => 'Customer Details',
            ],
        ];
    @endphp
    <div class="py-5">
        <div class="row g-4 align-items-center">
            <div class="col">
                @include('components.breadcrumb', ['items' => $breadcrumbItems])

                <h1 class="h3 m-0">{{$customer->name}}</h1>
            </div>
            <div class="col-auto d-flex">
                <button
                    type="button"
                    class="btn btn-secondary me-3"
                    data-bs-toggle="modal"
                    data-bs-target="#deleteModal"
                    data-delete-url="{{ route('customer.destroy', $customer) }}"
                    data-delete-name="{{ $customer->name }}"
                >
                    Delete
                </button>
                <a href="{{ route('customer.edit', ['customer' => $customer->id]) }}" class="btn btn-primary">Edit</a>
            </div>
            {{-- <div class="col-auto d-flex">
            <a href="{{ route('customer.create') }}" class="btn btn-primary">New customer</a>
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
                            <div class="fs-exact-16 fw-medium">{{$customer->name}}</div>
                            <div class="fs-exact-13 text-muted">
                                <div class="mt-1"><a href="mailto:{{$customer->email}}">{{$customer->email}}</a></div>
                                <div class="mt-1">{{$customer->phone}}</div>
                            </div>
                        </div>
                        <div class="sa-divider my-5"></div>
                        <div class="w-100">
                            <dl class="list-unstyled m-0">
                                <dt class="fs-exact-14 fw-medium">Last Order</dt>
                                <dd class="fs-exact-13 text-muted mb-0 mt-1">7 days ago – <a
                                        href="app-order.html">#80294</a></dd>
                            </dl>
                            <dl class="list-unstyled m-0 mt-4">
                                <dt class="fs-exact-14 fw-medium">Average Order Value</dt>
                                <dd class="fs-exact-13 text-muted mb-0 mt-1">$574.00</dd>
                            </dl>
                            <dl class="list-unstyled m-0 mt-4">
                                <dt class="fs-exact-14 fw-medium">Registered</dt>
                                <dd class="fs-exact-13 text-muted mb-0 mt-1">{{$customer->created_at->format('F j, Y')}}</dd>
                            </dl>
                            <dl class="list-unstyled m-0 mt-4">
                                <dt class="fs-exact-14 fw-medium">Email Marketing</dt>
                                <dd class="fs-exact-13 text-muted mb-0 mt-1">Subscribed</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sa-entity-layout__main">
                {{-- <div class="sa-card-area">
                    <textarea class="sa-card-area__area" rows="2" placeholder="Notes about customer"></textarea>
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
                        <h2 class="mb-0 fs-exact-18 me-4">Orders</h2>
                        <div class="text-muted fs-exact-14 text-end">Total spent $34,980.34 on 7
                            orders</div>
                    </div>
                    <div class="table-responsive">
                        <table class="sa-table text-nowrap">
                            <tbody>
                                <tr>
                                    <td><a href="app-order.html">#80294</a></td>
                                    <td>Today at 6:10 pm</td>
                                    <td>Pending</td>
                                    <td>4 items</td>
                                    <td>$320.00</td>
                                </tr>
                                <tr>
                                    <td><a href="app-order.html">#63736</a></td>
                                    <td>May 15, 2019</td>
                                    <td>Completed</td>
                                    <td>7 items</td>
                                    <td>$2,574.31</td>
                                </tr>
                                <tr>
                                    <td><a href="app-order.html">#63501</a></td>
                                    <td>January 7, 2019</td>
                                    <td>Completed</td>
                                    <td>1 items</td>
                                    <td>$34.00</td>
                                </tr>
                                <tr>
                                    <td><a href="app-order.html">#40278</a></td>
                                    <td>October 19, 2018</td>
                                    <td>Completed</td>
                                    <td>2 items</td>
                                    <td>$704.00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="sa-divider"></div>
                    <div class="px-5 py-4 text-center"><a href="app-orders-list.html">View all 7
                            orders</a></div>
                </div>
                <div class="card mt-5">
                    <div class="card-body px-5 py-4 d-flex align-items-center justify-content-between">
                        <h2 class="mb-0 fs-exact-18 me-4">Address</h2>
                    </div>
                    <div class="sa-divider"></div>
                    <div class="px-5 py-3 my-2 d-flex align-items-center justify-content-between">
                        <div>
                            <div>{{$customer->name}}</div>
                            <div class="text-muted fs-exact-14 mt-1">{{$customer->address}}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
