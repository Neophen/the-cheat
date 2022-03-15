import type { ConfigEnv } from 'vite';
import { URL, fileURLToPath } from 'url';

import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import AutoImport from 'unplugin-auto-import/vite';
import inertia from './resources/scripts/inertia';

export default defineConfig(({ command }: ConfigEnv) => {
  return {
    resolve: {
      alias: {
        '~': fileURLToPath(new URL('./app_client', import.meta.url)),
      },
    },
    base: command === 'build' ? '/build/' : '',
    publicDir: command === 'build' ? 'public/vite' : 'public',
    build: {
      manifest: true,
      minify: true,
      outDir: 'public/build',
      rollupOptions: {
        input: {
          app: 'app_client/app.ts',
        },
      },
    },
    server: {
      strictPort: true,
      port: 3030,
      // https: true,
      fs: {
        strict: true,
      },
      hmr: {
        host: 'localhost',
      },
    },
    plugins: [
      inertia(),
      vue(),

      AutoImport({
        dts: 'app_client/auto-imports.d.ts',
        include: [
          /\.[tj]s$/, // .ts, .js
          /\.vue\??/, // .vue
        ],
        imports: ['vue', '@vueuse/head', '@vueuse/core'],
        resolvers: [],
      }),
    ],
    optimizeDeps: {
      include: [
        '@inertiajs/inertia',
        '@inertiajs/inertia-vue3',
        'axios',
        'vue',
      ],
    },
  };
});
