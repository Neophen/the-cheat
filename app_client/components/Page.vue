<script setup lang="ts" name="Page">
import BaseCard from './BaseCard.vue';
defineProps<{ title: string }>();
</script>
<template>
  <div class="mx-auto flex max-w-7xl items-start py-6 px-4 sm:px-6 lg:px-8">
    <slot name="aside" />

    <main
      class="min-h-full w-full"
      :class="{
        'ml-8': $slots.aside,
      }"
    >
      <slot />
    </main>
  </div>
</template>
