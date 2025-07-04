<template>
    <div class="min-h-screen bg-gray-50">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-100" v-if="showHeader">
            <div class="px-4 py-3 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <button @click="goBack" v-if="showBackButton" 
                            class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-900">{{ title }}</h1>
                </div>
                
                <div class="flex items-center space-x-2" v-if="showActions">
                    <slot name="actions"></slot>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="pb-20">
            <slot></slot>
        </main>

        <!-- Bottom Navigation -->
        <BottomNavigation :pending-orders-count="pendingOrdersCount" />
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import BottomNavigation from '../Components/BottomNavigation.vue'

const props = defineProps({
    title: {
        type: String,
        default: 'App'
    },
    showHeader: {
        type: Boolean,
        default: true
    },
    showBackButton: {
        type: Boolean,
        default: false
    },
    showActions: {
        type: Boolean,
        default: false
    },
    pendingOrdersCount: {
        type: Number,
        default: 0
    }
})

const goBack = () => {
    window.history.back()
}
</script>
