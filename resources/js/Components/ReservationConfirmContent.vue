<template>
    <div>
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

        <!-- Action Buttons -->
        <div class="px-6 py-4 space-y-3">
            <button @click="handlePayment" 
                    class="w-full bg-red-600 text-white py-4 rounded-lg font-semibold text-lg hover:bg-red-700 transition-colors">
                PAYMENT
            </button>
        </div>

        <!-- Note -->
        <div class="px-6 pb-6">
            <p class="text-xs text-gray-500 text-center">
                Note: If the customer cancels the reservation due to subjective reasons, 
                the restaurant will not be responsible for refunding the deposit.
            </p>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    reservationData: {
        type: Object,
        required: true
    },
    reservationId: {
        type: String,
        default: '716001'
    }
})

const emit = defineEmits(['payment', 'payLater'])

const depositAmount = computed(() => {
    return '200.000VND'
})

const handlePayment = () => {
    emit('payment')
}

const handlePayLater = () => {
    emit('payLater')
}
</script>
