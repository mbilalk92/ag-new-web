@extends('layouts.app')

@section('title', 'Contact — Asian Groom')

@section('content')
    <div class="container contact-page">
        <div class="contact-page__layout">
            <div class="contact-info">
                <p class="eyebrow">Get in touch</p>
                <h1 class="h1">Questions about sizing, custom orders, or an upcoming function?</h1>
                <p class="body">Message us or visit the store — we're happy to help you plan the look for your barat, nikkah, valima, or mehndi.</p>

                <ul class="contact-info__list">
                    <li>
                        <strong>Phone</strong>
                        <a href="tel:+923303900476">+92 330 3900476</a>
                    </li>
                    <li>
                        <strong>Email</strong>
                        <a href="mailto:info@asiangroom.com.pk">info@asiangroom.com.pk</a>
                    </li>
                    <li>
                        <strong>Store</strong>
                        <span>Main Tariq Road, Karachi 76400</span>
                    </li>
                </ul>
            </div>

            <form action="{{ route('contact.store') }}" method="post" class="contact-form">
                @csrf

                @if (session('status'))
                    <p class="alert alert--success">{{ session('status') }}</p>
                @endif

                <div class="field-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field-group">
                        <label for="phone">Phone (optional)</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="field-group">
                    <label for="subject">Subject</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}">
                </div>

                <div class="field-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="5" required>{{ old('message') }}</textarea>
                    @error('message')<span class="field-error">{{ $message }}</span>@enderror
                </div>

                <button type="submit" class="btn btn--primary btn--block">Send message</button>
            </form>
        </div>
    </div>
@endsection
