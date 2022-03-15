<script setup lang="ts" name="CardRowMarkdown">
import MarkdownIt from 'markdown-it';
interface Props {
  value?: string;
  isPrint?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
  value: '',
  isPrint: false,
});

const md = new MarkdownIt();

const table = computed(() => md.render(props.value));
</script>
<template>
  <div class="min-w-max">
    <div
      v-html="table"
      class="prose prose-slate dark:prose-invert print:prose-sm"
      :class="{
        'prose-xl': !isPrint,
        'prose-sm': isPrint,
      }"
    ></div>
  </div>
</template>
