<script setup lang="ts">
import { useStore } from '~/stores';
import type { Preview } from '~/types';

defineEmits(['toggleSidebar']);
const store = useStore();

// const preferedDark = usePreferredDark();
const isDark = useStorage('isDark', false);
const previewType = useStorage<Preview>('previewType', 'web');
const body = ref<HTMLBodyElement | null>(null);

const toggleDarkMode = () => {
  if (body.value) {
    if (isDark.value) {
      body.value.classList.remove('dark');
    } else {
      body.value.classList.add('dark');
    }
  }
  isDark.value = !isDark.value;
};

const setView = (type: Preview) => {
  previewType.value = type;
};

watch(
  () => previewType.value,
  () => {
    store.preview = previewType.value;
  },
  {
    immediate: true,
  }
);

onMounted(async () => {
  await nextTick();

  body.value = document.querySelector('body') as HTMLBodyElement;
  if (!body.value) {
    return;
  }

  if (isDark.value) {
    body.value.classList.add('dark');
  }
});
</script>

<template>
  <header>
    <nav
      class="flex w-full items-center border-b border-slate-400/50 bg-white py-4 px-8 text-slate-800 shadow-md dark:bg-slate-800 dark:text-white dark:shadow-md"
    >
      <router-link :to="{ name: 'cheat-sheets' }">
        <div class="text-md font-bold md:text-lg lg:text-xl">The Cheats</div>
      </router-link>
      <div class="ml-auto flex h-full items-center space-x-4">
        <p class="text-sm capitalize text-slate-500">
          {{ store.preview }}
        </p>
        '
        <BaseButtonIcon icon="fa-solid:desktop" @click="setView('web')" />
        <BaseButtonIcon
          icon="ic:outline-crop-portrait"
          @click="setView('portrait')"
        />
        <BaseButtonIcon
          icon="ic:baseline-crop-landscape"
          @click="setView('landscape')"
        />
        <button
          class="cursor-pointer focus:outline-none"
          @click="toggleDarkMode"
        >
          <BaseIcon icon="bx:bxs-moon" class="h-6 w-6" v-if="!isDark" />
          <BaseIcon icon="bx:bx-sun" class="h-6 w-6" v-else />
        </button>
      </div>
    </nav>
  </header>
</template>
