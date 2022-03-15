<script setup lang="ts" name="FieldSelect">
import FieldLabel from './FieldLabel.vue';
import FieldError from './FieldError.vue';

interface Props {
  modelValue: string;
  name: string;
  label?: string;
  placeholder?: string;
  error?: string;
  disabled?: boolean;
  options?: string[];
}

const props = withDefaults(defineProps<Props>(), {
  label: '',
  placeholder: '',
  error: '',
  disabled: false,
  options: () => [],
});

const emit = defineEmits<{
  (event: 'update:modelValue', value: string): void;
}>();

const value = useVModel(props, 'modelValue', emit);
</script>
<template>
  <div>
    <FieldLabel :name="name" :label="label" />
    <select
      :id="name"
      :name="name"
      v-model="value"
      :disabled="disabled"
      class="mt-1 block w-full rounded-md border-slate-300 py-2 pl-3 pr-10 text-base focus:border-primary-500 focus:outline-none focus:ring-primary-500 sm:text-sm"
    >
      <option v-for="option in options" :key="option">
        {{ option }}
      </option>
    </select>
    <FieldError :error="error" />
  </div>
</template>
