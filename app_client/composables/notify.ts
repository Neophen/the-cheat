import mitt from 'mitt';
import { provide, inject } from 'vue';

import type { InjectionKey } from 'vue';

export type NotificationEvent = {
  id: number;
  message: string;
  type: 'success' | 'error' | 'info';
};

type NotificationEventLister = (event: NotificationEvent) => void;

type Events = {
  success: NotificationEvent;
  error: NotificationEvent;
};

const emitter = mitt<Events>();

let count = 0;

const generateId = () => {
  return count++;
};

interface Notifications {
  success(message: string): void;
  error(message: string): void;
}

const key = Symbol() as InjectionKey<Notifications>;

export const provideNotifications = () => {
  provide(key, {
    success: (message) => {
      emitter.emit('success', {
        id: generateId(),
        type: 'success',
        message,
      });
    },
    error: (message) => {
      emitter.emit('error', {
        id: generateId(),
        type: 'error',
        message,
      });
    },
  });
};

export const useNotifications = () => {
  const notifications = inject(key);
  if (!notifications) {
    throw new Error('Notifications have not been provided');
  }

  return {
    success: notifications.success,
    error: notifications.error,
    onNotification: (cb: NotificationEventLister) => {
      emitter.on('success', cb);
      emitter.on('error', cb);
    },
  };
};
