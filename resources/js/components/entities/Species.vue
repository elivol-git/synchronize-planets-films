<template>
    <ul class="entity-list">
        <li
            v-for="species in items"
            :key="species.id"
            class="clickable"
            @click="active = species"
        >
            {{ species.name }}
        </li>
    </ul>

    <EntityModal
        v-if="active"
        :entity="active"
        model="species"
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
