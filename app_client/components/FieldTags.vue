<script setup lang="ts" name="FieldTags">
import FieldLabel from './FieldLabel.vue';
import FieldError from './FieldError.vue';

interface Props {
  modelValue: string[];
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
  (event: 'update:modelValue', value: number): void;
}>();

const tags = useVModel(props, 'modelValue', emit);
const tag = ref('');

const pushTag = () => {
  const value = tag.value.trim();
  if (!value) {
    return;
  }
  tags.value.push(value);
  tag.value = '';
};

const addTag = (event: KeyboardEvent) => {
  if (event.code === 'Tab') {
    pushTag();
  }

  if (event.code === 'Comma' || event.code === 'Enter') {
    event.preventDefault();
    pushTag();
  }

  if (event.code === 'Backspace' && !tag.value) {
    event.preventDefault();
    tags.value.pop();
  }
};
</script>
<template>
  <div>
    <FieldLabel :name="name" :label="label" />
    <div class="mt-2">
      <div
        class="-m-1 flex w-full flex-wrap rounded-md border border-slate-300 p-1 shadow-sm focus:border-primary-500 focus:ring-primary-500 sm:text-sm"
      >
        <div v-for="tag in tags" :key="tag" class="m-1 truncate">
          <div
            class="truncate rounded bg-slate-600 p-1 leading-none text-white"
          >
            {{ tag }}
          </div>
        </div>
        <div class="m-1 min-w-[40px] flex-1">
          <input
            type="text"
            v-model="tag"
            class="w-full border-none px-1 py-0 leading-none focus:ring-0"
            @keydown="addTag"
            placeholder="Enter tag..."
          />
        </div>
      </div>
    </div>
    <FieldError :error="error" />
  </div>
</template>
