<header class="site-header">
    <div class="site-header__inner">
        <a href="{{ route('home') }}" class="site-header__logo">
            <img src="{{ asset('storage/site/logo-full.png') }}" alt="Asian Groom">
        </a>

        <nav class="site-header__nav" id="primary-nav">
            <a href="{{ route('shop.index') }}" class="{{ request()->routeIs('shop.index') ? 'is-active' : '' }}">Shop</a>
            <a href="{{ route('bundle.index') }}" class="{{ request()->routeIs('bundle.*') ? 'is-active' : '' }}">Bundles</a>

            <div class="site-header__dropdown">
                <button type="button" class="site-header__dropdown-trigger">Occasions</button>
                <div class="site-header__dropdown-panel">
                    @foreach (\App\Models\Occasion::orderBy('sort_order')->get() as $occasion)
                        <a href="{{ route('shop.index', ['occasion' => $occasion->slug]) }}">{{ $occasion->name }}</a>
                    @endforeach
                </div>
            </div>

            <a href="{{ route('client-diaries') }}" class="{{ request()->routeIs('client-diaries') ? 'is-active' : '' }}">Client Diaries</a>
            <a href="{{ route('contact.show') }}" class="{{ request()->routeIs('contact.show') ? 'is-active' : '' }}">Contact</a>
        </nav>

        <div class="site-header__actions">
            <a href="{{ route('shop.cart') }}" class="site-header__cart" aria-label="Cart">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M3 4h2l2.4 12.4a2 2 0 0 0 2 1.6h7.2a2 2 0 0 0 2-1.6L20 8H6" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="9" cy="20" r="1.4"/>
                    <circle cx="17" cy="20" r="1.4"/>
                </svg>
                <span class="site-header__cart-count" data-cart-count>{{ \App\Services\Cart::count() }}</span>
            </a>

            <button type="button" class="site-header__menu-toggle" id="menu-toggle" aria-label="Menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
</header>
