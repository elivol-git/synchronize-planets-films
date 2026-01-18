<template>
    <div class="planet-grid">
        <PlanetCard
            v-for="planet in planetList"
            :key="planet.id"
            :planet="planet"
        />
    </div>
</template>

<script setup>
import { computed } from 'vue';
import PlanetCard from './PlanetCard.vue';

const props = defineProps({
    planets: [Array, Object]
});

const planetList = computed(() => {
    return Array.isArray(props.planets)
        ? props.planets
        : props.planets.data ?? [];
});
</script>

