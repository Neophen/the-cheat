<script setup lang="ts" name="Tabs">
import type { Tab } from '~/types';

const props = defineProps<{
  modelValue: Tab;
  name: string;
  tabs: Tab[];
}>();

const emit = defineEmits<{
  (event: 'update:modelValue', value: Tab): void;
}>();

const value = useVModel(props, 'modelValue', emit);

const select = (tab: Tab) => {
  value.value = tab;
};

const current = computed(() => (tab: Tab) => {
  return value.value.value === tab.value;
});
</script>

<template>
  <div>
    <div class="sm:hidden">
      <label :for="name" class="sr-only">Select a tab</label>

      <select
        v-model="value"
        :id="name"
        :name="name"
        class="block w-full rounded-md border-slate-300 focus:border-primary-500 focus:ring-primary-500"
      >
        <option v-for="tab in tabs" :key="tab.name" :selected="current(tab)">
          {{ tab.name }}
        </option>
      </select>
    </div>
    <div class="hidden sm:block">
      <nav class="flex space-x-2" aria-label="Tabs">
        <button
          v-for="tab in tabs"
          :key="tab.name"
          :class="[
            current(tab)
              ? 'bg-primary-100 text-primary-700'
              : 'text-slate-500 hover:text-slate-700',
            'rounded-md px-3 py-2 text-sm font-medium',
          ]"
          :aria-current="current(tab) ? 'page' : undefined"
          @click="select(tab)"
        >
          <span>{{ tab.name }}</span>
        </button>
      </nav>
    </div>
  </div>
</template>
