<?php

namespace App\Http\Controllers;

use App\Models\ClientDiaryPhoto;

class ClientDiaryController extends Controller
{
    public function index()
    {
        $photos = ClientDiaryPhoto::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('client-diaries', compact('photos'));
    }
}
