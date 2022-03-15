<script setup lang="ts" name="CardRowTitle">
interface Props {
  value?: string;
  isPrint?: boolean;
}

withDefaults(defineProps<Props>(), {
  value: '',
  isPrint: false,
});
</script>
<template>
  <pre
    class="font-sans font-bold text-primary-500 dark:text-primary-100 print:text-sm"
    :class="{
      'text-xl': !isPrint,
      'text-sm': isPrint,
    }"
    >{{ value }}</pre
  >
</template>
