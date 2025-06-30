<template>
  <div class="loading-container flex items-center justify-center p-8">
    <div class="loading-spinner">
      <div class="spinner-ring"></div>
      <div class="spinner-ring"></div>
      <div class="spinner-ring"></div>
    </div>
    <span class="ml-4 text-gray-600">{{ message }}</span>
  </div>
</template>

<script setup>
defineProps({
  message: {
    type: String,
    default: 'Loading...'
  }
})
</script>

<style scoped>
.loading-spinner {
  display: flex;
  gap: 4px;
}

.spinner-ring {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  background-color: #ef4444;
  animation: bounce 1.4s ease-in-out infinite both;
}

.spinner-ring:nth-child(1) {
  animation-delay: -0.32s;
}

.spinner-ring:nth-child(2) {
  animation-delay: -0.16s;
}

@keyframes bounce {
  0%, 80%, 100% {
    transform: scale(0);
  }
  40% {
    transform: scale(1);
  }
}
</style>
