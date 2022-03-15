<script setup lang="ts" name="CheatSheetsIndex">
import Page from '~/components/Page.vue';
import BaseButton from '../components/BaseButton.vue';

import type { ISheet } from '~/types';
import CheatSheetCard from '../components/CheatSheetCard.vue';
import BaseCard from '../components/BaseCard.vue';

interface Props {
  sheets: ISheet[];
}

defineProps<Props>();
</script>
<template>
  <Page title="Cheat Sheets">
    <template #aside>
      <div class="sticky top-4 w-full max-w-[200px] space-y-4">
        <BaseCard padded sticky>
          <BaseButton href="/cheat-sheets/create"> Create Sheet </BaseButton>
        </BaseCard>
      </div>
    </template>
    <div>
      <ul
        role="list"
        class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4"
      >
        <li v-for="sheet in sheets" :key="sheet.id">
          <CheatSheetCard :sheet="sheet" />
        </li>
      </ul>
    </div>
  </Page>
</template>
