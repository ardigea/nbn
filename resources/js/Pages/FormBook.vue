<script setup>
import { Head } from '@inertiajs/vue3'
import ReservationForm from './ReservationForm.vue'

defineProps({ event: Object })
</script>

<template>
  <div>
    <Head title="Restaurant Reservation" />
    <ReservationForm />
  </div>
</template>