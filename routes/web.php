<?php

use App\Http\Controllers\BundleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClientDiaryController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LookInquiryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\SizeGuideController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

Route::get('/bundles', [BundleController::class, 'index'])->name('bundle.index');
Route::get('/bundle/{slug}', [BundleController::class, 'show'])->name('bundle.show');

Route::get('/collections/{slug}', [CollectionController::class, 'show'])->name('collection.show');

Route::get('/cart', [CartController::class, 'index'])->name('shop.cart');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/size-guide', [SizeGuideController::class, 'index'])->name('size-guide');

Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/client-diaries', [ClientDiaryController::class, 'index'])->name('client-diaries');
Route::get('/client-diaries/more', [ClientDiaryController::class, 'loadMore'])->name('client-diaries.more');
Route::post('/client-diaries/shop-the-look', [LookInquiryController::class, 'store'])->name('look-inquiry.store');

Route::get('/sitemap.xml', [SitemapController::class, 'xml'])->name('sitemap.xml');
Route::get('/sitemap', [SitemapController::class, 'html'])->name('sitemap.html');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');
