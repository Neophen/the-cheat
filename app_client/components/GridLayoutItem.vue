<script lang="ts">
export default {
  inheritAttrs: false,
};
</script>

<script setup lang="ts" name="GridLayoutItem">
import type { WatchStopHandle } from 'vue';
import interact from 'interactjs';

import type { Item } from '~/types';

import { GridLayoutItem, GridLayout, injectGridLayout } from '~/composables';
import type { ResizeEvent } from '@interactjs/types';

// //Monitor the Props and update the item with the changed value
// const watchProp = (key, deep) => ({
//   handler(newValue) {
//     //If the prop did not cause the update there is no updating
//     if (item.value[key] === newValue) {
//       return;
//     }
//     item.value[key] = newValue;
//   },
//   deep,
// });

// //Props to change via interaction and need to be emitted for prop.sync usage
// const EMIT_PROPS = ['x', 'y', 'width', 'height'];
// //Monitor the item and emit an update to allow .sync usage
// const watchEmitProp = (key, deep) => ({
//   handler(newValue) {
//     //If the prop caused the update there is no point emitting it back
//     if (props[key] === newValue) {
//       return;
//     }
//     emit('update:' + key, newValue);
//   },
//   deep,
// });

//   locked: { type: Boolean, default: GridLayoutItem.defaults.locked },
// },

interface Props {
  id: string | number;
  x?: number;
  y?: number;
  width?: number;
  height?: number;
  minWidth?: number | boolean;
  maxWidth?: number | boolean;
  minHeight?: number | boolean;
  maxHeight?: number | boolean;
  draggable?: boolean;
  resizable?: boolean;
  locked?: boolean;
  resizeEdges?: string;
  resizeHandleSize?: number;
  moveHold?: number;
  resizeHold?: number;
  dragAllowFrom?: string;
  dragIgnoreFrom?: string;
}

const props = withDefaults(defineProps<Props>(), {
  x: GridLayoutItem.defaults.x,
  y: GridLayoutItem.defaults.y,
  width: GridLayoutItem.defaults.width,
  height: GridLayoutItem.defaults.height,
  minWidth: GridLayoutItem.defaults.minWidth,
  maxWidth: GridLayoutItem.defaults.maxWidth,
  minHeight: GridLayoutItem.defaults.minHeight,
  maxHeight: GridLayoutItem.defaults.maxHeight,
  draggable: GridLayoutItem.defaults.draggable,
  resizable: GridLayoutItem.defaults.resizable,
  locked: GridLayoutItem.defaults.locked,
  resizeEdges: 'bottom right',
  resizeHandleSize: 8,
  moveHold: 0,
  resizeHold: 0,
  dragAllowFrom: '',
  dragIgnoreFrom: '',
});

const emit = defineEmits<{
  (event: 'update', item: Item): void;
  (event: 'moveStart', item: Item): void;
  (event: 'moving', item: Item): void;
  (event: 'moveEnd', item: Item): void;
  (event: 'resizeStart', item: Item): void;
  (event: 'resizing', item: Item): void;
  (event: 'resizeEnd', item: Item): void;
  (event: 'hoverStart', item: Item): void;
  (event: 'hoverEnd', item: Item): void;
}>();

const layout = injectGridLayout();
const interactInstance = ref<typeof interact>();
const interactInstanceRef = ref<HTMLDivElement>();
const item = ref<GridLayoutItem>();
const dragging = ref(false);
const resizing = ref(false);
const hover = ref(false);
const unWatch = ref<WatchStopHandle>();

const resizingOrDragging = computed(() => {
  return (resizing.value || dragging.value) && !props.locked;
});
const useCssTransforms = computed(() => {
  return layout.value?.useCssTransforms || GridLayout.defaults.useCssTransforms;
});

const classObj = computed(() => {
  return {
    dragging: resizingOrDragging.value,
    cssTransforms: useCssTransforms,
  };
});

const left = computed(() => {
  return item.value?.left || 0;
});
const top = computed(() => {
  return item.value?.top || 0;
});
const widthPx = computed(() => {
  return item.value?.widthPx || 0;
});
const heightPx = computed(() => {
  return item.value?.heightPx || 0;
});

const cssStyle = computed(() => {
  if (useCssTransforms.value) {
    return GridLayoutItem.cssTransform(
      top.value,
      left.value,
      widthPx.value,
      heightPx.value
    );
  } else {
    return GridLayoutItem.cssTopLeft(
      top.value,
      left.value,
      widthPx.value,
      heightPx.value
    );
  }
});

const resizeTop = computed(() => {
  return !props.locked && props.resizable && props.resizeEdges.includes('top');
});

const resizeBottom = computed(() => {
  return (
    !props.locked && props.resizable && props.resizeEdges.includes('bottom')
  );
});

const resizeLeft = computed(() => {
  return !props.locked && props.resizable && props.resizeEdges.includes('left');
});

const resizeRight = computed(() => {
  return (
    !props.locked && props.resizable && props.resizeEdges.includes('right')
  );
});

