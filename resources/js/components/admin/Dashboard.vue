<template>
  <div class="p-4">
    <h1 class="text-xl font-bold">Admin Dashboard</h1>
    <CreateEmployee @added="fetchEmployees" />
    <EmployeeList :employees="employees" @viewHistory="viewHistory" />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import api from "../../axios";
import CreateEmployee from "./CreateEmployee.vue";
import EmployeeList from "./EmployeeList.vue";

const employees = ref([]);

const fetchEmployees = async () => {
  const res = await api.get("/admin/employees");
  employees.value = res.data;
};

const viewHistory = (id) => {
  window.location.href = `/admin/employees/${id}/history`;
};

onMounted(fetchEmployees);
</script>
