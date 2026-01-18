import { onMounted, onUnmounted } from 'vue';

export function useKeyboardNav({ activeEntity, isExpanded, close }) {
    function handler(e) {
        if (!activeEntity.value) return;

        if (e.key === 'Escape') {
            close();
        }
    }

    onMounted(() => {
        window.addEventListener('keydown', handler);
    });

    onUnmounted(() => {
        window.removeEventListener('keydown', handler);
    });
}
