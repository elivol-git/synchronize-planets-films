<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Planets & Films</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/theme-toggle.js') }}"></script>
</head>
<body>
<div class="theme-toggle-wrapper">
    <div id="themeToggle" class="theme-toggle">
        <span id="themeIcon">☀️</span>
    </div>
</div>
<div class="header">
    <a href="/"><img src="{{ asset('images/logo_gold.png') }}" alt="Star Wars Logo" class="logo"></a>
    <h1 class="title">Star Wars Planets & Films</h1>
</div>

@if ($planets->count())
    @foreach($planets as $planet)
        <div class="planet-card">


            <div class="planet-row">

                <!-- LEFT COLUMN: Planet properties -->

                <div class="planet-properties">
                    <h3 class="planet-title">{{ $planet->name }}</h3>
                    <p><strong>Climate:</strong> {{ $planet->climate }}</p>
                    <p><strong>Terrain:</strong> {{ $planet->terrain }}</p>
                    <p><strong>Population:</strong> {{ $planet->population }}</p>
                    <p><strong>Rotation period:</strong> {{ $planet->rotation_period }}</p>
                    <p><strong>Orbital period:</strong> {{ $planet->orbital_period }}</p>
                    <p><strong>Diameter:</strong> {{ $planet->diameter }}</p>
                    <p><strong>Gravity:</strong> {{ $planet->gravity }}</p>
                    <p><strong>Surface water:</strong> {{ $planet->surface_water }}</p>

                </div>

                <!-- RIGHT COLUMN: Films -->
                <div class="planet-films">
                    @if($planet->films->count())
                        <h4>Films:</h4>
                        @foreach($planet->films as $film)
                            <div class="film">
                                <div class="film-title">{{ $film->title }} (Episode {{ $film->episode_id }})</div>
                                <div><strong>Director:</strong> {{ $film->director }}</div>
                                <div><strong>Producer:</strong> {{ $film->producer }}</div>
                                <div><strong>Release:</strong> {{ $film->release_date }}</div>
                                <p>{{ $film->opening_crawl }}</p>
                            </div>
                        @endforeach
                    @else
                        <p>No films found for this planet.</p>
                    @endif
                </div>

            </div>

        </div>
    @endforeach

    {{ $planets->links('vendor.pagination.skeleton') }}
<div class="updated-time">
    Last Updated: {{ $planets->max('updated_at')->format('Y-m-d H:i') }}
</div>
@else
<p class="error">There are no films for now, please check later</p>
@endif
</body>
</html>
