<?php

namespace App\Http\Controllers;

use App\Models\ClientDiaryPhoto;

class ClientDiaryController extends Controller
{
    const PER_PAGE = 24;

    public function index()
    {
        $photos = ClientDiaryPhoto::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(self::PER_PAGE);

        return view('client-diaries', compact('photos'));
    }

    public function loadMore()
    {
        $photos = ClientDiaryPhoto::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->paginate(self::PER_PAGE);

        $html = $photos->isEmpty() ? '' : view('partials.client-diary-items', compact('photos'))->render();

        return response($html)->header('X-Has-More-Pages', $photos->hasMorePages() ? '1' : '0');
    }
}
