<template>
    <ul class="entity-list">
        <li
            v-for="person in items"
            :key="person.id"
            class="clickable"
            @click="active = person"
        >
            {{ person.name }}
        </li>
    </ul>

    <EntityModal
        v-if="active"
        :entity="active"
        model="person"
        :tabs="personTabs"
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

const personTabs = [
    { key: 'films', label: 'Films' },
    { key: 'vehicles', label: 'Vehicles' },
    { key: 'species', label: 'Species' },
    { key: 'starships', label: 'Starships' },
];
</script>
