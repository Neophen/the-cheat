<script setup lang="ts" name="CheatSheetNew">
const emit = defineEmits<{
  (event: 'click'): void;
}>();
</script>
<template>
  <button
    type="button"
    @click="emit('click')"
    class="h-full w-full rounded-xl border border-dashed border-primary-500 bg-white p-6 text-primary-900 shadow transition-all hover:-translate-y-1 hover:bg-primary-200 hover:shadow-md hover:shadow-primary-400"
  >
    <h1 class="text-2xl font-bold">Add new</h1>
  </button>
</template>
