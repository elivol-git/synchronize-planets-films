<template>
    <div
        class="modal-window"
        :class="{ expanded }"
        @keydown.esc="$emit('close')"
        tabindex="0"
    >
        <button class="modal-close" @click="$emit('close')">×</button>

        <h3 class="planet-title">
            {{ entity.name || entity.title }}
        </h3>

        <div class="planet-info">
            <div
                v-for="(value, key) in info"
                :key="key"
                class="planet-info-row"
            >
                <span class="label">{{ format(key) }}</span>
                <span class="value">{{ value }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted } from 'vue';

const props = defineProps({
    entity: Object,
    expanded: Boolean
});

const emit = defineEmits(['close']);

const exclude = [
    'id','url','created','edited',
    'films','people','residents',
    'vehicles','species','starships',
    'homeworld','homeworld_id'
];

const info = computed(() =>
    Object.fromEntries(
        Object.entries(props.entity)
            .filter(([k, v]) => !exclude.includes(k) && typeof v !== 'object')
    )
);

function format(k) {
    return k.replace(/_/g, ' ').toUpperCase();
}

onMounted(() => {
    document.activeElement?.blur();
});
</script>
