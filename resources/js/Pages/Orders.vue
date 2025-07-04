<template>
    <AppLayout title="My Orders" :show-back-button="false" :pending-orders-count="2">
        <!-- Order Status Filter -->
        <div class="bg-white px-4 py-4 border-b border-gray-100">
            <div class="flex space-x-2 overflow-x-auto pb-2">
                <button 
                    v-for="status in orderStatuses" 
                    :key="status.value"
                    @click="selectedStatus = status.value"
                    :class="[
                        'flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors',
                        selectedStatus === status.value 
                            ? 'bg-red-600 text-white' 
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                    ]"
                >
                    {{ status.label }}
                    <span v-if="status.count > 0" class="ml-2 bg-white bg-opacity-20 px-2 py-0.5 rounded-full text-xs">
                        {{ status.count }}
                    </span>
                </button>
            </div>
        </div>

        <!-- Orders List -->
        <div class="px-4 py-4">
            <div v-if="filteredOrders.length === 0" class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No orders found</h3>
                <p class="text-gray-600 mb-4">You haven't made any {{ selectedStatus.toLowerCase() }} reservations yet</p>
                <button @click="makeNewReservation" 
                        class="bg-red-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-red-700 transition-colors">
                    Make a Reservation
                </button>
            </div>

            <div class="space-y-4" v-else>
                <div 
                    v-for="order in filteredOrders" 
                    :key="order.id"
                    @click="viewOrderDetail(order)"
                    class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow cursor-pointer"
                >
                    <div class="p-4">
                        <!-- Order Header -->
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-gradient-to-r from-amber-900 to-amber-700 rounded-lg"></div>
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ order.restaurant_name }}</h3>
                                    <p class="text-sm text-gray-600">Reservation #{{ order.id }}</p>
                                </div>
                            </div>
                            <div :class="[
                                'px-3 py-1 rounded-full text-xs font-medium',
                                getStatusColor(order.status)
                            ]">
                                {{ getStatusLabel(order.status) }}
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="grid grid-cols-2 gap-4 mb-3 text-sm">
                            <div>
                                <p class="text-gray-600">Date & Time</p>
                                <p class="font-medium text-gray-900">{{ formatDate(order.date) }}</p>
                                <p class="font-medium text-gray-900">{{ order.time }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600">Guests</p>
                                <p class="font-medium text-gray-900">{{ order.guests }} people</p>
                            </div>
                        </div>

                        <!-- Order Total -->
                        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                            <span class="text-gray-600 text-sm">Total Amount</span>
                            <span class="font-semibold text-gray-900">{{ formatCurrency(order.total) }}</span>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2 mt-4" v-if="order.status !== 'completed'">
                            <button 
                                v-if="order.status === 'pending'"
                                @click.stop="cancelOrder(order)"
                                class="flex-1 bg-gray-100 text-gray-700 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors"
                            >
                                Cancel
                            </button>
                            <button 
                                v-if="order.status === 'confirmed'"
                                @click.stop="modifyOrder(order)"
                                class="flex-1 bg-blue-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors"
                            >
                                Modify
                            </button>
                            <button 
                                @click.stop="viewOrderDetail(order)"
                                class="flex-1 bg-red-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors"
                            >
                                View Details
                            </button>
                        </div>

                        <!-- Completed Order Actions -->
                        <div class="flex space-x-2 mt-4" v-if="order.status === 'completed'">
                            <button 
                                @click.stop="reorderRestaurant(order)"
                                class="flex-1 bg-green-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors"
                            >
                                Book Again
                            </button>
                            <button 
                                @click.stop="rateRestaurant(order)"
                                class="flex-1 bg-yellow-600 text-white py-2 rounded-lg text-sm font-medium hover:bg-yellow-700 transition-colors"
                            >
                                Rate
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floating Action Button -->
        <button 
            @click="makeNewReservation"
            class="fixed bottom-24 right-4 w-14 h-14 bg-red-600 text-white rounded-full shadow-lg hover:bg-red-700 transition-all duration-200 transform hover:scale-105 flex items-center justify-center"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
        </button>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '../Layouts/AppLayout.vue'

const props = defineProps({
    orders: {
        type: Array,
        required: true
    }
})

const selectedStatus = ref('all')

const orderStatuses = computed(() => [
    { value: 'all', label: 'All', count: props.orders.length },
    { value: 'pending', label: 'Pending', count: props.orders.filter(o => o.status === 'pending').length },
    { value: 'confirmed', label: 'Confirmed', count: props.orders.filter(o => o.status === 'confirmed').length },
    { value: 'completed', label: 'Completed', count: props.orders.filter(o => o.status === 'completed').length }
])

const filteredOrders = computed(() => {
    if (selectedStatus.value === 'all') {
        return props.orders
    }
    return props.orders.filter(order => order.status === selectedStatus.value)
})

const getStatusColor = (status) => {
    const colors = {
        pending: 'bg-yellow-100 text-yellow-800',
        confirmed: 'bg-blue-100 text-blue-800',
        completed: 'bg-green-100 text-green-800',
        cancelled: 'bg-red-100 text-red-800'
    }
    return colors[status] || 'bg-gray-100 text-gray-800'
}

const getStatusLabel = (status) => {
    const labels = {
        pending: 'Pending',
        confirmed: 'Confirmed',
        completed: 'Completed',
        cancelled: 'Cancelled'
    }
    return labels[status] || status
}

const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('en-US', { 
        weekday: 'short', 
        month: 'short', 
        day: 'numeric' 
    })
}

const formatCurrency = (amount) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(amount)
}

const viewOrderDetail = (order) => {
    router.visit(`/orders/${order.id}`)
}

const cancelOrder = (order) => {
    if (confirm('Are you sure you want to cancel this reservation?')) {
        router.post(`/orders/${order.id}/cancel`)
    }
}

const modifyOrder = (order) => {
    router.visit(`/orders/${order.id}/modify`)
}

const reorderRestaurant = (order) => {
    router.visit('/reservation', {
        data: {
            restaurant: order.restaurant_name
        }
    })
}

const rateRestaurant = (order) => {
    router.visit(`/orders/${order.id}/rate`)
}

const makeNewReservation = () => {
    router.visit('/reservation')
}
</script>
