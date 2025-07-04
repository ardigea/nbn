<template>
    <BasePopup 
        :show="show" 
        @close="closePopup"
        :show-handle="true"
        :show-close-button="true"
        :close-on-backdrop="true"
        max-width="max-w-md"
    >
        <ReservationConfirmContent 
            :reservation-data="reservationData"
            :reservation-id="reservationId"
            @payment="handlePayment"
            @pay-later="closePopup"
        />
    </BasePopup>
</template>

<script setup>
import BasePopup from './BasePopup.vue'
import ReservationConfirmContent from './ReservationConfirmContent.vue'

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

const closePopup = () => {
    emit('close')
}

const handlePayment = () => {
    emit('payment')
}
</script>
