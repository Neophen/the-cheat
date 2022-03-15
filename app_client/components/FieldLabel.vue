<script setup lang="ts" name="FieldLabel">
interface Props {
  name: string;
  label?: string;
}

withDefaults(defineProps<Props>(), {
  label: '',
});
</script>
<template>
  <label
    :for="name"
    class="block text-sm font-medium capitalize text-slate-700"
  >
    {{ label || name }}
  </label>
</template>
