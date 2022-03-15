<script setup lang="ts" name="CheatSheetsIndex">
import Page from '~/components/Page.vue';
import BaseButton from '../components/BaseButton.vue';

type ISheet = {
  id: number;
  title: string;
  description: string;
  img?: string;
  options?: {
    languages: string[];
  };
  approved?: boolean;
  is_public?: boolean;
  user?: {
    id: number;
    name: string;
  };
};

interface Props {
  sheet: ISheet;
}

const props = defineProps<Props>();

const title = computed(() => {
  return `Cheat Sheet - ${props.sheet.title}`;
});

const editPath = computed((): string => {
  return `/cheat-sheets/${props.sheet.id}/edit`;
});
</script>
<template>
  <Page :title="title">
    <template #actions>
      <BaseButton href="/cheat-sheets">Back</BaseButton>
      <BaseButton :href="editPath">Edit</BaseButton>
    </template>
    <div>
      <h1></h1>
      <p>{{ sheet.description }}</p>
    </div>
  </Page>
</template>
