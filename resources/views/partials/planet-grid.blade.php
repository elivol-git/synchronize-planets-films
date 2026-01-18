<div class="planet-grid">
    <div
        v-for="(planet, index) in planets.data"
        :key="planet.id"
        class="planet-card-wrapper"
    >
        @include('partials.planet-card')
    </div>
</div>

@include('partials.pagination', ['paginator' => $planets])
