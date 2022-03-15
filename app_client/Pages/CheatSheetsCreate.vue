<script setup lang="ts" name="CheatSheetsIndex">
import { useForm } from '@inertiajs/inertia-vue3';

import Page from '~/components/Page.vue';
import FieldText from '../components/FieldText.vue';
import FieldTextarea from '../components/FieldTextarea.vue';
import FieldTags from '../components/FieldTags.vue';
import BaseButton from '../components/BaseButton.vue';
import BaseButtonIcon from '../components/BaseButtonIcon.vue';

import type { ISheet } from '~/types';
import BaseCard from '../components/BaseCard.vue';

const form = useForm<ISheet>({
  id: 0,
  title: '',
  description: '',
  img: '',
  views: 0,
  upVotes: 0,
  downVotes: 0,
  likes: 0,
  tags: [],
  keywords: [],
  theme: 'default',
});

const submit = () => {
  console.log(form.data());
  // form.post('/cheat-sheets', {
  //   preserveScroll: true,
  //   onSuccess: () => form.reset(),
  // });
};

const setView = (type: string) => {};
</script>
<template>
  <Page title="Create new">
    <template #aside>
      <div class="sticky top-4 w-full max-w-[200px] space-y-4">
        <BaseCard padded class="flex items-center space-x-2">
          <BaseButton full href="/cheat-sheets" color="danger">
            Cancel
          </BaseButton>
          <BaseButton full @click="submit" color="primary">Save</BaseButton>
        </BaseCard>
        <BaseCard padded class="space-y-4">
          <FieldText
            name="title"
            v-model="form.title"
            :error="form.errors.title"
          />
          <FieldTextarea
            name="description"
            v-model="form.description"
            :error="form.errors.description"
          />
          <FieldTags
            name="tags"
            v-model="form.tags"
            :error="form.errors.tags"
          />
          <FieldTags
            name="keywords"
            v-model="form.keywords"
            :error="form.errors.keywords"
          />
        </BaseCard>
      </div>
    </template>
    <div class="w-full">
      <BaseCard sticky class="flex w-full bg-white p-2 shadow">
        <BaseButton href="/cheat-sheet-cards/create">Add Card</BaseButton>
        <BaseButtonIcon
          class="ml-auto"
          icon="fa-solid:desktop"
          @click="setView('web')"
        />
        <BaseButtonIcon
          icon="ic:outline-crop-portrait"
          @click="setView('portrait')"
        />
        <BaseButtonIcon
          icon="ic:baseline-crop-landscape"
          @click="setView('landscape')"
        />
      </BaseCard>

      <BaseCard class="h-screen"></BaseCard>
      <BaseCard class="h-screen"></BaseCard>
    </div>
  </Page>
</template>
