<template>
    <AppLayout title="Restaurants" :show-back-button="false" :pending-orders-count="2">
        <!-- Filter Header -->
        <div class="bg-white px-4 py-4 border-b border-gray-100">
            <!-- Search Bar -->
            <div class="relative mb-4">
                <input 
                    type="text" 
                    placeholder="Search restaurants..."
                    class="w-full p-3 pl-10 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                    v-model="searchQuery"
                >
                <svg class="absolute left-3 top-3 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <!-- Category Filter -->
            <div class="flex space-x-2 overflow-x-auto pb-2">
                <button 
                    v-for="category in categories" 
                    :key="category.name"
                    @click="selectCategory(category.name)"
                    :class="[
                        'flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-colors',
                        category.active 
                            ? 'bg-red-600 text-white' 
                            : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                    ]"
                >
                    {{ category.name }}
                </button>
            </div>
        </div>

        <!-- Restaurants List -->
        <div class="px-4 py-4">
            <div class="flex items-center justify-between mb-4">
                <p class="text-gray-600 text-sm">{{ filteredRestaurants.length }} restaurants found</p>
                <button class="flex items-center space-x-2 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path>
                    </svg>
                    <span>Sort</span>
                </button>
            </div>

            <div class="space-y-4">
                <div 
                    v-for="restaurant in filteredRestaurants" 
                    :key="restaurant.id"
                    @click="openRestaurant(restaurant)"
                    class="bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow cursor-pointer"
                >
                    <div class="flex">
                        <!-- Restaurant Image -->
                        <div class="w-24 h-24 bg-gradient-to-r from-amber-900 to-amber-700 flex-shrink-0 relative">
                            <div class="absolute inset-0 bg-black bg-opacity-20"></div>
                            <div v-if="!restaurant.is_open" 
                                 class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                                <span class="text-white text-xs font-medium">CLOSED</span>
                            </div>
                        </div>

                        <!-- Restaurant Info -->
                        <div class="flex-1 p-4">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900 mb-1">{{ restaurant.name }}</h3>
                                    <p class="text-sm text-gray-600 mb-2">{{ restaurant.cuisine }} • {{ restaurant.location }}</p>
                                    
                                    <div class="flex items-center space-x-4 text-xs text-gray-500">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                            <span>{{ restaurant.rating }}</span>
                                        </div>
                                        <span>{{ restaurant.price_range }}</span>
                                        <span>{{ restaurant.delivery_time }}</span>
                                    </div>
                                </div>

                                <!-- Book Button -->
                                <button 
                                    @click.stop="makeReservation(restaurant)"
                                    :disabled="!restaurant.is_open"
                                    :class="[
                                        'px-3 py-1 rounded-lg text-xs font-medium transition-colors',
                                        restaurant.is_open 
                                            ? 'bg-red-600 text-white hover:bg-red-700' 
                                            : 'bg-gray-200 text-gray-500 cursor-not-allowed'
                                    ]"
                                >
                                    {{ restaurant.is_open ? 'Book' : 'Closed' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-if="filteredRestaurants.length === 0" class="text-center py-12">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No restaurants found</h3>
                <p class="text-gray-600">Try adjusting your search or filter criteria</p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '../Layouts/AppLayout.vue'

const props = defineProps({
    restaurants: {
        type: Array,
        required: true
    },
    categories: {
        type: Array,
        required: true
    }
})

const searchQuery = ref('')
const selectedCategory = ref('All')

const filteredRestaurants = computed(() => {
    let filtered = props.restaurants

    // Filter by category
    if (selectedCategory.value !== 'All') {
        filtered = filtered.filter(restaurant => 
            restaurant.cuisine.toLowerCase() === selectedCategory.value.toLowerCase()
        )
    }

    // Filter by search query
    if (searchQuery.value) {
        filtered = filtered.filter(restaurant =>
            restaurant.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            restaurant.cuisine.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
            restaurant.location.toLowerCase().includes(searchQuery.value.toLowerCase())
        )
    }

    return filtered
})

const selectCategory = (categoryName) => {
    selectedCategory.value = categoryName
    // Update active state
    props.categories.forEach(cat => {
        cat.active = cat.name === categoryName
    })
}

const openRestaurant = (restaurant) => {
    router.visit(`/restaurant/${restaurant.id}`)
}

const makeReservation = (restaurant) => {
    if (!restaurant.is_open) return
    
    router.visit('/reservation', {
        data: {
            restaurant: restaurant.name
        }
    })
}
</script>
