<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Planets & Films</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css">
    <style>
        body { padding: 20px; }
        h2 { margin-top: 30px; }
        .planet { margin-bottom: 40px; }
        .film { margin-left: 20px; margin-bottom: 10px; }
        .film-title { font-weight: bold; }
    </style>
</head>
<body>
<h1>Star Wars Planets & Films</h1>
@if ($planets->count())
@foreach($planets as $planet)
    <div class="planet">
        <div class="card">
            <h3>{{ $planet->name }}</h3>
        </div>
        <p>
            <strong>Climate:</strong> {{ $planet->climate }} <br>
            <strong>Terrain:</strong> {{ $planet->terrain }} <br>
            <strong>Population:</strong> {{ $planet->population }}
        </p>
        <p>Updated at: {{ $planet->updated_at->format('Y-m-d H:i') }}</p>

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
@endforeach

    {{ $planets->links('vendor.pagination.skeleton') }}

@else
<p class="error">There are no films for now, please check later</p>
@endif
</body>
</html>
