<script setup lang="ts" name="FieldTextarea">
import FieldLabel from './FieldLabel.vue';
import FieldError from './FieldError.vue';

interface Props {
  modelValue: string;
  name: string;
  label?: string;
  placeholder?: string;
  error?: string;
  disabled?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  label: '',
  placeholder: '',
  error: '',
  disabled: false,
});

const emit = defineEmits<{
  (event: 'update:modelValue', value: string): void;
}>();

const value = useVModel(props, 'modelValue', emit);
</script>
<template>
  <div>
    <FieldLabel :name="name" :label="label" />
    <div class="mt-1">
      <textarea
        rows="4"
        :name="name"
        :id="name"
        v-model="value"
        :placeholder="placeholder"
        :disabled="disabled"
        class="block w-full rounded-md border-slate-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
      ></textarea>
    </div>
    <FieldError :error="error" />
  </div>
</template>
