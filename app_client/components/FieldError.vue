<script setup lang="ts" name="FieldError">
interface Props {
  error?: string;
}

withDefaults(defineProps<Props>(), {
  error: '',
});
</script>
<template>
  <p v-if="error" class="mt-2 text-sm text-red-500">
    {{ error }}
  </p>
</template>
