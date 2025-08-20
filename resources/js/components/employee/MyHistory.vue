<template>
  <div>
    <h2 class="text-lg font-semibold mt-4">My Check-In History</h2>
    <table class="border-collapse border border-gray-400 w-full mt-2">
      <thead>
        <tr>
          <th class="border p-2">Check-In</th>
          <th class="border p-2">Check-Out</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="h in history" :key="h.id">
          <td class="border p-2">{{ h.check_in_time }}</td>
          <td class="border p-2">{{ h.check_out_time || "—" }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../../axios";

const props = defineProps({
  userId: Number,
});

const history = ref([]);

const fetchHistory = async () => {
  const res = await api.get(`/employee/history/${props.userId}`);
  history.value = res.data;
};

onMounted(fetchHistory);
</script>
