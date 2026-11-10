<div class="sa-app__sidebar">
    <div class="sa-sidebar">
        <div class="sa-sidebar__header">
            <a class="sa-sidebar__logo" href="{{ route('dashboard') }}">
                <!-- logo -->
                <div class="sa-sidebar-logo">
                    <img src="{{ asset('images/Pet on set website image.png') }}" alt="{{ __('Logo') }}" class="sa-sidebar-logo__img">
                    <div class="sa-sidebar-logo__caption">{{ Auth::user()?->getRoleNames()->first() ?? __('No Role Assigned') }}</div>
                </div>
                <!-- logo / end -->
            </a>
        </div>
        <div class="sa-sidebar__body" data-simplebar>
            <ul class="sa-nav sa-nav--sidebar" data-sa-collapse>
                <li class="sa-nav__section">
                    <div class="sa-nav__section-title">
                        <span>{{ __('Application') }}</span>
                    </div>
                    <ul class="sa-nav__menu sa-nav__menu--root">
                        <li @class([
                            'sa-nav__menu-item',
                            'sa-nav__menu-item--has-icon',
                            'sa-nav__menu-item--active' => request()->routeIs('dashboard'),
                        ])>
                            <a href={{ route('dashboard') }}
                                class="sa-nav__link"
                                @if (request()->routeIs('dashboard')) aria-current="page" @endif>
                                <span class="sa-nav__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewbox="0 0 16 16" fill="currentColor">
                                        <path
                                            d="M8,13.1c-4.4,0-8,3.4-8-3C0,5.6,3.6,2,8,2s8,3.6,8,8.1C16,16.5,12.4,13.1,8,13.1zM8,4c-3.3,0-6,2.7-6,6c0,4,2.4,0.9,5,0.2C7,9.9,7.1,9.5,7.4,9.2l3-2.3c0.4-0.3,1-0.2,1.3,0.3c0.3,0.5,0.2,1.1-0.2,1.4l-2.2,1.7c2.5,0.9,4.8,3.6,4.8-0.2C14,6.7,11.3,4,8,4z">
                                        </path>
                                    </svg>
                                </span>
                                <span class="sa-nav__title">{{ __('Dashboard') }}</span>
                            </a>
                        </li>

                        <li @class([
                            'sa-nav__menu-item',
                            'sa-nav__menu-item--has-icon',
                            'sa-nav__menu-item--open' => request()->routeIs('user.*'),
                        ]) data-sa-collapse-item="sa-nav__menu-item--open">
                            <a href class="sa-nav__link" data-sa-collapse-trigger>
                                <span class="sa-nav__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewbox="0 0 16 16" fill="currentColor">
                                        <path
                                            d="M8,10c-3.3,0-6,2.7-6,6H0c0-3.2,1.9-6,4.7-7.3C3.7,7.8,3,6.5,3,5c0-2.8,2.2-5,5-5s5,2.2,5,5c0,1.5-0.7,2.8-1.7,3.7c2.8,1.3,4.7,4,4.7,7.3h-2C14,12.7,11.3,10,8,10z M8,2C6.3,2,5,3.3,5,5s1.3,3,3,3s3-1.3,3-3S9.7,2,8,2z">
                                        </path>
                                    </svg>
                                </span>
                                <span class="sa-nav__title">{{ __('Users') }}</span>
                                <span class="sa-nav__arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="9" viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg>
                                </span>
                            </a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('user.index', 'user.edit', 'user.update', 'user.destroy'),
                                ])>
                                    <a href="{{ route('user.index') }}" class="sa-nav__link" @if (request()->routeIs('user.index', 'user.edit', 'user.update', 'user.destroy')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Users List') }}</span>
                                    </a>
                                </li>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('user.create'),
                                ])>
                                    <a href="{{ route('user.create') }}" class="sa-nav__link" @if (request()->routeIs('user.create')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Create User') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li @class([
                            'sa-nav__menu-item',
                            'sa-nav__menu-item--has-icon',
                            'sa-nav__menu-item--open' => request()->routeIs('supplier.*'),
                        ]) data-sa-collapse-item="sa-nav__menu-item--open">
                            <a href class="sa-nav__link" data-sa-collapse-trigger>
                                <span class="sa-nav__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="1em"
                                        height="1em"
                                        viewBox="0 0 16 16"
                                        fill="currentColor">

                                        <path d="M0 3a1 1 0 0 1 1-1h9a1 1 0 0 1 1 1v1h2.5a1 1 0 0 1 .8.4l1.5 2A1 1 0 0 1 16 7v4a1 1 0 0 1-1 1h-1a2 2 0 1 1-4 0H6a2 2 0 1 1-4 0H1a1 1 0 0 1-1-1V3zm11 3v3h3V7l-1-1h-2z"/>
                                        <path d="M4 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2zm8 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>

                                    </svg>
                                </span>
                                <span class="sa-nav__title">{{ __('Suppliers') }}</span>
                                <span class="sa-nav__arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="9" viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg>
                                </span>
                            </a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('supplier.index', 'supplier.show', 'supplier.edit', 'supplier.update', 'supplier.destroy'),
                                ])>
                                    <a href="{{ route('supplier.index') }}" class="sa-nav__link" @if (request()->routeIs('supplier.index', 'supplier.show', 'supplier.edit', 'supplier.update', 'supplier.destroy')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Suppliers List') }}</span>
                                    </a>
                                </li>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('supplier.create'),
                                ])>
                                    <a href="{{ route('supplier.create') }}" class="sa-nav__link" @if (request()->routeIs('supplier.create')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Create Supplier') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li @class([
                            'sa-nav__menu-item',
                            'sa-nav__menu-item--has-icon',
                            'sa-nav__menu-item--open' => request()->routeIs('customer.*'),
                        ]) data-sa-collapse-item="sa-nav__menu-item--open">
                            <a href class="sa-nav__link" data-sa-collapse-trigger>
                                <span class="sa-nav__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="1em"
                                        height="1em"
                                        viewBox="0 0 16 16"
                                        fill="currentColor">

                                        <path d="M5.5 8A3.5 3.5 0 1 0 5.5 1a3.5 3.5 0 0 0 0 7zm0-5A1.5 1.5 0 1 1 5.5 6a1.5 1.5 0 0 1 0-3z"/>
                                        <path d="M0 15a5.5 5.5 0 0 1 11 0H9a3.5 3.5 0 0 0-7 0H0z"/>
                                        <path d="M11.5 7a2.5 2.5 0 1 0 0-5v2a.5.5 0 1 1 0 1v2z"/>
                                        <path d="M11 9.5a4.5 4.5 0 0 1 4.5 4.5h-2a2.5 2.5 0 0 0-2.5-2.5v-2z"/>

                                    </svg>
                                </span>
                                <span class="sa-nav__title">{{ __('Customers') }}</span>
                                <span class="sa-nav__arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="9" viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg>
                                </span>
                            </a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('customer.index', 'customer.show', 'customer.edit', 'customer.update', 'customer.destroy'),
                                ])>
                                    <a href="{{ route('customer.index') }}" class="sa-nav__link" @if (request()->routeIs('customer.index', 'customer.show', 'customer.edit', 'customer.update', 'customer.destroy')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Customers List') }}</span>
                                    </a>
                                </li>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('customer.create'),
                                ])>
                                    <a href="{{ route('customer.create') }}" class="sa-nav__link" @if (request()->routeIs('customer.create')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Create Customer') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li @class([
                            'sa-nav__menu-item',
                            'sa-nav__menu-item--has-icon',
                            'sa-nav__menu-item--open' => request()->routeIs('product.*', 'category.*', 'brand.*'),
                        ]) data-sa-collapse-item="sa-nav__menu-item--open">
                            <a href class="sa-nav__link" data-sa-collapse-trigger>
                                <span class="sa-nav__icon">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewbox="0 0 16 16" fill="currentColor">
                                        <path
                                            d="M8,6C4.7,6,2,4.7,2,3s2.7-3,6-3s6,1.3,6,3S11.3,6,8,6z M2,5L2,5L2,5C2,5,2,5,2,5z M8,8c3.3,0,6-1.3,6-3v3c0,1.7-2.7,3-6,3S2,9.7,2,8V5C2,6.7,4.7,8,8,8z M14,5L14,5C14,5,14,5,14,5L14,5z M2,10L2,10L2,10C2,10,2,10,2,10z M8,13c3.3,0,6-1.3,6-3v3c0,1.7-2.7,3-6,3s-6-1.3-6-3v-3C2,11.7,4.7,13,8,13z M14,10L14,10C14,10,14,10,14,10L14,10z">
                                        </path>
                                    </svg>
                                </span>
                                <span class="sa-nav__title">{{ __('Catalog') }}</span>
                                <span class="sa-nav__arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="9" viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg>
                                </span>
                            </a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('product.index', 'product.show', 'product.edit', 'product.update', 'product.destroy'),
                                ])>
                                    <a href="{{ route('product.index') }}" class="sa-nav__link" @if (request()->routeIs('product.index', 'product.show', 'product.edit', 'product.update', 'product.destroy')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Products List') }}</span>
                                    </a>
                                </li>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('product.create'),
                                ])>
                                    <a href="{{ route('product.create') }}" class="sa-nav__link" @if (request()->routeIs('product.create')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Add Product') }}</span>
                                    </a>
                                </li>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('category.*'),
                                ])>
                                    <a href="{{ route('category.index') }}" class="sa-nav__link" @if (request()->routeIs('category.*')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Categories List') }}</span>
                                    </a>
                                </li>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('brand.*'),
                                ])>
                                    <a href="{{ route('brand.index') }}" class="sa-nav__link" @if (request()->routeIs('brand.*')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Brands List') }}</span>
                                    </a>
                                </li>

                            </ul>
                        </li>

                        <li @class([
                            'sa-nav__menu-item',
                            'sa-nav__menu-item--has-icon',
                            'sa-nav__menu-item--open' => request()->routeIs('pet.*'),
                        ]) data-sa-collapse-item="sa-nav__menu-item--open">
                            <a href class="sa-nav__link" data-sa-collapse-trigger>
                                <span class="sa-nav__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        width="1em"
                                        height="1em"
                                        viewBox="0 0 16 16"
                                        fill="currentColor">

                                        <circle cx="4.5" cy="5" r="1.35"/>
                                        <circle cx="6.8" cy="3.8" r="1.35"/>
                                        <circle cx="9.2" cy="3.8" r="1.35"/>
                                        <circle cx="11.5" cy="5" r="1.35"/>

                                        <path d="M8 6
                                                C5.5 6 3.5 8.2 3.5 10.5
                                                C3.5 12.8 5.3 14 8 14
                                                C10.7 14 12.5 12.8 12.5 10.5
                                                C12.5 8.2 10.5 6 8 6Z"/>
                                    </svg>
                                </span>
                                <span class="sa-nav__title">{{ __('Pets') }}</span>
                                <span class="sa-nav__arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="9" viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg>
                                </span>
                            </a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('pet.index', 'pet.edit', 'pet.update', 'pet.destroy'),
                                ])>
                                    <a href="{{ route('pet.index') }}" class="sa-nav__link" @if (request()->routeIs('pet.index', 'pet.edit', 'pet.update', 'pet.destroy')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Pets List') }}</span>
                                    </a>
                                </li>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('pet.create'),
                                ])>
                                    <a href="{{ route('pet.create') }}" class="sa-nav__link" @if (request()->routeIs('pet.create')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Create Pet') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li @class([
                            'sa-nav__menu-item',
                            'sa-nav__menu-item--has-icon',
                            'sa-nav__menu-item--open' => request()->routeIs('purchase.*'),
                        ]) data-sa-collapse-item="sa-nav__menu-item--open">
                            <a href class="sa-nav__link" data-sa-collapse-trigger>
                                <span class="sa-nav__icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewbox="0 0 16 16" fill="currentColor">
                                        <path
                                            d="M14.2,10.3c-0.1,0.4-0.5,0.7-0.9,0.7H4.8c-0.5,0-0.9-0.3-1-0.8L2.2,4C2.1,3.4,1.6,3,1,3H0.4C0.2,3,0,2.8,0,2.6V1.4C0,1.2,0.2,1,0.4,1h1.4c1,0,1.9,0.7,2.1,1.7l1.5,6.1C5.5,8.9,5.7,9,5.8,9h6.5c0.1,0,0.2-0.1,0.3-0.2l1.1-3.4C13.8,5.2,13.7,5,13.5,5H7.4C7.2,5,7,4.8,7,4.6V3.4C7,3.2,7.2,3,7.4,3H15c0.6,0,1,0.4,1,1v1L14.2,10.3z M4.5,13C5.3,13,6,13.7,6,14.5C6,15.3,5.3,16,4.5,16S3,15.3,3,14.5C3,13.7,3.7,13,4.5,13z M11.5,13c0.8,0,1.5,0.7,1.5,1.5c0,0.8-0.7,1.5-1.5,1.5S10,15.3,10,14.5C10,13.7,10.7,13,11.5,13z">
                                        </path>
                                    </svg>
                                </span>
                                <span class="sa-nav__title">{{ __('Purchases') }}</span>
                                <span class="sa-nav__arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="9" viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg>
                                </span>
                            </a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('purchase.index', 'purchase.show', 'purchase.edit', 'purchase.update', 'purchase.destroy'),
                                ])>
                                    <a href="{{ route('purchase.index') }}" class="sa-nav__link" @if (request()->routeIs('purchase.index', 'purchase.show', 'purchase.edit', 'purchase.update', 'purchase.destroy')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Purchases List') }}</span>
                                    </a>
                                </li>

                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('purchase.create'),
                                ])>
                                    <a href="{{ route('purchase.create') }}" class="sa-nav__link" @if (request()->routeIs('purchase.create')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Create Purchase') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li @class([
                            'sa-nav__menu-item',
                            'sa-nav__menu-item--has-icon',
                            'sa-nav__menu-item--open' => request()->routeIs('sale.*'),
                        ]) data-sa-collapse-item="sa-nav__menu-item--open">
                            <a href class="sa-nav__link" data-sa-collapse-trigger>
                                <span class="sa-nav__icon"><i class="fas fa-dollar-sign"></i></span>
                                <span class="sa-nav__title">{{ __('Sales') }}</span>
                                <span class="sa-nav__arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="6" height="9" viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg>
                                </span>
                            </a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('sale.index', 'sale.show', 'sale.edit', 'sale.update', 'sale.destroy'),
                                ])>
                                    <a href="{{ route('sale.index') }}" class="sa-nav__link" @if (request()->routeIs('sale.index', 'sale.show', 'sale.edit', 'sale.update', 'sale.destroy')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Sales List') }}</span>
                                    </a>
                                </li>
                                <li @class([
                                    'sa-nav__menu-item',
                                    'sa-nav__menu-item--active' => request()->routeIs('sale.create'),
                                ])>
                                    <a href="{{ route('sale.create') }}" class="sa-nav__link" @if (request()->routeIs('sale.create')) aria-current="page" @endif>
                                        <span class="sa-nav__menu-item-padding"></span>
                                        <span class="sa-nav__title">{{ __('Create Sale') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"><a href="app-file-manager.html"
                                class="sa-nav__link"><span class="sa-nav__icon"><i
                                        class="fas fa-hdd"></i></span><span class="sa-nav__title">{{ __('File Manager') }}</span></a></li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"><a href="app-calendar.html"
                                class="sa-nav__link"><span class="sa-nav__icon"><i
                                        class="fas fa-calendar-alt"></i></span><span
                                    class="sa-nav__title">{{ __('Calendar') }}</span></a></li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"><a href="app-analytics.html"
                                class="sa-nav__link"><span class="sa-nav__icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewbox="0 0 16 16" fill="currentColor">
                                        <path
                                            d="M14.5,15h-1c-0.8,0-1.5-0.7-1.5-1.5v-8C12,4.7,12.7,4,13.5,4h1C15.3,4,16,4.7,16,5.5v8C16,14.3,15.3,15,14.5,15z M8.5,15h-1C6.7,15,6,14.3,6,13.5v-11C6,1.7,6.7,1,7.5,1h1C9.3,1,10,1.7,10,2.5v11C10,14.3,9.3,15,8.5,15z M2.5,15h-1C0.7,15,0,14.3,0,13.5v-5C0,7.7,0.7,7,1.5,7h1C3.3,7,4,7.7,4,8.5v5C4,14.3,3.3,15,2.5,15z">
                                        </path>
                                    </svg></span><span class="sa-nav__title">{{ __('Analytics') }}</span></a></li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"
                            data-sa-collapse-item="sa-nav__menu-item--open"><a href class="sa-nav__link"
                                data-sa-collapse-trigger><span class="sa-nav__icon"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="1em" height="1em"
                                        viewbox="0 0 16 16" fill="currentColor">
                                        <path
                                            d="M14,6.8l-0.2,0.1C14,7.3,14,7.6,14,8c0,0.4,0,0.7-0.1,1.1L14,9.2c1,0.6,1.4,1.9,0.8,3c-0.5,0.9-1.6,1.2-2.5,0.7l-0.5-0.3c-0.6,0.5-1.2,0.8-1.9,1.1v0.8c0,0.9-0.7,1.6-1.6,1.6H7.6C6.7,16,6,15.3,6,14.4v-0.8c-0.7-0.2-1.3-0.6-1.9-1.1l-0.5,0.3c-0.9,0.5-2,0.2-2.5-0.7c-0.6-1-0.3-2.4,0.8-3l0.2-0.1C2,8.7,2,8.4,2,8c0-0.4,0-0.7,0.1-1.1L2,6.8c-1.1-0.6-1.4-2-0.8-3C1.7,3,2.8,2.7,3.6,3.2l0.5,0.3C4.7,3,5.3,2.6,6,2.4V1.6C6,0.7,6.7,0,7.6,0h0.8C9.3,0,10,0.7,10,1.6v0.8c0.7,0.2,1.3,0.6,1.9,1.1l0.5-0.3c0.9-0.5,2-0.2,2.5,0.7C15.4,4.9,15.1,6.2,14,6.8z M8,5.5C6.6,5.5,5.5,6.6,5.5,8s1.1,2.5,2.5,2.5s2.5-1.1,2.5-2.5S9.4,5.5,8,5.5z">
                                        </path>
                                    </svg></span><span class="sa-nav__title">{{ __('Settings') }}</span><span
                                    class="sa-nav__arrow"><svg xmlns="http://www.w3.org/2000/svg" width="6"
                                        height="9" viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg></span></a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li class="sa-nav__menu-item"><a href="app-settings-toc.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">{{ __('Table of Content') }}</span></a></li>
                                <li class="sa-nav__menu-item"><a href="app-settings-form.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">{{ __('Form') }}</span></a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                {{-- <li class="sa-nav__section">
                    <div class="sa-nav__section-title"><span>Pages</span></div>
                    <ul class="sa-nav__menu sa-nav__menu--root">
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"
                            data-sa-collapse-item="sa-nav__menu-item--open"><a href class="sa-nav__link"
                                data-sa-collapse-trigger><span class="sa-nav__icon"><i
                                        class="fas fa-lock"></i></span><span
                                    class="sa-nav__title">Authentication</span><span class="sa-nav__arrow"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="6" height="9"
                                        viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg></span></a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li class="sa-nav__menu-item"><a href="auth-sign-in.html" class="sa-nav__link"><span
                                            class="sa-nav__menu-item-padding"></span><span class="sa-nav__title">Sign
                                            In</span></a></li>
                                <li class="sa-nav__menu-item"><a href="auth-sign-up.html" class="sa-nav__link"><span
                                            class="sa-nav__menu-item-padding"></span><span class="sa-nav__title">Sign
                                            Up</span></a></li>
                                <li class="sa-nav__menu-item"><a href="auth-forgot-password.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Forgot
                                            Password</span></a></li>
                                <li class="sa-nav__menu-item"><a href="auth-reset-password.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Reset
                                            Password</span></a></li>
                                <li class="sa-nav__menu-item"><a href="auth-email-confirmation.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Verify
                                            Account</span></a></li>
                            </ul>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"><a href="page-invoice.html"
                                class="sa-nav__link"><span class="sa-nav__icon"><i
                                        class="fas fa-file-alt"></i></span><span
                                    class="sa-nav__title">Invoice</span></a></li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"><a href="page-pricing-table.html"
                                class="sa-nav__link"><span class="sa-nav__icon"><i
                                        class="fas fa-dollar-sign"></i></span><span class="sa-nav__title">Pricing
                                    Table</span></a></li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"><a href="page-faq.html"
                                class="sa-nav__link"><span class="sa-nav__icon"><i
                                        class="fas fa-info-circle"></i></span><span
                                    class="sa-nav__title">FAQ</span></a></li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"><a href="page-terms.html"
                                class="sa-nav__link"><span class="sa-nav__icon"><i
                                        class="fas fa-check-square"></i></span><span class="sa-nav__title">Terms
                                    And
                                    Conditions</span></a></li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"><a href="page-help-center.html"
                                class="sa-nav__link"><span class="sa-nav__icon"><i
                                        class="fas fa-question-circle"></i></span><span class="sa-nav__title">Help
                                    Center</span></a></li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"><a href="page-404.html"
                                class="sa-nav__link"><span class="sa-nav__icon"><i
                                        class="fas fa-bomb"></i></span><span class="sa-nav__title">Not
                                    Found</span></a></li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"
                            data-sa-collapse-item="sa-nav__menu-item--open"><a href class="sa-nav__link"
                                data-sa-collapse-trigger><span class="sa-nav__icon"><i
                                        class="fas fa-bars"></i></span><span class="sa-nav__title">Menu Level
                                    0</span><span class="sa-nav__arrow"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="6" height="9" viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg></span></a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li class="sa-nav__menu-item" data-sa-collapse-item="sa-nav__menu-item--open"><a href
                                        class="sa-nav__link" data-sa-collapse-trigger><span
                                            class="sa-nav__menu-item-padding"></span><span class="sa-nav__title">Menu
                                            Level 1</span><span class="sa-nav__arrow"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="6" height="9"
                                                viewbox="0 0 6 9" fill="currentColor">
                                                <path
                                                    d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                                </path>
                                            </svg></span></a>
                                    <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                        <li class="sa-nav__menu-item"
                                            data-sa-collapse-item="sa-nav__menu-item--open"><a href
                                                class="sa-nav__link" data-sa-collapse-trigger><span
                                                    class="sa-nav__menu-item-padding"></span><span
                                                    class="sa-nav__menu-item-padding"></span><span
                                                    class="sa-nav__title">Menu
                                                    Level
                                                    2</span><span class="sa-nav__arrow"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="6"
                                                        height="9" viewbox="0 0 6 9" fill="currentColor">
                                                        <path
                                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                                        </path>
                                                    </svg></span></a>
                                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                                <li class="sa-nav__menu-item"><a href class="sa-nav__link"><span
                                                            class="sa-nav__menu-item-padding"></span><span
                                                            class="sa-nav__menu-item-padding"></span><span
                                                            class="sa-nav__menu-item-padding"></span><span
                                                            class="sa-nav__title">Menu
                                                            Level
                                                            3</span></a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="sa-nav__section">
                    <div class="sa-nav__section-title"><span>Framework</span></div>
                    <ul class="sa-nav__menu sa-nav__menu--root">
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"
                            data-sa-collapse-item="sa-nav__menu-item--open"><a href class="sa-nav__link"
                                data-sa-collapse-trigger><span class="sa-nav__icon"><i
                                        class="fas fa-compass"></i></span><span
                                    class="sa-nav__title">Components</span><span class="sa-nav__arrow"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="6" height="9"
                                        viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg></span></a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li class="sa-nav__menu-item"><a href="components-accordion.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Accordion</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-alerts.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Alerts</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-badge.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Badge</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-breadcrumb.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Breadcrumb</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-buttons.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Buttons</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-button-group.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Button
                                            group</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-cards.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Cards</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-carousel.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Carousel</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-collapse.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Collapse</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-dropdowns.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Dropdowns</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-list-group.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">List
                                            group</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-modal.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Modal</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-navs.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Navs</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-nouislider.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">NoUiSlider</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-offcanvas.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Offcanvas</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-pagination.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Pagination</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-placeholders.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Placeholders</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-popovers.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Popovers</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-progress.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Progress</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-scrollspy.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Scrollspy</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-spinners.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Spinners</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-symbols.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Symbols</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-tabs.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Tabs</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-toasts.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Toasts</span></a></li>
                                <li class="sa-nav__menu-item"><a href="components-tooltips.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Tooltips</span></a></li>
                            </ul>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"
                            data-sa-collapse-item="sa-nav__menu-item--open"><a href class="sa-nav__link"
                                data-sa-collapse-trigger><span class="sa-nav__icon"><i
                                        class="fas fa-toggle-on"></i></span><span
                                    class="sa-nav__title">Forms</span><span class="sa-nav__arrow"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="6" height="9"
                                        viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg></span></a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li class="sa-nav__menu-item"><a href="forms-text-box.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Text
                                            Box</span></a></li>
                                <li class="sa-nav__menu-item"><a href="forms-text-area.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Text
                                            Area</span></a></li>
                                <li class="sa-nav__menu-item"><a href="forms-select.html" class="sa-nav__link"><span
                                            class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Select</span></a></li>
                                <li class="sa-nav__menu-item"><a href="forms-checks-and-radios.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Checks
                                            And
                                            Radios</span></a></li>
                                <li class="sa-nav__menu-item"><a href="forms-file.html" class="sa-nav__link"><span
                                            class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">File</span></a></li>
                                <li class="sa-nav__menu-item"><a href="forms-range.html" class="sa-nav__link"><span
                                            class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Range</span></a></li>
                                <li class="sa-nav__menu-item"><a href="forms-input-group.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Input
                                            Group</span></a></li>
                                <li class="sa-nav__menu-item"><a href="forms-layout.html" class="sa-nav__link"><span
                                            class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Layout</span></a></li>
                                <li class="sa-nav__menu-item"><a href="forms-help-text.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Help
                                            Text</span></a></li>
                                <li class="sa-nav__menu-item"><a href="forms-validation.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Validation</span></a></li>
                                <li class="sa-nav__menu-item">
                                    <a href="forms-quill.html" class="sa-nav__link">
                                        <span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Quill</span></a>
                                </li>
                                <li class="sa-nav__menu-item"><a href="forms-air-datepicker.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Air
                                            Datepicker</span></a></li>
                                <li class="sa-nav__menu-item"><a href="forms-select2.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Select2</span></a></li>
                            </ul>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"
                            data-sa-collapse-item="sa-nav__menu-item--open"><a href class="sa-nav__link"
                                data-sa-collapse-trigger><span class="sa-nav__icon"><i
                                        class="fas fa-table"></i></span><span
                                    class="sa-nav__title">Tables</span><span class="sa-nav__arrow"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="6" height="9"
                                        viewbox="0 0 6 9" fill="currentColor">
                                        <path
                                            d="M5.605,0.213 C6.007,0.613 6.107,1.212 5.706,1.612 L2.696,4.511 L5.706,7.409 C6.107,7.809 6.107,8.509 5.605,8.808 C5.204,9.108 4.702,9.108 4.301,8.709 L-0.013,4.511 L4.401,0.313 C4.702,-0.087 5.304,-0.087 5.605,0.213 Z">
                                        </path>
                                    </svg></span></a>
                            <ul class="sa-nav__menu sa-nav__menu--sub" data-sa-collapse-content>
                                <li class="sa-nav__menu-item"><a href="tables-basic-tables.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">Basic
                                            Tables</span></a></li>
                                <li class="sa-nav__menu-item"><a href="tables-datatables.html"
                                        class="sa-nav__link"><span class="sa-nav__menu-item-padding"></span><span
                                            class="sa-nav__title">DataTables</span></a></li>
                            </ul>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"><a href="icons.html"
                                class="sa-nav__link"><span class="sa-nav__icon"><i
                                        class="fas fa-tree"></i></span><span class="sa-nav__title">Icons</span></a>
                        </li>
                        <li class="sa-nav__menu-item sa-nav__menu-item--has-icon"><a href="charts.html"
                                class="sa-nav__link"><span class="sa-nav__icon"><i
                                        class="fas fa-chart-pie"></i></span><span
                                    class="sa-nav__title">Charts</span></a></li>
                    </ul>
                </li> --}}
            </ul>
        </div>
    </div>

    <div class="sa-app__sidebar-shadow"></div>
    <div class="sa-app__sidebar-backdrop" data-sa-close-sidebar></div>
</div><!-- sa-app__sidebar / end --><!-- sa-app__content -->
