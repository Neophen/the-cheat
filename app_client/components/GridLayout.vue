<script setup lang="ts" name="GridLayout">
import type { WatchStopHandle } from 'vue';
import { injectTheGrid, GridLayout, provideGridLayout } from '~/composables';
import type { Item, Margin } from '~/types';

import GridLayoutItem from './GridLayoutItem.vue';

interface Props {
  breakpoint: string;
  breakpointWidth?: number;
  numberOfCols?: number;
  useCssTransforms?: boolean;
  compact?: boolean;
  margin?: Margin;
  rowHeight?: boolean | number;
  maxRowHeight?: boolean | number;
  minRowHeight?: boolean | number;
  colWidth?: boolean | number;
  maxColWidth?: boolean | number;
  minColWidth?: boolean | number;
  debug?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  breakpoint: '',
  breakpointWidth: GridLayout.defaults.breakpointWidth,
  numberOfCols: GridLayout.defaults.numberOfCols,
  useCssTransforms: GridLayout.defaults.useCssTransforms,
  compact: GridLayout.defaults.compact,
  margin: () => GridLayout.defaults.margin,
  rowHeight: GridLayout.defaults.rowHeight,
  maxRowHeight: GridLayout.defaults.maxRowHeight,
  minRowHeight: GridLayout.defaults.minRowHeight,
  colWidth: GridLayout.defaults.colWidth,
  maxColWidth: GridLayout.defaults.maxColWidth,
  minColWidth: GridLayout.defaults.minColWidth,
  debug: false,
});

const attrs = useAttrs();
const theGrid = injectTheGrid();

const theGridLayout = ref<GridLayout>();
provideGridLayout(theGridLayout);

const placeholderId = '-1Placeholder';
const placeholderY = ref(0);
const placeholderHeight = ref(0);
const placeholderMaxWidth = ref(false);
const unWatch = ref<WatchStopHandle>();

const currentBreakpoint = computed(() => {
  if (theGrid.value) {
    return theGrid.value.currentBreakpoint;
  }
  return '';
});

const dragging = computed(() => {
  return theGridLayout.value?.itemBeingDragged || false;
});
const resizing = computed(() => {
  return theGridLayout.value?.itemBeingResized || false;
});
const placeholder = computed(() => {
  return theGridLayout.value?.placeholder?.toItem() || '';
});
const itemsFromLayout = computed(() => {
  return theGridLayout.value?.items || [];
});
const height = computed(() => {
  if (theGridLayout.value) {
    return theGridLayout.value.height + 'px';
  }
  return '0px';
});
const width = computed(() => {
  if (theGridLayout.value) {
    return theGridLayout.value.width + 'px';
  }
  return '0px';
});

watch(
  () => props,
  (_) => {
    if (!theGridLayout.value) {
      return;
    }

    // if (theGridLayout.value[key] === newValue) {
    //     return;
    //   }

    //   theGridLayout.value[key] = newValue;
  },
  { deep: true }
);

// eslint-disable-next-line @typescript-eslint/no-empty-function
const createPropWatchers = () => {};

onMounted(() => {
  let initialItems = (attrs?.items as Item[]) || ([] as Item[]);

  theGridLayout.value = new GridLayout({ ...props, initialItems });
  //Check if dashboard exists and if not then start a watcher
  if (theGrid.value) {
    theGrid.value.addLayoutInstance(theGridLayout.value);
    createPropWatchers();
  } else {
    unWatch.value = watch(
      () => theGrid.value,
      (createdGrid) => {
        if (!createdGrid) return;
        if (!theGrid.value) return;
        if (!theGridLayout.value) return;

        theGrid.value?.addLayoutInstance(theGridLayout.value);
        createPropWatchers();
        unWatch.value?.();
      },
      { immediate: true }
    );
  }
});

onBeforeUnmount(() => {
  if (!theGrid.value) return;
  if (!theGridLayout.value) return;

  theGrid.value.removeLayoutInstance(theGridLayout.value);
});
</script>

<style scoped>
.placeholder {
  height: 100%;
  width: 100%;
  background-color: red;
  opacity: 0.2;
}
</style>

<template>
  <div v-if="currentBreakpoint === breakpoint">
    <div
      v-if="theGridLayout"
      :style="{ position: 'relative', height: height, width: width }"
    >
      <slot></slot>
      <GridLayoutItem
        :id="placeholderId"
        :draggable="false"
        :resizable="false"
        v-show="dragging || resizing"
        v-model:y="placeholderY"
        v-model:height="placeholderHeight"
        v-model:maxWidth="placeholderMaxWidth"
      >
        <slot name="placeholder">
          <div class="placeholder"></div>
        </slot>
      </GridLayoutItem>
    </div>
    <div v-if="debug">
      Layout Breakpoint: {{ breakpoint }} <br />
      Layout Number of Cols: {{ numberOfCols }} <br />
      placeholder: {{ JSON.stringify(placeholder) }} <br />
      Items: {{ JSON.stringify(itemsFromLayout) }} <br />
      Height: {{ height }} <br />
      Attrs: {{ $attrs }}
    </div>
  </div>
</template>
