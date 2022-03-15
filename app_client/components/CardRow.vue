<script setup lang="ts" name="CardRow">
import type { ICardRowType } from '~/types';
import { useStore } from '~/stores';

import CardRowCode from './CardRowCode.vue';
import CardRowComment from './CardRowComment.vue';
import CardRowMarkdown from './CardRowMarkdown.vue';
import CardRowTable from './CardRowTable.vue';
import CardRowTitle from './CardRowTitle.vue';

const store = useStore();

interface Props {
  type: ICardRowType;
  language?: string;
  value?: string;
}

const props = withDefaults(defineProps<Props>(), {
  language: '',
  value: '',
});

const isPrint = computed(
  () => store.preview === 'portrait' || store.preview === 'landscape'
);

const TYPE_TO_COMPONENT = {
  code: CardRowCode,
  comment: CardRowComment,
  markdown: CardRowMarkdown,
  table: CardRowTable,
  title: CardRowTitle,
};

const component = computed(() => {
  return TYPE_TO_COMPONENT[props.type] || CardRowMarkdown;
});
</script>
<template>
  <component
    :is="component"
    :type="type"
    :language="language"
    :value="value"
    :isPrint="isPrint"
  />
</template>
