<script setup lang="ts" name="TheCard">
import type { ICardRow, ICardSize } from '~/types';
import CardRow from './CardRow.vue';
import BaseButtonIcon from './BaseButtonIcon.vue';

interface Props {
  size: ICardSize;
  rows: ICardRow[];
  tags?: string[];
  preview?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  preview: false,
});

const emit = defineEmits<{
  (event: 'remove'): void;
}>();

const sizeStyle = computed(
  () =>
    `grid-column: span ${props.size.cols}; grid-row: span ${props.size.rows};`
);

const themes = {
  default:
    'space-y-2 rounded-xl border bg-white p-4 shadow dark:border-slate-500 dark:bg-slate-500 dark:text-slate-100',
};

const theme = computed(() => themes.default);
</script>

<template>
  <div :style="sizeStyle">
    <div class="group relative min-h-full" :class="theme">
      <div
        v-if="!preview"
        class="absolute right-0 top-0 mt-4 mr-4 hidden group-hover:block"
      >
        <BaseButtonIcon icon="trash" color="danger" @click="emit('remove')" />
      </div>
      <CardRow v-for="row in props.rows" :key="row.id" v-bind="row" />
    </div>
  </div>
</template>
