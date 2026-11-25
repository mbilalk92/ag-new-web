@extends('layouts.app')

@section('title', 'Size Guide — Asian Groom')

@section('meta_description', 'How to measure for a sherwani, shalwar kameez, pajama, khussa, and turban — plus standard size charts for groom\'s wear from Asian Groom.')

@section('content')
    @php
        $sections = [
            'sherwani' => 'Sherwani',
            'shalwar-kameez' => 'Shalwar Kameez',
            'pajama' => 'Pajama',
            'khussa' => 'Khussa / Shoes',
            'turban' => 'Turban',
        ];
    @endphp

    <div class="container size-guide-page">
        <div class="size-guide__intro">
            <p class="eyebrow">Fit guide</p>
            <h1 class="h1">How to measure for your size</h1>
            <p class="body">Every size below is approximate — if you'd rather not guess, choose <strong>Customize measurements</strong> on any product page and our tailor will confirm your fit by phone before stitching. For an accurate self-measurement, use a soft tape measure, keep it snug but not tight, and measure over light clothing.</p>
        </div>

        <nav class="size-guide__nav" aria-label="Size guide sections">
            @foreach ($sections as $id => $label)
                <a href="#{{ $id }}">{{ $label }}</a>
            @endforeach
        </nav>

        <section id="sherwani" class="size-guide__section">
            <div class="size-guide__diagram">
                @include('partials.size-guide-diagrams.sherwani')
            </div>
            <div class="size-guide__content">
                <h2 class="h2">Sherwani</h2>
                <ol class="size-guide__steps">
                    <li><strong>Chest</strong> — around the fullest part of your chest, under the arms, tape held level.</li>
                    <li><strong>Shoulder</strong> — across the back, from one shoulder seam to the other.</li>
                    <li><strong>Sleeve length</strong> — from the shoulder seam to the wrist bone, with your arm slightly bent.</li>
                    <li><strong>Sherwani length</strong> — from the base of the collar, down the back, to where you want the hem to fall.</li>
                    <li><strong>Neck</strong> — around the base of your neck, where the collar will sit.</li>
                </ol>

                <div class="size-table-wrap">
                    <table class="size-table">
                        <thead>
                            <tr>
                                <th>Size</th><th>Chest</th><th>Shoulder</th><th>Sleeve</th><th>Length</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>S</td><td>38&quot;</td><td>17&quot;</td><td>24.5&quot;</td><td>42&quot;</td></tr>
                            <tr><td>M</td><td>40&quot;</td><td>17.5&quot;</td><td>25&quot;</td><td>43&quot;</td></tr>
                            <tr><td>L</td><td>42&quot;</td><td>18&quot;</td><td>25.5&quot;</td><td>44&quot;</td></tr>
                            <tr><td>XL</td><td>44&quot;</td><td>18.5&quot;</td><td>26&quot;</td><td>45&quot;</td></tr>
                            <tr><td>XXL</td><td>46&quot;</td><td>19&quot;</td><td>26.5&quot;</td><td>46&quot;</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="shalwar-kameez" class="size-guide__section">
            <div class="size-guide__diagram">
                @include('partials.size-guide-diagrams.shalwar-kameez')
            </div>
            <div class="size-guide__content">
                <h2 class="h2">Shalwar Kameez</h2>
                <ol class="size-guide__steps">
                    <li><strong>Chest</strong> — around the fullest part of the chest, tape level under the arms.</li>
                    <li><strong>Waist</strong> — around your natural waistline, where the shalwar nala (drawstring) will sit.</li>
                    <li><strong>Shoulder</strong> — across the back, shoulder seam to shoulder seam.</li>
                    <li><strong>Kameez length</strong> — from the shoulder down to where you want the hem, usually mid-thigh to knee.</li>
                    <li><strong>Shalwar length</strong> — from the waist down the outside of the leg to the ankle bone.</li>
                </ol>

                <div class="size-table-wrap">
                    <table class="size-table">
                        <thead>
                            <tr>
                                <th>Size</th><th>Chest</th><th>Waist</th><th>Kameez length</th><th>Shalwar length</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>S</td><td>38&quot;</td><td>32&quot;</td><td>40&quot;</td><td>40&quot;</td></tr>
                            <tr><td>M</td><td>40&quot;</td><td>34&quot;</td><td>41&quot;</td><td>41&quot;</td></tr>
                            <tr><td>L</td><td>42&quot;</td><td>36&quot;</td><td>42&quot;</td><td>42&quot;</td></tr>
                            <tr><td>XL</td><td>44&quot;</td><td>38&quot;</td><td>43&quot;</td><td>43&quot;</td></tr>
                            <tr><td>XXL</td><td>46&quot;</td><td>40&quot;</td><td>44&quot;</td><td>44&quot;</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="pajama" class="size-guide__section">
            <div class="size-guide__diagram">
                @include('partials.size-guide-diagrams.pajama')
            </div>
            <div class="size-guide__content">
                <h2 class="h2">Pajama</h2>
                <ol class="size-guide__steps">
                    <li><strong>Waist</strong> — around your natural waistline, where the drawstring sits.</li>
                    <li><strong>Hip</strong> — around the fullest part of your hips.</li>
                    <li><strong>Length</strong> — from the waist down the outside of the leg to the ankle bone.</li>
                    <li><strong>Ankle opening</strong> — around the leg opening at the hem, relaxed.</li>
                </ol>

                <div class="size-table-wrap">
                    <table class="size-table">
                        <thead>
                            <tr>
                                <th>Size</th><th>Waist</th><th>Hip</th><th>Length</th><th>Ankle opening</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>S</td><td>32&quot;</td><td>38&quot;</td><td>39&quot;</td><td>7&quot;</td></tr>
                            <tr><td>M</td><td>34&quot;</td><td>40&quot;</td><td>40&quot;</td><td>7.5&quot;</td></tr>
                            <tr><td>L</td><td>36&quot;</td><td>42&quot;</td><td>41&quot;</td><td>8&quot;</td></tr>
                            <tr><td>XL</td><td>38&quot;</td><td>44&quot;</td><td>42&quot;</td><td>8.5&quot;</td></tr>
                            <tr><td>XXL</td><td>40&quot;</td><td>46&quot;</td><td>43&quot;</td><td>9&quot;</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="khussa" class="size-guide__section">
            <div class="size-guide__diagram">
                @include('partials.size-guide-diagrams.khussa')
            </div>
            <div class="size-guide__content">
                <h2 class="h2">Khussa / Shoes</h2>
                <ol class="size-guide__steps">
                    <li><strong>Foot length</strong> — stand on a sheet of paper, mark the heel and longest toe, then measure the distance in centimetres.</li>
                    <li><strong>Foot width</strong> — across the widest part of your foot, usually just behind the toes.</li>
                    <li>Khussas run true to a snug traditional fit — if you're between sizes, size up for comfort over a long function.</li>
                </ol>

                <div class="size-table-wrap">
                    <table class="size-table">
                        <thead>
                            <tr>
                                <th>UK</th><th>EU</th><th>Foot length</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>6</td><td>40</td><td>25.0 cm</td></tr>
                            <tr><td>7</td><td>41</td><td>25.7 cm</td></tr>
                            <tr><td>8</td><td>42</td><td>26.4 cm</td></tr>
                            <tr><td>9</td><td>43</td><td>27.1 cm</td></tr>
                            <tr><td>10</td><td>44</td><td>27.8 cm</td></tr>
                            <tr><td>11</td><td>45</td><td>28.5 cm</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section id="turban" class="size-guide__section">
            <div class="size-guide__diagram">
                @include('partials.size-guide-diagrams.turban')
            </div>
            <div class="size-guide__content">
                <h2 class="h2">Turban (Pagri / Safa)</h2>
                <ol class="size-guide__steps">
                    <li><strong>Head circumference</strong> — wrap the tape around your head, just above the ears and eyebrows, where the turban base will sit.</li>
                    <li>Pre-tied safas are mounted on an inner cap sized to your head circumference, so the drape stays consistent all day.</li>
                    <li>Ordering loose fabric to tie yourself? A standard safa length is 5.5–6.5 metres — go longer for a fuller, more layered look.</li>
                </ol>

                <div class="size-table-wrap">
                    <table class="size-table">
                        <thead>
                            <tr>
                                <th>Size</th><th>Head circumference</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>S</td><td>21.5&quot; – 22&quot;</td></tr>
                            <tr><td>M</td><td>22&quot; – 22.5&quot;</td></tr>
                            <tr><td>L</td><td>22.5&quot; – 23&quot;</td></tr>
                            <tr><td>XL</td><td>23&quot; – 23.5&quot;</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <div class="size-guide__cta">
            <p class="body">Still unsure? Our tailors are happy to guide you over the phone.</p>
            <a href="{{ route('contact.show') }}" class="btn btn--primary">Contact us</a>
        </div>
    </div>
@endsection
