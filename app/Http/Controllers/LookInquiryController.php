<?php

namespace App\Http\Controllers;

use App\Models\LookInquiry;
use Illuminate\Http\Request;

class LookInquiryController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'client_diary_photo_id' => 'nullable|exists:client_diary_photos,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:50',
            'city' => 'nullable|string|max:120',
            'sizing_mode' => 'required|in:standard,custom',
            'size' => 'required_if:sizing_mode,standard|nullable|string|max:50',
            'measurements' => 'required_if:sizing_mode,custom|nullable|array',
            'message' => 'nullable|string|max:1000',
        ]);

        $size = $data['sizing_mode'] === 'standard' ? ($data['size'] ?? null) : null;
        $measurements = $data['sizing_mode'] === 'custom' ? array_filter($data['measurements'] ?? []) : null;

        LookInquiry::create([
            'client_diary_photo_id' => $data['client_diary_photo_id'] ?? null,
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'city' => $data['city'] ?? null,
            'sizing_mode' => $data['sizing_mode'],
            'size' => $size,
            'measurements' => $measurements,
            'message' => $data['message'] ?? null,
            'status' => 'new',
        ]);

        return back()->with('status', 'Thanks — we\'ve got your details and will reach out shortly to help you shop this look.');
    }
}
