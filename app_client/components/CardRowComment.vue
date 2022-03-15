<script setup lang="ts" name="CardRowComment">
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
    class="text-slate-500 dark:text-slate-100 font-sans print:text-xs"
    :class="{
      '': !isPrint,
      'text-xs': isPrint,
    }"
    >{{ value }}</pre
  >
</template>
