<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-end justify-center">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black bg-opacity-50" @click="handleBackdropClick"></div>
        
        <!-- Popup Content -->
        <div class="relative bg-white w-full mx-4 mb-4 rounded-t-2xl transform transition-all duration-300 ease-out"
             :class="[
                 show ? 'translate-y-0 opacity-100' : 'translate-y-full opacity-0',
                 maxWidth
             ]">
            
            <!-- Handle bar -->
            <div class="flex justify-center pt-3 pb-2" v-if="showHandle">
                <div class="w-12 h-1 bg-gray-300 rounded-full"></div>
            </div>

            <!-- Close Button -->
            <button v-if="showCloseButton" @click="closePopup" 
                    class="absolute top-4 right-4 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors z-10">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <!-- Content Slot -->
            <div class="popup-content">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    showHandle: {
        type: Boolean,
        default: true
    },
    showCloseButton: {
        type: Boolean,
        default: true
    },
    closeOnBackdrop: {
        type: Boolean,
        default: true
    },
    maxWidth: {
        type: String,
        default: 'max-w-md'
    }
})

const emit = defineEmits(['close'])

const closePopup = () => {
    emit('close')
}

const handleBackdropClick = () => {
    if (props.closeOnBackdrop) {
        closePopup()
    }
}
</script>

<style scoped>
/* Animation for slide up effect */
.transform {
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
}

/* Ensure popup appears above all content */
.fixed {
    z-index: 9999;
}
</style>