const resizeTopLeft = computed(() => {
  return !props.locked && resizeTop.value && resizeLeft.value;
});

const resizeBottomLeft = computed(() => {
  return !props.locked && resizeBottom.value && resizeLeft.value;
});

const resizeTopRight = computed(() => {
  return !props.locked && resizeTop.value && resizeRight.value;
});

const resizeBottomRight = computed(() => {
  return !props.locked && resizeBottom.value && resizeRight.value;
});

const setDraggable = () => {
  if (props.draggable && !props.locked) {
    //@ts-ignore
    interactInstance.value?.draggable({
      enabled: true,
      hold: props.moveHold,
      allowFrom: props.dragAllowFrom,
      ignoreFrom: props.dragIgnoreFrom,
      listeners: {
        start: onMoveStart,
        move: onMove,
        end: onMoveEnd,
      },
    });
  } else {
    //@ts-ignore
    interactInstance.value?.draggable(false);
  }
};

const setResizable = () => {
  if (props.resizable && !props.locked) {
    //@ts-ignore
    interactInstance.value?.resizable({
      enabled: true,
      hold: props.resizeHold,
      edges: {
        top: '.resize-top',
        left: '.resize-left',
        bottom: '.resize-bottom',
        right: '.resize-right',
      },
      listeners: {
        start: onResizeStart,
        move: onResize,
        end: onResizeEnd,
      },
    });
  } else {
    //@ts-ignore
    interactInstance.value?.resizable(false);
  }
};

const onMoveStart = () => {
  dragging.value = true;
  if (!item.value) return;

  item.value._onMoveStart();
  emit('moveStart', { ...item.value.toItem() });
};

const onMove = (e: { dx: number; dy: number }) => {
  if (!dragging.value) return;
  if (!item.value) return;

  item.value._onMove(e.dx, e.dy);
  emit('moving', { ...item.value.toItem() });
};

const onMoveEnd = () => {
  if (!item.value) return;
  item.value._onMoveEnd();
  dragging.value = false;
  emit('moveEnd', { ...item.value.toItem() });
};

const onResizeStart = () => {
  if (!item.value) return;
  resizing.value = true;
  item.value._onResizeStart();
  emit('resizeStart', { ...item.value.toItem() });
};

const onResize = (e: ResizeEvent) => {
  if (!resizing.value) return;
  if (!item.value) return;

  item.value._onResize(e);
  emit('resizing', { ...item.value.toItem() });
};

const onResizeEnd = () => {
  if (!item.value) return;

  item.value._onResizeEnd();
  resizing.value = false;
  emit('resizeEnd', { ...item.value.toItem() });
};

// const createPropWatchers = () => {
//   //Setup prop watches to sync with the Dash Item
//   Object.keys(props).forEach((key) => {
//     watch(key, watchProp(key, true));
//   });
// };

// const createDashItemWatchers = () => {
//   //Setup Watchers for emmit sync option
//   EMIT_PROPS.forEach((prop) => {
//     watch('item.' + prop, watchEmitProp(prop, true));
//   });
// };

// hover(newValue) {
//   item.value.hover = newValue;
//   if (newValue) {
//     emit('hoverStart', item.value);
//   } else {
//     emit('hoverEnd', item.value);
//   }
// },
// draggable() {
//   this.setDraggable();
// },
// resizable() {
//   this.setResizable();
// },
// locked() {
//   this.setDraggable();
//   this.setResizable();
// },
// moveHold() {
//   this.setDraggable();
// },
// resizeHold() {
//   this.setResizable();
// },
// dragAllowFrom() {
//   this.setDraggable();
// },
// dragIgnoreFrom() {
//   this.setDraggable();
// }

// eslint-disable-next-line @typescript-eslint/no-empty-function
const createPropWatchers = () => {};
// eslint-disable-next-line @typescript-eslint/no-empty-function
const createDashItemWatchers = () => {};

onMounted(() => {
  item.value = new GridLayoutItem(props);
  if (!interactInstanceRef.value) return;

  //@ts-ignore
  interactInstance.value = interact(interactInstanceRef.value);
  setDraggable();
  setResizable();

  //Check if layout exists and if not then start a watcher
  if (layout.value) {
    layout.value.addDashItem(item.value);
    createPropWatchers();
    createDashItemWatchers();
  } else {
    unWatch.value = watch(
      () => layout.value,
      () => {
        if (!layout.value) return;
        if (!item.value) return;

        layout.value.addDashItem(item.value);
        createPropWatchers();
        createDashItemWatchers();
        unWatch.value?.();
      },
      { immediate: true }
    );
  }
});

onBeforeUnmount(() => {
  if (interactInstance.value) {
    //@ts-ignore
    interactInstance.value.unset();
  }

  if (!layout.value) return;
  if (!item.value) return;

  layout.value.removeDashItem(item.value);
});
</script>

<style scoped>
.item {
  box-sizing: border-box;
  position: absolute;
  display: inline-block;
  transition: all 200ms ease;
  transition-property: left, top, right;
  touch-action: none;
  user-select: none;
}
.item.dragging {
  transition: none;
  z-index: 3;
}

