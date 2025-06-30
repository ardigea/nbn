<template>
  <div class="mobile-app max-w-sm mx-auto bg-white min-h-screen">
    <!-- Navigation Header -->
    <div class="navigation-header bg-white px-4 py-3 flex items-center shadow-sm">
      <button @click="$emit('back')" class="text-gray-600 mr-3">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
      </button>
      <h1 class="text-lg font-semibold text-gray-800 flex-1">{{ title }}</h1>
    </div>

    <!-- Main Content -->
    <div class="main-content">
      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: 'App'
  }
})

defineEmits(['back'])
</script>

<style scoped>
.mobile-app {
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
  max-width: 375px; /* iPhone standard width */
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.status-bar {
  font-weight: 500;
}

@media (max-width: 480px) {
  .mobile-app {
    max-width: 100%;
    height: 100vh;
  }
}
</style>
