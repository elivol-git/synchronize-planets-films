<template>
    <div class="planet-links">
        <!-- FILMS -->
        <div class="planet-column">
            <div class="column-title">
                Films ({{ films.length }})
            </div>

            <ul>
                <li
                    v-for="film in displayedFilms"
                    :key="film.id"
                    class="entity-link"
                    @click="$emit('open-entity', film)"
                >
                    {{ film.title ?? 'Unknown film' }}
                </li>
            </ul>

            <div
                v-if="films.length > LIMIT"
                class="entity-link more"
                @click="showAllFilms = !showAllFilms"
            >
                {{ showAllFilms ? 'Less' : 'More…' }}
            </div>

            <div v-if="!films.length" class="empty">No films</div>
        </div>

        <div class="planet-column">
            <div class="column-title">
                Residents ({{ people.length }})
            </div>

            <ul>
                <li
                    v-for="person in displayedPeople"
                    :key="person.id"
                    class="entity-link"
                    @click="$emit('open-entity', person)"
                >
                    {{ person.name ?? 'Unknown resident' }}
                </li>
            </ul>

            <div
                v-if="people.length > LIMIT"
                class="entity-link more"
                @click="showAllPeople = !showAllPeople"
            >
                {{ showAllPeople ? 'Less' : 'More…' }}
            </div>

            <div v-if="!people.length" class="empty">No residents</div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';

const LIMIT = 5;

defineProps({
    planet: Object
});

const showAllFilms = ref(false);
const showAllPeople = ref(false);

const normalize = (v) => {
    const arr = Array.isArray(v) ? v : v?.data ?? [];
    return arr.filter(item => typeof item === 'object' && item !== null);
};

const films = computed(() => normalize(__props.planet.films));
const people = computed(() => normalize(__props.planet.people));

const displayedFilms = computed(() =>
    showAllFilms.value ? films.value : films.value.slice(0, LIMIT)
);

const displayedPeople = computed(() =>
    showAllPeople.value ? people.value : people.value.slice(0, LIMIT)
);
</script>
