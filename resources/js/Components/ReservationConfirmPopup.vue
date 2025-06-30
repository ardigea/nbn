<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-end justify-center">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black bg-opacity-50" @click="closePopup"></div>
        
        <!-- Popup Content -->
        <div class="relative bg-white w-full max-w-md mx-4 mb-4 rounded-t-2xl transform transition-all duration-300 ease-out"
             :class="show ? 'translate-y-0 opacity-100' : 'translate-y-full opacity-0'">
            
            <!-- Handle bar -->
            <div class="flex justify-center pt-3 pb-2">
                <div class="w-12 h-1 bg-gray-300 rounded-full"></div>
            </div>

            <!-- Header -->
            <div class="px-6 py-4 text-center border-b border-gray-100">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-900 mb-2">Your reservation is confirmed!</h2>
                <p class="text-lg font-semibold text-gray-800">
                    Your deposit for Reservation {{ reservationId }} is {{ depositAmount }}.
                </p>
                <p class="text-gray-600 mt-2">Do you want to pay now?</p>
            </div>

            <!-- Reservation Details -->
            <div class="px-6 py-4 space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Restaurant:</span>
                    <span class="font-medium">{{ reservationData.restaurant }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Date:</span>
                    <span class="font-medium">{{ reservationData.month }} {{ reservationData.date }}, {{ reservationData.year }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Time:</span>
                    <span class="font-medium">{{ reservationData.time }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Guests:</span>
                    <span class="font-medium">{{ reservationData.people }} people</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Name:</span>
                    <span class="font-medium">{{ reservationData.fullName }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Phone:</span>
                    <span class="font-medium">{{ reservationData.phone }}</span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-4 space-y-3">
                <button @click="handlePayment" 
                        class="w-full bg-red-600 text-white py-4 rounded-lg font-semibold text-lg hover:bg-red-700 transition-colors">
                    PAYMENT
                </button>
                
                <button @click="closePopup" 
                        class="w-full bg-gray-100 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors">
                    Pay Later
                </button>
            </div>

            <!-- Note -->
            <div class="px-6 pb-6">
                <p class="text-xs text-gray-500 text-center">
                    Note: If the customer cancels the reservation due to subjective reasons, 
                    the restaurant will not be responsible for refunding the deposit.
                </p>
            </div>

            <!-- Close Button -->
            <button @click="closePopup" 
                    class="absolute top-4 right-4 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    show: {
        type: Boolean,
        default: false
    },
    reservationData: {
        type: Object,
        required: true
    },
    reservationId: {
        type: String,
        default: '716001'
    }
})

const emit = defineEmits(['close', 'payment'])

const depositAmount = computed(() => {
    return '200.000VND'
})

const closePopup = () => {
    emit('close')
}

const handlePayment = () => {
    emit('payment')
    // You can add payment logic here
}
</script>

<style scoped>
/* Animation for slide up effect */
.transform {
    transition: transform 0.3s ease-out, opacity 0.3s ease-out;
}
</style>
