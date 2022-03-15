<script setup lang="ts" name="BaseCard">
interface Props {
  sticky?: boolean;
  padded?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  sticky: false,
  padded: false,
});
</script>
<template>
  <div
    class="flex-shrink-0 rounded-md bg-white shadow"
    :class="{
      'sticky top-4': sticky,
      'p-4': padded,
    }"
  >
    <slot />
  </div>
</template>
