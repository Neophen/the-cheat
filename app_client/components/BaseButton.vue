<script setup lang="ts" name="BaseButton">
interface Props {
  color?: 'default' | 'primary' | 'danger';
  full?: boolean;
  disabled?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  color: 'default',
  full: false,
  disabled: false,
});

const $attrs = useAttrs();

const tag = computed(() => {
  if (props.disabled) {
    return 'button';
  }

  if ($attrs.href) {
    return 'Link';
  }

  return 'button';
});
</script>
<template>
  <component
    :is="tag"
    type="button"
    class="border-transparent flex items-center justify-center rounded-md border px-3 py-2 text-sm font-medium leading-4 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2"
    :class="{
      'bg-white text-primary-600 hover:bg-primary-100 focus:ring-primary-500':
        color === 'default',
      'bg-primary-600 text-white hover:bg-primary-700 focus:ring-primary-500':
        color === 'primary',
      'bg-white text-red-500 hover:bg-red-100 focus:ring-red-500':
        color === 'danger',
      'w-full': full,
    }"
  >
    <slot></slot>
  </component>
</template>
