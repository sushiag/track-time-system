<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({
  checkins: Array
});

const form = useForm({
  status: 'in'
});

const submitCheckin = (status) => {
  form.status = status;
  form.post(route('checkins.store'));
};
</script>

<template>
  <Head title="Check-in / Check-out" />
  <AppLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Check-in / Check-out</h1>

      <div class="flex gap-4 mb-6">
        <button @click="submitCheckin('in')" class="bg-green-500 text-white px-4 py-2 rounded">
          CheckIn
        </button>
        <button @click="submitCheckin('out')" class="bg-red-500 text-white px-4 py-2 rounded">
          CheckOut
        </button>
      </div>

      <h2 class="text-xl font-semibold mb-2">History</h2>
      <table class="w-full border">
        <thead>
          <tr class="bg-gray-100">
            <th class="border p-2">#</th>
            <th class="border p-2">Status</th>
            <th class="border p-2">Date & Time</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(checkin, index) in props.checkins" :key="checkin.id">
            <td class="border p-2">{{ index + 1 }}</td>
            <td class="border p-2">{{ checkin.status }}</td>
            <td class="border p-2">{{ new Date(checkin.created_at).toLocaleString() }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>