.resize {
  touch-action: none;
  user-select: none;
}

.item.cssTransforms {
  transition-property: transform;
  left: 0;
  right: auto;
}
</style>

<template>
  <div
    :id="'item_' + id"
    ref="interactInstanceRef"
    class="item"
    :style="cssStyle"
    :class="classObj"
    @mouseover="hover = true"
    @mouseleave="hover = false"
  >
    <!-- Resize Top Div -->
    <div
      :id="id + '-resizeTop'"
      :ref="id + '-resizeTop'"
      class="resize-top resize"
      :style="{
        height: resizeHandleSize + 'px',
        top: -(resizeHandleSize / 2) + 'px',
        left: 0,
        right: 0,
        cursor: 'ns-resize',
        position: 'absolute',
        zIndex: 1,
      }"
      v-if="resizeTop"
    >
      <slot name="resizeTop"></slot>
    </div>
    <!-- Resize Bottom Div -->
    <div
      :id="id + '-resizeBottom'"
      :ref="id + '-resizeBottom'"
      class="resize-bottom resize"
      :style="{
        height: resizeHandleSize + 'px',
        left: 0 + 'px',
        right: 0 + 'px',
        bottom: -(resizeHandleSize / 2) + 'px',
        cursor: 'ns-resize',
        position: 'absolute',
        zIndex: 1,
      }"
      v-if="resizeBottom"
    >
      <slot name="resizeBottom"></slot>
    </div>
    <!-- Resize Left Div -->
    <div
      :id="id + '-resizeLeft'"
      :ref="id + '-resizeLeft'"
      class="resize-left resize"
      :style="{
        width: resizeHandleSize + 'px',
        top: 0 + 'px',
        bottom: 0 + 'px',
        left: -(resizeHandleSize / 2) + 'px',
        cursor: 'ew-resize',
        position: 'absolute',
        zIndex: 1,
      }"
      v-if="resizeLeft"
    >
      <slot name="resizeLeft"></slot>
    </div>
    <!-- Resize Right Div -->
    <div
      :id="id + '-resizeRight'"
      :ref="id + '-resizeRight'"
      class="resize-right resize"
      :style="{
        width: resizeHandleSize + 'px',
        top: 0 + 'px',
        bottom: 0 + 'px',
        right: -(resizeHandleSize / 2) + 'px',
        cursor: 'ew-resize',
        position: 'absolute',
        zIndex: 1,
      }"
      v-if="resizeRight"
    >
      <slot name="resizeRight"></slot>
    </div>
    <!-- Resize Top Left Div -->
    <div
      :id="id + '-resizeTopLeft'"
      :ref="id + '-resizeTopLeft'"
      class="resize-left resize-top resize"
      :style="{
        width: resizeHandleSize * 2 + 'px',
        height: resizeHandleSize * 2 + 'px',
        top: -resizeHandleSize + 'px',
        left: -resizeHandleSize + 'px',
        cursor: 'nw-resize',
        position: 'absolute',
        zIndex: 1,
      }"
      v-if="resizeTopLeft"
    >
      <slot name="resizeTopLeft"></slot>
    </div>
    <!-- Top Right Resize Div -->
    <div
      :id="id + '-resizeTopRight'"
      :ref="id + '-resizeTopRight'"
      class="resize-right resize-top resize"
      :style="{
        width: resizeHandleSize * 2 + 'px',
        height: resizeHandleSize * 2 + 'px',
        top: -resizeHandleSize + 'px',
        right: -resizeHandleSize + 'px',
        cursor: 'ne-resize',
        position: 'absolute',
        zIndex: 1,
      }"
      v-if="resizeTopRight"
    >
      <slot name="resizeTopRight"></slot>
    </div>
    <!-- Bottom Left Resize Div -->
    <div
      :id="id + '-resizeBottomLeft'"
      :ref="id + '-resizeBottomLeft'"
      class="resize-left resize-bottom resize"
      :style="{
        width: resizeHandleSize * 2 + 'px',
        height: resizeHandleSize * 2 + 'px',
        bottom: -resizeHandleSize + 'px',
        left: -resizeHandleSize + 'px',
        cursor: 'ne-resize',
        position: 'absolute',
        zIndex: 1,
      }"
      v-if="resizeBottomLeft"
    >
      <slot name="resizeBottomLeft"></slot>
    </div>
    <!-- Bottom Right Resize Div -->
    <div
      :id="id + '-resizeBottomRight'"
      :ref="id + '-resizeBottomRight'"
      class="resize-right resize-bottom resize"
      :style="{
        width: resizeHandleSize * 2 + 'px',
        height: resizeHandleSize * 2 + 'px',
        bottom: -resizeHandleSize + 'px',
        right: -resizeHandleSize + 'px',
        cursor: 'nw-resize',
        position: 'absolute',
        zIndex: 1,
      }"
      v-if="resizeBottomRight"
    >
      <slot name="resizeBottomRight"></slot>
    </div>
    <slot></slot>
  </div>
</template>
