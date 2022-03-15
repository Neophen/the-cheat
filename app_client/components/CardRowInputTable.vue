<script setup lang="ts" name="CardRowInputTable">
import FieldTextarea from './FieldTextarea.vue';
const props = defineProps<{
  modelValue: string;
}>();

const emit = defineEmits<{
  (event: 'update:modelValue', payload: string): void;
}>();

const value = useVModel(props, 'modelValue', emit);
</script>
<template>
  <div>
    <a
      href="https://www.tablesgenerator.com/markdown_tables"
      target="__blank"
      class="text-slate-500 dark:text-slate-100 underline hover:text-primary-500 dark:hover:text-primary-100"
      >Check out this link to generate a Markdown Table</a
    >
    <FieldTextarea v-model="value" name="table" label="Table" />
    <p class="text-slate-400 mt-2 text-sm">
      While technically this is a markdown editor, in the later stage this will
      become a proper table editor. I'll try to make it backwards compatible and
      convert existing tables to the new format
    </p>
  </div>
</template>
