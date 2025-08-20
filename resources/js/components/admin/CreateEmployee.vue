<template>
  <form @submit.prevent="createEmployee" class="mb-4">
    <input v-model="name" placeholder="Name" class="border p-2 mr-2" />
    <input v-model="email" placeholder="Email" class="border p-2 mr-2" />
    <button class="bg-blue-500 text-white p-2 rounded">Add</button>
  </form>
</template>

<script setup>
import { ref } from "vue";
import api from "../../axios";

const name = ref("");
const email = ref("");

const createEmployee = async () => {
  await api.post("/admin/employees", { name: name.value, email: email.value });
  name.value = "";
  email.value = "";
  window.location.reload();
};
</script>
