<template>
    <BasePopup 
        :show="show" 
        @close="closePopup"
        :show-handle="true"
        :show-close-button="true"
        :close-on-backdrop="false"
        max-width="max-w-sm"
    >
        <div class="px-6 py-8 text-center">
            <!-- Warning Icon -->
            <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ title }}</h3>
            
            <!-- Message -->
            <p class="text-gray-600 mb-6">{{ message }}</p>
            
            <!-- Action Buttons -->
            <div class="space-y-3">
                <button @click="handleConfirm" 
                        class="w-full bg-red-600 text-white py-3 rounded-lg font-semibold hover:bg-red-700 transition-colors">
                    {{ confirmText }}
                </button>
                
                <button @click="closePopup" 
                        class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                    {{ cancelText }}
                </button>
            </div>
        </div>
    </BasePopup>
</template>

<script setup>
import BasePopup from './BasePopup.vue'

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    title: {
        type: String,
        default: 'Are you sure?'
    },
    message: {
        type: String,
        default: 'This action cannot be undone.'
    },
    confirmText: {
        type: String,
        default: 'Delete'
    },
    cancelText: {
        type: String,
        default: 'Cancel'
    }
})

const emit = defineEmits(['close', 'confirm'])

const closePopup = () => {
    emit('close')
}

const handleConfirm = () => {
    emit('confirm')
}
</script>
