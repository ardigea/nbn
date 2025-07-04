<template>
    <AppLayout title="Home" :show-back-button="false" :pending-orders-count="2">
        <!-- Header Section -->
        <div class="bg-white px-4 py-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Hello, {{ user.name }}!</h1>
                    <p class="text-gray-600">What would you like to eat today?</p>
                </div>
                <div class="w-12 h-12 bg-gray-200 rounded-full overflow-hidden">
                    <img :src="user.avatar" :alt="user.name" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Search Bar -->
            <div class="relative">
                <input 
                    type="text" 
                    placeholder="Search restaurants or cuisines..."
                    class="w-full p-4 pl-12 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                    v-model="searchQuery"
                >
                <svg class="absolute left-4 top-4 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Categories Section -->
        <div class="px-4 py-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Categories</h2>
            <div class="grid grid-cols-3 gap-4">
                <button 
                    v-for="category in categories" 
                    :key="category.name"
                    @click="filterByCategory(category.name)"
                    class="flex flex-col items-center p-4 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow"
                >
                    <span class="text-2xl mb-2">{{ category.icon }}</span>
                    <span class="text-sm font-medium text-gray-700">{{ category.name }}</span>
                </button>
            </div>
        </div>

        <!-- Featured Restaurants Section -->
        <div class="px-4 py-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Featured Restaurants</h2>
                <button @click="navigateToMenu" class="text-red-600 text-sm font-medium">See All</button>
            </div>

            <div class="space-y-4">
                <div 
                    v-for="restaurant in featuredRestaurants" 
                    :key="restaurant.id"
                    @click="openRestaurant(restaurant)"
                    class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow cursor-pointer"
                >
                    <div class="relative">
                        <div class="h-48 bg-gradient-to-r from-amber-900 to-amber-700 relative overflow-hidden">
                            <!-- Restaurant image placeholder -->
                            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-2 py-1 rounded-lg">
                                <div class="flex items-center space-x-1">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    <span class="text-sm font-medium text-gray-900">{{ restaurant.rating }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ restaurant.name }}</h3>
                            <p class="text-gray-600 text-sm mb-2">{{ restaurant.cuisine }} • {{ restaurant.location }}</p>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-4">
                                    <span class="text-sm text-gray-500">{{ restaurant.price_range }}</span>
                                    <span class="text-sm text-gray-500">{{ restaurant.delivery_time }}</span>
                                </div>
                                <button @click.stop="makeReservation(restaurant)" 
                                        class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700 transition-colors">
                                    Book Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="px-4 py-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-2 gap-4">
                <button @click="navigateToOrders" 
                        class="flex flex-col items-center p-6 bg-blue-50 rounded-xl hover:bg-blue-100 transition-colors">
                    <svg class="w-8 h-8 text-blue-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="text-sm font-medium text-blue-600">My Orders</span>
                </button>

                <button @click="navigateToProfile" 
                        class="flex flex-col items-center p-6 bg-green-50 rounded-xl hover:bg-green-100 transition-colors">
                    <svg class="w-8 h-8 text-green-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-sm font-medium text-green-600">Profile</span>
                </button>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '../Layouts/AppLayout.vue'

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    featuredRestaurants: {
        type: Array,
        required: true
    },
    categories: {
        type: Array,
        required: true
    }
})

const searchQuery = ref('')

const filterByCategory = (categoryName) => {
    router.visit(`/menu?category=${categoryName}`)
}

const navigateToMenu = () => {
    router.visit('/menu')
}

const navigateToOrders = () => {
    router.visit('/orders')
}

const navigateToProfile = () => {
    router.visit('/profile')
}

const openRestaurant = (restaurant) => {
    // Navigate to restaurant detail page
    router.visit(`/restaurant/${restaurant.id}`)
}

const makeReservation = (restaurant) => {
    router.visit('/reservation', {
        data: {
            restaurant: restaurant.name
        }
    })
}
</script>
