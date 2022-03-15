<script setup lang="ts" name="NotificationList">
import { usePage } from '@inertiajs/inertia-vue3';
import { useNotifications } from '../composables';

import Notification from './Notification.vue';

import type { NotificationEvent } from '../composables';

type SharedProps = {
  messages: {
    success?: string;
    error?: string;
  };
};

const page = usePage<SharedProps>();
const notifications = useNotifications();

const events = ref<NotificationEvent[]>([]);

const addNotification = (event: NotificationEvent) => {
  events.value.unshift(event);
};

const removeEvent = (event: NotificationEvent) => {
  events.value.splice(
    events.value.findIndex((n) => n.id === event.id),
    1
  );
};

watch(
  () => page.props.value,
  (props) => {
    const { success, error } = props.messages;

    if (success) {
      notifications.success(success);
    }
    if (error) {
      notifications.error(error);
    }
  },
  {
    immediate: true,
    deep: true,
  }
);

onMounted(() => {
  notifications.onNotification(addNotification);
});
</script>

<template>
  <TransitionGroup
    enter-active-class="transition duration-200 ease-out"
    enter-from-class="transform translate-x-full opacity-0"
    enter-to-class="transform translate-x-0 opacity-100"
    leave-active-class="transition duration-200 ease-in"
    leave-from-class="transform translate-x-0 "
    leave-to-class="transform translate-x-full opacity-0"
    move-class="transition duration-100"
    tag="div"
    class="fixed top-0 right-0 z-50 mt-8 space-y-4"
  >
    <Notification
      v-for="event in events"
      :key="event.id"
      v-bind="event"
      @close="removeEvent(event)"
    />
  </TransitionGroup>
</template>
