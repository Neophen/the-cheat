<script setup lang="ts" name="CardRowCode">
import Highlight from './Highlight.vue';

interface Props {
  language?: string;
  value?: string;
  isPrint?: boolean;
}

withDefaults(defineProps<Props>(), {
  language: '',
  value: '',
  isPrint: false,
});
</script>
<template>
  <div
    class="overflow-hidden rounded-md print:text-xs"
    :class="{
      '': !isPrint,
      'text-xs': isPrint,
    }"
  >
    <Highlight :language="language" :code="value || ''" :autodetect="false" />
  </div>
</template>
