@extends('layouts.app')

@section('title', 'Wedding Bundles — Asian Groom')

@section('content')
    <div class="container shop">
        <div class="shop__header">
            <div>
                <p class="eyebrow">Tailored sets</p>
                <h1 class="h2">Wedding bundles</h1>
            </div>
        </div>
        <p class="body" style="margin-bottom: 2rem;">Complete, coordinated looks for each function — priced together for less than buying the pieces separately.</p>

        <div class="shop__grid">
            @foreach ($bundles as $bundle)
                @include('partials.bundle-card', ['bundle' => $bundle])
            @endforeach
        </div>
    </div>
@endsection
