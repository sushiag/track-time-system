<template>
  <div class="p-4">
    <h1 class="text-xl font-bold">Employee Dashboard</h1>
    <button @click="checkIn" class="bg-green-500 text-white p-2 rounded mr-2">Check In</button>
    <button @click="checkOut" class="bg-red-500 text-white p-2 rounded">Check Out</button>
    <MyHistory :userId="userId" />
  </div>
</template>

<script setup>
import { ref } from "vue";
import api from "../../axios";
import MyHistory from "./MyHistory.vue";

const userId = 1; // Replace with logged-in employee ID

const checkIn = async () => {
  await api.post("/employee/checkin", { user_id: userId });
  alert("Checked in!");
};

const checkOut = async () => {
  await api.post("/employee/checkout", { user_id: userId });
  alert("Checked out!");
};
</script>
