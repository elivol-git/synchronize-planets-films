<template>
    <div class="planet-card">
        <h3 class="planet-title">{{ planet.name }}</h3>

        <div class="planet-info">
            <div
                v-for="(value, key) in planetInfo"
                :key="key"
                class="planet-info-row"
            >
                <span class="label">{{ format(key) }}</span>
                <span class="value">{{ value }}</span>
            </div>
        </div>

        <PlanetTabs
            :planet="planet"
            @open-entity="openEntity"
            @open-list="openList"
        />

        <EntityModal
            v-if="activeEntity"
            :entity="activeEntity"
            @close="activeEntity = null"
        />
    </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import PlanetTabs from './PlanetTabs.vue';
import EntityModal from './entities/EntityModal.vue';

const props = defineProps({
    planet: Object
});

const activeEntity = ref(null);

const openEntity = (entity) => {
    activeEntity.value = entity;
};

const openList = (list) => {
    activeEntity.value = list[0];
};

function format(key) {
    return key.replace(/_/g, ' ').toUpperCase();
}

const planetInfo = computed(() => {
    const exclude = [
        'id','created','edited','url',
        'films','people','residents',
        'created_at','updated_at'
    ];

    return Object.fromEntries(
        Object.entries(props.planet)
            .filter(([k, v]) => !exclude.includes(k) && typeof v !== 'object')
    );
});
</script>
