<script setup lang="ts" name="CheatSheetCard">
import type { ISheet } from '~/types';
import BaseIcon from './BaseIcon.vue';

interface Props {
  sheet: ISheet;
}

const props = defineProps<Props>();

const showPath = computed(() => `/cheat-sheets/${props.sheet.id}`);
</script>
<template>
  <Link
    :href="showPath"
    class="group flex flex-col rounded-lg bg-white shadow hover:shadow-primary-300"
  >
    <div class="flex flex-1 flex-col">
      <div
        class="relative h-32 w-full flex-shrink-0 overflow-hidden rounded-t-lg"
      >
        <img
          class="h-32 w-full object-cover"
          :src="sheet.img || '/img/default-sheet-preview.png'"
          alt=""
        />

        <div
          class="absolute right-0 top-0 m-2 flex opacity-25 group-hover:opacity-100"
        >
          <div class="-m-1 flex flex-wrap">
            <div class="m-1">
              <button
                class="rounded bg-primary-500 p-1 text-xs leading-none text-white"
                type="button"
              >
                Vue
              </button>
            </div>
            <div class="m-1">
              <button
                class="rounded bg-primary-500 p-1 text-xs leading-none text-white"
                type="button"
              >
                Javascript
              </button>
            </div>
            <div class="m-1">
              <button
                class="rounded bg-primary-500 p-1 text-xs leading-none text-white"
                type="button"
              >
                Web
              </button>
            </div>
          </div>
        </div>
      </div>
      <div class="space-y-2 p-4">
        <h2
          class="truncate text-xl font-medium group-hover:text-primary-500 group-hover:underline"
        >
          {{ sheet.title }}
        </h2>

        <div
          class="group-hover:text-slate-60 flex text-slate-400 group-hover:text-slate-700"
        >
          <div class="flex items-center space-x-1">
            <BaseIcon icon="eye" class="h-4 w-4 flex-shrink-0" />
            <p class="text-xs">112k</p>
          </div>
          <div class="ml-auto mr-2 flex items-center space-x-1">
            <BaseIcon icon="thumb-up" class="h-4 w-4 flex-shrink-0" />
            <p class="text-xs">420k</p>
          </div>
          <div class="flex items-center space-x-1">
            <BaseIcon icon="thumb-down" class="h-4 w-4 flex-shrink-0" />
            <p class="text-xs">100k</p>
          </div>
        </div>

        <div class="mt-1 flex flex-grow flex-col justify-between">
          <p class="text-slate-600 line-clamp-3">
            {{ sheet.description }}
          </p>
        </div>
        <p class="truncate text-xs text-slate-400">
          Vue, Regex, Typescript, Composition Api, Vuex, Vue Router, Vuex
        </p>
      </div>
    </div>
  </Link>
</template>
