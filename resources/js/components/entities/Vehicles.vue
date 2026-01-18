<template>
    <ul class="entity-list">
        <li
            v-for="vehicle in items"
            :key="vehicle.id"
            class="clickable"
            @click="active = vehicle"
        >
            {{ vehicle.name }}
        </li>
    </ul>

    <EntityModal
        v-if="active"
        :entity="active"
        model="vehicle"
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
