<footer class="site-footer">
    <div class="site-footer__inner">
        <div class="site-footer__brand">
            <img src="{{ asset('storage/site/logo-full.png') }}" alt="Asian Groom" class="site-footer__logo">
            <p>Hand-finished sherwanis and groom's wear for barat, nikkah, valima, and mehndi — made in Karachi.</p>
        </div>

        <div class="site-footer__col">
            <h3 class="h3">Shop</h3>
            <ul>
                @foreach (\App\Models\Category::orderBy('sort_order')->limit(6)->get() as $category)
                    <li><a href="{{ route('shop.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="site-footer__col">
            <h3 class="h3">Get in touch</h3>
            <ul>
                <li><a href="tel:+923303900476">+92 330 3900476</a></li>
                <li><a href="mailto:info@asiangroom.com.pk">info@asiangroom.com.pk</a></li>
                <li>Main Tariq Road, Karachi 76400</li>
            </ul>
            <div class="site-footer__social">
                <a href="https://www.facebook.com/AsianGroom/" target="_blank" rel="noopener" aria-label="Facebook">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.7-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12Z"/></svg>
                </a>
                <a href="https://www.instagram.com/asian.groom/" target="_blank" rel="noopener" aria-label="Instagram">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1"/></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="site-footer__bottom">
        <p>&copy; {{ date('Y') }} Asian Groom. All rights reserved.</p>
    </div>
</footer>
