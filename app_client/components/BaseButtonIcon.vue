<script setup lang="ts" name="BaseButtonIcon">
import type { Icons } from '~/types';
import BaseIcon from './BaseIcon.vue';

interface Props {
  icon: Icons;
  color?: 'default' | 'danger';
}

withDefaults(defineProps<Props>(), {
  color: 'default',
});
</script>
<template>
  <button
    class="inline-flex h-8 w-8 items-center justify-center rounded-full text-slate-500"
    :class="{
      'hover:bg-primary-100 hover:text-primary-700': color === 'default',
      'hover:bg-red-100 hover:text-red-700': color === 'danger',
    }"
  >
    <BaseIcon :icon="icon" class="h-5 w-5" />
  </button>
</template>
