<template>
    <div class="entity-column" v-if="items.length">
        <div class="column-title">
            {{ titleLabel }} ({{ items.length }})
        </div>

        <ul>
            <li
                v-for="item in displayedItems"
                :key="item.id"
                class="entity-link"
            >
                {{ item.name || item.title }}
            </li>
        </ul>

        <div
            v-if="items.length > LIMIT"
            class="entity-link more"
            @click="expanded = !expanded"
        >
            {{ expanded ? 'Less' : 'More…' }}
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';

const LIMIT = 5;

const props = defineProps({
    title: String,
    items: Array
});

const expanded = ref(false);

const displayedItems = computed(() =>
    expanded.value ? props.items : props.items.slice(0, LIMIT)
);

const titleLabel = computed(() =>
    props.title.replace(/_/g, ' ').toUpperCase()
);
</script>
