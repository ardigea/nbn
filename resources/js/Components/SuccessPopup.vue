<template>
    <BasePopup 
        :show="show" 
        @close="closePopup"
        :show-handle="true"
        :show-close-button="true"
        :close-on-backdrop="true"
        max-width="max-w-sm"
    >
        <div class="px-6 py-8 text-center">
            <!-- Success Icon -->
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            
            <!-- Title -->
            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ title }}</h3>
            
            <!-- Message -->
            <p class="text-gray-600 mb-6">{{ message }}</p>
            
            <!-- OK Button -->
            <button @click="closePopup" 
                    class="w-full bg-green-600 text-white py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                OK
            </button>
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
        default: 'Success!'
    },
    message: {
        type: String,
        default: 'Operation completed successfully.'
    }
})

const emit = defineEmits(['close'])

const closePopup = () => {
    emit('close')
}
</script>
