<template>
    <transition name="fade">
        <div
            v-if="entity"
            class="modal-window entity-tooltip"
            :style="style"
        >
            <button class="modal-close" @click="$emit('close')">×</button>

            <h4 class="planet-title">
                {{ entity.name || entity.title }}
            </h4>

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

            <div class="entity-link more" @click="$emit('open', entity)">
                Open
            </div>
        </div>
    </transition>
</template>

<script setup>
import { computed } from 'vue';

const isMobile = computed(() =>
    window.matchMedia('(max-width: 768px)').matches
);

const props = defineProps({
    entity: Object,
    x: Number,
    y: Number
});

const exclude = [
    'id','url',
    'films','people','residents',
    'vehicles','species','starships',
    'homeworld','homeworld_id',
    'created','edited','created_at','updated_at',
    'opening_crawl'
];

const info = computed(() =>
    Object.fromEntries(
        Object.entries(props.entity || {})
            .filter(([k,v]) =>
                !exclude.includes(k) &&
                typeof v !== 'object' &&
                v
            )
    )
);

const style = computed(() => {
    if (isMobile.value) {
        return {
            position: 'fixed',
            left: '50%',
            bottom: '16px',
            transform: 'translateX(-50%)',
            width: 'calc(100% - 32px)',
            maxWidth: '480px',
            zIndex: 1001
        };
    }

    return {
        position: 'fixed',
        left: props.x + 'px',
        top: props.y + 'px',
        maxWidth: '360px',
        zIndex: 1001
    };
});


const format = (k) =>
    k.replace(/_/g,' ').toUpperCase();
</script>
