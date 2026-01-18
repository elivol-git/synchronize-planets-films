<template>
    <ul class="entity-list">
        <li
            v-for="ship in items"
            :key="ship.id"
            class="clickable"
            @click="active = ship"
        >
            {{ ship.name }}
        </li>
    </ul>

    <EntityModal
        v-if="active"
        :entity="active"
        model="starship"
        @close="active = null"
    />
</template>

<script setup>
import { ref } from 'vue';
import EntityModal from './EntityModal.vue';

defineProps({
    items: {
        type: Array,
        default: () => []
    }
});

const active = ref(null);
</script>
