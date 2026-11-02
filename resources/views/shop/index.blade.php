@extends('layouts.app')

@section('title', 'Shop — Asian Groom')

@section('content')
    <div class="container shop">
        <div class="shop__header">
            <h1 class="h2">Shop</h1>
            <form method="get" class="shop__sort">
                <label for="sort">Sort</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="newest" @selected($sort === 'newest')>Newest</option>
                    <option value="price_low" @selected($sort === 'price_low')>Price: low to high</option>
                    <option value="price_high" @selected($sort === 'price_high')>Price: high to low</option>
                </select>
                @if ($activeCategory)<input type="hidden" name="category" value="{{ $activeCategory }}">@endif
                @if ($activeOccasion)<input type="hidden" name="occasion" value="{{ $activeOccasion }}">@endif
            </form>
        </div>

        <div class="shop__layout">
            <aside class="shop__filters">
                <div class="shop__filter-group">
                    <h3 class="h3">Category</h3>
                    <ul>
                        <li><a href="{{ route('shop.index', array_filter(['occasion' => $activeOccasion])) }}" class="{{ ! $activeCategory ? 'is-active' : '' }}">All</a></li>
                        @foreach ($categories as $category)
                            <li>
                                <a href="{{ route('shop.index', array_filter(['category' => $category->slug, 'occasion' => $activeOccasion])) }}" class="{{ $activeCategory === $category->slug ? 'is-active' : '' }}">
                                    {{ $category->name }} <span>({{ $category->products_count }})</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="shop__filter-group">
                    <h3 class="h3">Occasion</h3>
                    <ul>
                        <li><a href="{{ route('shop.index', array_filter(['category' => $activeCategory])) }}" class="{{ ! $activeOccasion ? 'is-active' : '' }}">All</a></li>
                        @foreach ($occasions as $occasion)
                            <li>
                                <a href="{{ route('shop.index', array_filter(['occasion' => $occasion->slug, 'category' => $activeCategory])) }}" class="{{ $activeOccasion === $occasion->slug ? 'is-active' : '' }}">
                                    {{ $occasion->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>

            <div class="shop__grid">
                @forelse ($products as $product)
                    @include('partials.product-card', ['product' => $product])
                @empty
                    <p class="body">No products match these filters yet.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
