@extends('layouts.app')

@section('title', 'Sitemap — Asian Groom')
@section('meta_description', 'A full list of pages on the Asian Groom website.')

@section('content')
    <div class="container sitemap-page">
        <h1 class="h2">Sitemap</h1>

        <div class="sitemap-page__grid">
            <div class="sitemap-page__col">
                <h2 class="h3">Pages</h2>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('shop.index') }}">Shop</a></li>
                    <li><a href="{{ route('bundle.index') }}">Bundles</a></li>
                    <li><a href="{{ route('client-diaries') }}">Client Diaries</a></li>
                    <li><a href="{{ route('contact.show') }}">Contact</a></li>
                    <li><a href="{{ route('shop.cart') }}">Cart</a></li>
                </ul>

                <h2 class="h3">Categories</h2>
                <ul>
                    @foreach ($categories as $category)
                        <li><a href="{{ route('shop.index', ['category' => $category->slug]) }}">{{ $category->name }} ({{ $category->products_count }})</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="sitemap-page__col">
                <h2 class="h3">Bundles</h2>
                <ul>
                    @foreach ($bundles as $bundle)
                        <li><a href="{{ route('bundle.show', $bundle->slug) }}">{{ $bundle->name }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="sitemap-page__col sitemap-page__col--wide">
                <h2 class="h3">Products</h2>
                <ul class="sitemap-page__products">
                    @foreach ($products as $product)
                        <li><a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
