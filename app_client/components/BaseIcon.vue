<script setup lang="ts" name="Icon">
import type { Icons } from '~/types';

import iconUrl from '~/assets/icons.svg';
// const iconUrl = '/icons.svg';

interface Props {
  icon: Icons;
}

const props = defineProps<Props>();

const iconPath = computed(() => `${iconUrl}#${props.icon}`);
</script>

<template>
  <svg class="inline-block shrink-0 fill-current stroke-current">
    <use :href="iconPath" :xlink:href="iconPath" />
  </svg>
</template>
