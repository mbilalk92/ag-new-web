<div class="look-modal" id="look-modal" aria-hidden="true">
    <div class="look-modal__panel">
        <button type="button" class="look-modal__close" id="look-modal-close" aria-label="Close">&times;</button>

        <div class="look-modal__photo">
            <img src="" alt="" id="look-modal-image">
        </div>

        <div class="look-modal__body">
            <p class="eyebrow">Shop this look</p>
            <h2 class="h3">Tell us about yourself</h2>
            <p class="body">Share your details and sizing — we'll reach out to help you recreate this look, tailored to you.</p>

            <form action="{{ route('look-inquiry.store') }}" method="post" id="look-modal-form">
                @csrf
                <input type="hidden" name="client_diary_photo_id" id="look-modal-photo-id">

                <div class="field-row">
                    <div class="field-group">
                        <label for="look-name">Full name</label>
                        <input type="text" id="look-name" name="name" required>
                    </div>
                    <div class="field-group">
                        <label for="look-phone">Phone</label>
                        <input type="tel" id="look-phone" name="phone" required>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label for="look-email">Email</label>
                        <input type="email" id="look-email" name="email" required>
                    </div>
                    <div class="field-group">
                        <label for="look-city">City</label>
                        <input type="text" id="look-city" name="city">
                    </div>
                </div>

                @include('partials.sizing-form', [
                    'sizes' => ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'],
                    'allowCustom' => true,
                    'measurementFields' => \App\Models\Category::MEASUREMENT_FIELDS['top'],
                ])

                <div class="field-group">
                    <label for="look-message">Anything else? (optional)</label>
                    <textarea id="look-message" name="message" rows="3" placeholder="e.g. which function it's for, preferred colour"></textarea>
                </div>

                <button type="submit" class="btn btn--primary btn--block">Send my details</button>
            </form>
        </div>
    </div>
</div>
