<script setup lang="ts">
import NotificationList from '../components/NotificationList.vue';
</script>

<template>
  <main class="h-full">
    <slot />
  </main>
  <NotificationList />
</template>
