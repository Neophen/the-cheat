<script setup lang="ts" name="NewsletterIndex">
type Member = {
  email: string;
  status: string;
};

interface Props {
  members: Member[];
}

defineProps<Props>();
</script>
<template layout="public">
  <div class="grid min-h-screen place-content-center">
    <div class="prose rounded-md bg-white p-4 shadow-md">
      <table>
        <thead>
          <tr>
            <th>Email</th>
            <th></th>
            <th class="text-right">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="member in members" :key="member.email">
            <td>{{ member.email }}</td>
            <td class="w-8"></td>
            <td class="ml-8 text-right">{{ member.status }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
