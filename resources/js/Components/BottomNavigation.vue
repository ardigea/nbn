<template>
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-40">
        <div class="flex justify-around items-center py-2 px-4">
            <!-- Home -->
            <button 
                @click="navigateTo('/')"
                :class="[
                    'flex flex-col items-center justify-center py-2 px-3 rounded-lg transition-all duration-200',
                    isActive('/') ? 'text-red-600 bg-red-50' : 'text-gray-500 hover:text-gray-700'
                ]"
            >
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-xs font-medium">Home</span>
            </button>

            <!-- Menu -->
            <button 
                @click="navigateTo('/menu')"
                :class="[
                    'flex flex-col items-center justify-center py-2 px-3 rounded-lg transition-all duration-200',
                    isActive('/menu') ? 'text-red-600 bg-red-50' : 'text-gray-500 hover:text-gray-700'
                ]"
            >
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                </svg>
                <span class="text-xs font-medium">Menu</span>
            </button>

            <!-- Book/Reserve (Center Button) -->
            <button 
                @click="navigateTo('/reservation')"
                class="flex flex-col items-center justify-center w-14 h-14 bg-red-600 text-white rounded-full shadow-lg hover:bg-red-700 transition-all duration-200 transform hover:scale-105"
            >
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
            </button>

            <!-- Orders -->
            <button 
                @click="navigateTo('/orders')"
                :class="[
                    'flex flex-col items-center justify-center py-2 px-3 rounded-lg transition-all duration-200 relative',
                    isActive('/orders') ? 'text-red-600 bg-red-50' : 'text-gray-500 hover:text-gray-700'
                ]"
            >
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span class="text-xs font-medium">Orders</span>
                <!-- Badge for pending orders -->
                <span v-if="pendingOrdersCount > 0" 
                      class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                    {{ pendingOrdersCount }}
                </span>
            </button>

            <!-- Profile -->
            <button 
                @click="navigateTo('/profile')"
                :class="[
                    'flex flex-col items-center justify-center py-2 px-3 rounded-lg transition-all duration-200',
                    isActive('/profile') ? 'text-red-600 bg-red-50' : 'text-gray-500 hover:text-gray-700'
                ]"
            >
                <svg class="w-6 h-6 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-xs font-medium">Profile</span>
            </button>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const page = usePage()

const props = defineProps({
    pendingOrdersCount: {
        type: Number,
        default: 0
    }
})

const currentRoute = computed(() => page.url)

const isActive = (route) => {
    if (route === '/') {
        return currentRoute.value === '/'
    }
    return currentRoute.value.startsWith(route)
}

const navigateTo = (route) => {
    router.visit(route)
}
</script>

<style scoped>
/* Add bottom padding to prevent content from being hidden behind the navigation */
.bottom-nav-padding {
    padding-bottom: 80px;
}
</style>
