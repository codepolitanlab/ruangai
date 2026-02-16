<div class="d-flex gap-3 border-top border-bottom py-3">
    <template x-if="data.lesson?.prev_lesson">
        <a :href="`/courses/${data.lesson.course_id}/lesson/${data.lesson?.prev_lesson.id}`" 
            class="btn btn-outline-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>
            Sebelumnya
        </a>
    </template>

    <template x-if="!data.lesson?.is_completed && data.lesson?.type == 'theory'">
        <button @click="markAsComplete(data.lesson?.course_id, data.lesson?.id, data.lesson?.next_lesson?.id)" 
                class="btn btn-success rounded-pill px-4 ms-auto" 
                :class="{'disabled': !showButtonPaham || buttonSubmitting}" 
                :disabled="buttonSubmitting">
            <template x-if="!buttonSubmitting">
                <i class="bi bi-check-circle me-2"></i>
            </template>
            <template x-if="buttonSubmitting">
                <span class="spinner-border spinner-border-sm me-2"></span>
            </template>
            <span x-text="buttonSubmitting ? 'Memproses...' : 'Saya Sudah Paham'"></span>
        </button>
    </template>

    <template x-if="data.lesson?.is_completed && data.lesson?.next_lesson">
        <a :href="`/courses/${data?.lesson?.course_id}/lesson/${data?.lesson?.next_lesson.id}`" 
            class="btn btn-primary rounded-pill px-4 ms-auto">
            Selanjutnya
            <i class="bi bi-arrow-right ms-2"></i>
        </a>
    </template>
</div>