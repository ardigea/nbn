<template>
    <MobileLayout title="Reservation">
        <!-- Restaurant Header Image -->
        <div class="restaurant-header relative">
            <div class="restaurant-image h-48 bg-gradient-to-r from-amber-900 to-amber-700 relative overflow-hidden">
                <!-- Restaurant interior background -->
                <div class="absolute bottom-0 bg-black text-white pl-3">
                    <h2 class="text-2xl font-bold mb-1">NAMARASA</h2>
                    <p class="text-sm opacity-90 mb-1">Vincom Center, No 70 Le Thanh Ton, Ben Nghe Ward, District 1,
                        HCMC</p>
                    <p class="text-sm opacity-90 mb-2">Now Open • Closes At 10:00 PM</p>
                </div>
            </div>
        </div>

        <!-- Reservation Form -->
        <div class="reservation-form bg-gray-50 px-4 py-6">
            <!-- Success Message -->
            <SuccessMessage v-if="showSuccess" title="Reservation Confirmed!" :message="successMessage"
                @close="showSuccess = false" class="mb-6" />

            <h3 class="text-xl font-semibold text-gray-800 mb-6">Reservation</h3>

            <!-- Deposit Notice -->
            <div class="deposit-notice bg-white rounded-lg p-4 mb-6 flex items-center shadow-sm">
                <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center mr-3">
                    <span class="text-red-600 font-bold">💰</span>
                </div>
                <span class="text-gray-700 font-medium">Deposit For Reservation</span>
            </div>

            <!-- Date Picker -->
            <div class="date-section mb-6">
                <h4 class="text-gray-700 font-medium mb-3">Pick your date</h4>
                <div class="date-picker bg-white rounded-lg p-4 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <select v-model="selectedMonth" class="text-gray-700 font-medium bg-transparent">
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                        </select>
                        <span class="text-gray-700 font-medium">{{ selectedYear }}</span>
                    </div>

                    <div class="date-grid grid grid-cols-7 gap-2">
                        <div v-for="date in dateOptions" :key="date.value" :class="[
                            'date-item text-center py-3 rounded-lg cursor-pointer transition-colors',
                            date.selected ? 'bg-red-600 text-white' : 'hover:bg-gray-100',
                            date.disabled ? 'opacity-40 cursor-not-allowed' : ''
                        ]" @click="!date.disabled && selectDate(date)">
                            <div class="text-lg font-medium">{{ date.day }}</div>
                            <div class="text-xs uppercase">{{ date.dayName }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Time Picker -->
            <div class="time-section mb-6">
                <h4 class="text-gray-700 font-medium mb-3">Pick your time</h4>
                <div class="time-picker bg-white rounded-lg p-4 shadow-sm">
                    <select v-model="selectedTime" class="w-full p-3 border border-gray-200 rounded-lg">
                        <option value="18h30 - 19h00">18h30 - 19h00</option>
                        <option value="19h00 - 19h30">19h00 - 19h30</option>
                        <option value="19h30 - 20h00">19h30 - 20h00</option>
                        <option value="20h00 - 20h30">20h00 - 20h30</option>
                    </select>
                </div>
            </div>

            <!-- People Counter -->
            <div class="people-section mb-6">
                <h4 class="text-gray-700 font-medium mb-3">How many people?</h4>
                <div class="people-counter bg-white rounded-lg p-4 shadow-sm flex items-center justify-between">
                    <button @click="decrementPeople" :disabled="peopleCount <= 1"
                        class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center disabled:opacity-40">
                        <span class="text-xl">-</span>
                    </button>
                    <span class="text-xl font-medium">{{ peopleCount }}</span>
                    <button @click="incrementPeople"
                        class="w-10 h-10 rounded-full border border-gray-300 flex items-center justify-center">
                        <span class="text-xl">+</span>
                    </button>
                </div>
            </div>

            <!-- Notes -->
            <div class="notes-section mb-6">
                <h4 class="text-gray-700 font-medium mb-3">Notes</h4>
                <textarea v-model="notes" placeholder="Add any special requests or notes..."
                    class="w-full p-3 border border-gray-200 rounded-lg h-24 resize-none" rows="3"></textarea>
            </div>

            <!-- User Information -->
            <div class="user-info-section mb-6">
                <h4 class="text-gray-700 font-medium mb-3">Your information</h4>
                <div class="space-y-4">
                    <input v-model="fullName" type="text" placeholder="Full name"
                        class="w-full p-3 border border-gray-200 rounded-lg">

                    <input v-model="phoneNumber" type="tel" placeholder="Phone number"
                        class="w-full p-3 border border-gray-200 rounded-lg">

                    <input v-model="email" type="text" placeholder="Email"
                        class="w-full p-3 border border-gray-200 rounded-lg">
                </div>
            </div>

            <!-- Reserve Button -->
            <button @click="submitReservation" :disabled="!canSubmit || isLoading"
                class="reserve-button w-full bg-red-600 text-white py-4 rounded-lg font-semibold text-lg disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                <LoadingSpinner v-if="isLoading" message="" class="mr-2" />
                <span v-if="!isLoading">Reserve Table</span>
                <span v-else>Processing...</span>
            </button>
        </div>

        <!-- Reservation Confirm Popup -->
        <ReservationConfirmPopup 
            :show="showConfirmPopup"
            :reservation-data="currentReservation || {}"
            @close="closeConfirmPopup"
            @payment="handlePayment"
        />
    </MobileLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import MobileLayout from '../Layouts/MobileLayout.vue'
import LoadingSpinner from '../Components/LoadingSpinner.vue'
import SuccessMessage from '../Components/SuccessMessage.vue'
import ReservationConfirmPopup from '../Components/ReservationConfirmPopup.vue'

// Reactive data
const selectedMonth = ref('September')
const selectedYear = ref('2021')
const selectedTime = ref('18h30 - 19h00')
const peopleCount = ref(2)
const notes = ref('')
const fullName = ref('')
const phoneNumber = ref('')
const email = ref('')
const selectedDate = ref(null)
const isLoading = ref(false)
const showSuccess = ref(false)
const successMessage = ref('')
const showConfirmPopup = ref(false)
const currentReservation = ref(null)

// Date options
const dateOptions = ref([
    { day: 23, dayName: 'MO', value: 23, disabled: false, selected: false },
    { day: 24, dayName: 'TU', value: 24, disabled: false, selected: false },
    { day: 25, dayName: 'WE', value: 25, disabled: false, selected: true },
    { day: 26, dayName: 'TH', value: 26, disabled: false, selected: false },
    { day: 27, dayName: 'FR', value: 27, disabled: false, selected: false },
    { day: 28, dayName: 'SA', value: 28, disabled: false, selected: false },
])

// Computed properties
const canSubmit = computed(() => {
    return fullName.value.trim() && phoneNumber.value.trim() && selectedDate.value
})

// Methods
const selectDate = (date) => {
    dateOptions.value.forEach(d => d.selected = false)
    date.selected = true
    selectedDate.value = date.value
}

const incrementPeople = () => {
    if (peopleCount.value < 10) {
        peopleCount.value++
    }
}

const decrementPeople = () => {
    if (peopleCount.value > 1) {
        peopleCount.value--
    }
}

const submitReservation = async () => {
    if (!canSubmit.value) return

    isLoading.value = true

    const reservation = {
        restaurant: 'NAMARASA',
        date: selectedDate.value,
        month: selectedMonth.value,
        year: selectedYear.value,
        time: selectedTime.value,
        people: peopleCount.value,
        notes: notes.value,
        fullName: fullName.value,
        phone: phoneNumber.value,
        email: email.value
    }

    // Simulate API call
    setTimeout(() => {
        currentReservation.value = reservation
        showConfirmPopup.value = true
        isLoading.value = false
    }, 1500)

    // If you want to keep the original API call, uncomment this:
    /*
    router.post('/reservation', reservation, {
        onSuccess: () => {
            currentReservation.value = reservation
            showConfirmPopup.value = true
        },
        onError: (errors) => {
            console.error('Reservation failed:', errors)
            alert('Failed to submit reservation. Please check your information and try again.')
        },
        onFinish: () => {
            isLoading.value = false
        }
    })
    */
}

const resetForm = () => {
    fullName.value = ''
    phoneNumber.value = ''
    notes.value = ''
    peopleCount.value = 2
    showSuccess.value = false
}

const closeConfirmPopup = () => {
    showConfirmPopup.value = false
    // Reset form after closing popup
    setTimeout(() => {
        resetForm()
    }, 300)
}

const handlePayment = () => {
    showConfirmPopup.value = false
    // Here you can redirect to payment page or handle payment logic
    alert('Redirecting to payment...')
    setTimeout(() => {
        resetForm()
    }, 300)
}

// Initialize selected date
selectedDate.value = 25
</script>

<style scoped>
.restaurant-image {
    background-image: url('assets/restaurant.png');
    /* Replace with your image path */
    background-size: cover;
    background-position: center;
}

.date-item {
    min-height: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}

.phone-input select {
    min-width: 80px;
}

.reserve-button {
    transition: all 0.2s ease;
}

.reserve-button:hover:not(:disabled) {
    background-color: #dc2626;
    transform: translateY(-1px);
}

.reserve-button:active:not(:disabled) {
    transform: translateY(0);
}

/* Ensure popup appears above all content */
:deep(.fixed) {
    z-index: 9999;
}
</style>
