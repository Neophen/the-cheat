<script setup lang="ts" name="CardRowInput">
import type { ICardRow, Tab } from '~/types';

import BaseButtonIcon from './BaseButtonIcon.vue';
import CardRowInputTable from './CardRowInputTable.vue';

const props = defineProps<{
  modelValue: ICardRow;
}>();

const emit = defineEmits<{
  (event: 'update:modelValue', payload: ICardRow): void;
  (event: 'up'): void;
  (event: 'down'): void;
  (event: 'remove'): void;
}>();

const row = useVModel(props, 'modelValue', emit);

const typeOptions: Tab[] = [
  {
    name: 'Title',
    value: 'title',
  },
  {
    name: 'Markdown',
    value: 'markdown',
  },
  {
    name: 'Code',
    value: 'code',
  },
  {
    name: 'Comment',
    value: 'comment',
  },
  {
    name: 'Table',
    value: 'table',
  },
];

const type = ref<Tab>(
  typeOptions.find((x) => x.value === row.value.type) || typeOptions[0]
);

const rowValue = ref(row.value.value || '');
const language = ref('');

watch(
  () => [type.value, rowValue.value, language.value],
  () => {
    row.value = {
      id: row.value.id,
      type: type.value.value,
      value: rowValue.value,
      language: language.value,
    };
  }
);

const typeToField = {
  code: 'textarea',
  comment: 'text',
  markdown: 'textarea',
  table: 'table',
  title: 'text',
};

const fieldType = computed(() => {
  return typeToField[type.value.value];
});
</script>
<template>
  <div class="space-y-4 rounded-md bg-white p-4 shadow-sm">
    <div class="flex items-center">
      <Tabs v-model="type" :tabs="typeOptions" name="type" />
      <div class="ml-auto shrink-0 space-x-2">
        <BaseButtonIcon icon="trash" @click="emit('remove')" color="danger" />
        <BaseButtonIcon icon="chevron-up" @click="emit('up')" />
        <BaseButtonIcon icon="chevron-down" @click="emit('down')" />
      </div>
    </div>
    <FieldText
      v-if="type.value === 'code'"
      v-model="language"
      name="language"
      label="Language"
    />
    <FieldTextarea
      v-if="fieldType === 'textarea'"
      v-model="rowValue"
      name="value"
      label="Value"
      placeholder="Enter value..."
    />
    <FieldText
      v-else-if="fieldType === 'text'"
      v-model="rowValue"
      name="value"
      label="Value"
      placeholder="Enter value..."
    />
    <CardRowInputTable v-else-if="fieldType === 'table'" v-model="rowValue" />
  </div>
</template>
