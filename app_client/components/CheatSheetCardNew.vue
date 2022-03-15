<script setup lang="ts" name="CheatSheetCardNew">
interface Props {
  id: string;
  title: string;
}

const props = defineProps<Props>();

const path = {
  name: 'cheat-sheets-card-new',
  params: { id: props.id, title: props.title },
};
</script>
<template>
  <RouterLink
    :to="path"
    class="flex h-full w-full items-center justify-center rounded-xl border border-dashed border-primary-500 bg-white text-primary-900 shadow transition-all hover:-translate-y-1 hover:bg-primary-200 hover:shadow-md hover:shadow-primary-400"
  >
    <h1 class="text-2xl font-bold">Add new</h1>
  </RouterLink>
</template>
