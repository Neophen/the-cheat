import { createApp, h } from 'vue';
import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { provideNotifications } from './composables/notify';

import DefaultLayout from './layouts/default.vue';

import './assets/app.css';

createInertiaApp({
  resolve: async (name) => {
    const { default: page } = await import(`./pages/${name}.vue`);

    page.layout ??= DefaultLayout;

    return page;
  },
  setup({ el, app, props, plugin }) {
    createApp({
      setup: () => {
        provideNotifications();
      },
      render: () => h(app, props),
    })
      .use(plugin)
      .component('Link', Link)
      .component('Head', Head)
      .mount(el);
  },
  title: (title) => {
    return title ? `The Cheat: ${title}` : 'The Cheat';
  },
});

InertiaProgress.init({
  delay: 200,
});
