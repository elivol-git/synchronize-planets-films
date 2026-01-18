<div v-if="modalItem" class="modal-overlay" @click.self="closeModal">
    <div class="modal">

        <h3>@{{ modalItem?.name }}</h3>

        <div class="modal-content">
            <div
                v-for="field in entityFields(modalItem)"
                :key="field"
            >
                <strong>@{{ formatLabel(field) }}:</strong>
                <span>@{{ modalItem[field] ?? '-' }}</span>
            </div>
        </div>

        <button class="modal-close" @click="closeModal">Close</button>
    </div>
</div>
