<script setup lang="ts" name="LandingPageAboveFold">
import { useForm } from '@inertiajs/inertia-vue3';

const form = useForm({
  email: '',
});

const submit = () => {
  form.post('/notify-me', {
    preserveScroll: true,
    onSuccess: () => form.reset(),
  });
};
</script>

<template>
  <div class="overflow-hidden pt-8 sm:pt-12 lg:relative lg:py-48">
    <div
      class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:grid lg:max-w-7xl lg:grid-cols-2 lg:gap-24 lg:px-8"
    >
      <div>
        <div class="mt-4">
          <div class="sm:max-w-xl">
            <h1
              class="font-display text-3xl font-extrabold tracking-tight text-slate-900 sm:text-5xl"
            >
              Simple way to
              <img src="/img/hero_title.png" alt="" class="inline-block" />
              create and manage your<br />
              <span class="text-slate-800">cheat sheets</span>
            </h1>
            <p class="mt-6 text-xl text-slate-700">
              Finally a simple way to create/manage/share/print your cheat
              sheets. Create custom cheat sheets. Choose from multiple themes,
              print/share them.
            </p>
          </div>
          <form
            @submit.prevent="submit"
            class="mt-12 sm:flex sm:w-full sm:max-w-lg"
          >
            <div class="min-w-0 flex-1">
              <label for="hero-email" class="sr-only">Email address</label>
              <input
                id="hero-email"
                type="email"
                v-model="form.email"
                required
                class="block w-full rounded-full border border-slate-300 px-5 py-3 text-base text-slate-900 placeholder-slate-500 shadow-sm focus:border-primary-500 focus:ring-primary-500"
                placeholder="Enter your email"
              />
              <div
                v-if="form.errors.email"
                class="mt-1 ml-5 text-xs text-red-500"
              >
                {{ form.errors.email }}
              </div>
            </div>
            <div class="mt-4 sm:mt-0 sm:ml-3">
              <button
                type="submit"
                class="border-transparent block w-full rounded-full border bg-brand px-8 py-3 text-base font-medium tracking-wider text-white shadow hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 sm:px-10"
                :disabled="form.processing"
              >
                {{ form.processing ? 'Sending...' : 'Notify me' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="sm:mx-auto sm:max-w-3xl sm:px-6">
      <div
        class="py-12 sm:relative sm:mt-12 sm:py-16 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2"
      >
        <div
          class="relative -mr-40 pl-4 sm:mx-auto sm:max-w-3xl sm:px-0 lg:h-full lg:max-w-none lg:pl-12"
        >
          <img
            class="w-full lg:h-full lg:w-auto lg:max-w-none"
            src="/img/cheatly_wave.jpg"
            alt=""
          />
        </div>
      </div>
    </div>
  </div>
</template>
