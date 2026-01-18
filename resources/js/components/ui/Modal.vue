<template>
    <teleport to="body">
        <div class="modal-backdrop" @click.self="close">
            <div class="modal-window">
                <button class="modal-close" @click="close">×</button>
                <slot />
            </div>
        </div>
    </teleport>
</template>

<script setup>
defineProps({
    open: Boolean
});

const emit = defineEmits(['close']);

function close() {
    emit('close');
}
</script>
