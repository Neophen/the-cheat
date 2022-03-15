<script setup lang="ts" name="Notification">
import BaseButtonIcon from './BaseButtonIcon.vue';
import BaseIcon from './BaseIcon.vue';

interface Props {
  id: number;
  message: string;
  type: 'success' | 'error' | 'info';
}

const props = defineProps<Props>();

const emit = defineEmits<{
  (event: 'close'): void;
}>();

const close = () => {
  emit('close');
};

const closeItself = () => {
  setTimeout(() => {
    close();
  }, 3000);
};

onMounted(() => closeItself());

const icon = computed(() => {
  return props.type === 'success'
    ? 'notification-success'
    : 'notification-error';
});
</script>

<template>
  <div
    @click="close"
    class="relative w-[384px] cursor-pointer overflow-hidden rounded-l-lg bg-white p-6 shadow-lg"
  >
    <hr
      class="absolute inset-x-0 -top-1 h-2"
      :class="{
        'bg-green-500': props.type === 'success',
        'bg-red-500': props.type === 'error',
      }"
    />
    <div class="flex items-center">
      <BaseIcon
        :icon="icon"
        class="h-10 w-10"
        :class="{
          'text-green-500': props.type === 'success',
          'text-red-500': props.type === 'error',
        }"
      />
      <p class="ml-3 w-64 self-center text-left text-lg leading-snug">
        {{ message }}
      </p>
      <BaseButtonIcon icon="outline-x-circle" @click="close" />
    </div>
  </div>
</template>
