<script setup lang="ts" name="TheGrid">
/* eslint-disable @typescript-eslint/no-non-null-assertion */
import type { Ref } from 'vue';
import { provideTheGrid } from '~/composables';
import { TheGrid } from '~/composables/TheGrid';

interface Props {
  id: number | string;
  autoHeight?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  autoHeight: TheGrid.defaults.autoHeight,
});

const emit = defineEmits<{
  (event: 'currentBreakpointUpdated', breakpoint: string): void;
}>();

const containerRef = ref<HTMLDivElement>();
const resizeObserver = ref<ResizeObserver>();

const theGrid = ref(new TheGrid(props)) as Ref<TheGrid>;
provideTheGrid(theGrid);

const currentBreakpoint = computed(() => {
  if (theGrid.value) {
    return theGrid.value.currentBreakpoint;
  }
  return null;
});

const onResize = (entries: ResizeObserverEntry[]) => {
  if (!theGrid.value) {
    return;
  }
  theGrid.value.width = entries[0]?.contentRect?.width ?? 0;
};

watch(
  () => currentBreakpoint.value,
  (breakpoint) => {
    if (breakpoint) {
      emit('currentBreakpointUpdated', breakpoint);
    }
  }
);

watch(
  () => props.autoHeight,
  (autoHeight) => {
    if (!theGrid.value || theGrid.value.autoHeight === autoHeight) {
      return;
    }

    theGrid.value.autoHeight = autoHeight;
  }
);

onMounted(() => {
  if (!containerRef.value) return;

  resizeObserver.value = new ResizeObserver(onResize);
  resizeObserver.value.observe(containerRef.value);
});

onBeforeUnmount(() => {
  resizeObserver.value?.unobserve(containerRef.value!);
});
</script>
<template>
  <div v-if="theGrid" :id="id.toString()" ref="containerRef">
    <slot></slot>
  </div>
</template>
