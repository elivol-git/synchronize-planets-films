<template>
    <ul class="entity-list">
        <li
            v-for="film in items"
            :key="film.id"
            class="clickable"
            @click="active = film"
        >
            {{ film.title }}
        </li>
    </ul>

    <EntityModal
        v-if="active"
        :entity="active"
        model="film"
        :tabs="filmTabs"
        @close="active = null"
    />
</template>

<script setup>
import { ref } from 'vue';
import EntityModal from './EntityModal.vue';

defineProps({
    items: Array
});

const active = ref(null);

const filmTabs = [
    { key: 'vehicles', label: 'Vehicles' },
    { key: 'species', label: 'Species' },
    { key: 'starships', label: 'Starships' },
    { key: 'characters', label: 'Characters' },
];
</script>
