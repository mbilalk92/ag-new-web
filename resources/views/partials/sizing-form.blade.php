@php
    $measurementFields = $measurementFields ?? [];
    $hasSizes = ! empty($sizes);
    $allowCustom = ($allowCustom ?? false) && count($measurementFields) > 0;
    $showToggle = $hasSizes && $allowCustom;
    $defaultMode = $hasSizes ? 'standard' : ($allowCustom ? 'custom' : 'standard');
@endphp
<div class="sizing" data-sizing>
    @if ($hasSizes)
        <div class="field-group" data-standard-sizing @if (! $hasSizes || $defaultMode === 'custom') hidden @endif>
            <div class="sizing__header">
                <label>Size</label>
                @if ($showToggle)
                    <button type="button" class="sizing__toggle" data-sizing-toggle>Customize measurements</button>
                @endif
            </div>
            <div class="size-options">
                @foreach ($sizes as $size)
                    <label class="size-option">
                        <input type="radio" name="size" value="{{ $size }}" {{ $loop->first ? 'checked' : '' }} {{ $defaultMode === 'standard' ? 'required' : '' }} {{ $defaultMode !== 'standard' ? 'disabled' : '' }}>
                        <span>{{ $size }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    @endif

    @if ($allowCustom)
        <div class="measurement-form" data-custom-sizing @if ($defaultMode !== 'custom') hidden @endif>
            <div class="sizing__header">
                <label>Custom measurements (inches)</label>
                @if ($showToggle)
                    <button type="button" class="sizing__toggle" data-sizing-toggle>Use a standard size</button>
                @endif
            </div>
            <p class="measurement-form__hint">Not sure of a number? Leave it blank — our tailor will confirm by phone before stitching.</p>
            <div class="measurement-grid">
                @foreach ($measurementFields as $key => $label)
                    <div class="field-group">
                        <label for="measure-{{ $key }}">{{ $label }}</label>
                        <input type="number" step="0.1" min="0" id="measure-{{ $key }}" name="measurements[{{ $label }}]" {{ $defaultMode !== 'custom' ? 'disabled' : '' }}>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <input type="hidden" name="sizing_mode" value="{{ $defaultMode }}" data-sizing-mode>
</div>
