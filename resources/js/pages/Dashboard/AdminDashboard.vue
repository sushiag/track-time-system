<script setup lang="ts">
import { ref, onMounted } from "vue";
import axios from "axios";
import AppLayout from "@/layouts/AppLayout.vue";

interface User {
  id: number;
  name: string;
  email: string;
}

interface Attendance {
  id: number;
  user_id: number;
  check_in: string | null;
  check_out: string | null;
  created_at: string;
  updated_at: string;
  user: User;
}

const attendances = ref<Attendance[]>([]);
const isLoading = ref<boolean>(true);

const showModal = ref<boolean>(false);
const newEmployee = ref({ name: "", email: "", password: "" });
const isSubmitting = ref<boolean>(false);
const formErrors = ref<Record<string, string[]>>({});

const fetchAttendances = async () => {
  try {
    const response = await axios.get("/api/attendances");
    attendances.value = response.data;
  } catch (error) {
    console.error("Error fetching attendances:", error);
  } finally {
    isLoading.value = false;
  }
};
const createEmployee = async () => {
  formErrors.value = {}; // clear previous errors

  try {
    isSubmitting.value = true;
    await axios.post("/employees", newEmployee.value, {
      headers: { "Content-Type": "application/json" },
    });

    alert("Employee added successfully!");
    showModal.value = false;

    // Reset form
    newEmployee.value = { name: "", email: "", password: "" };

    // Refresh attendance data
    fetchAttendances();
  } catch (error: any) {
    if (error.response?.status === 422) {
      // Validation errors from Laravel
      formErrors.value = error.response.data.errors;
    } else {
      console.error("Error adding employee:", error.response?.data);
      alert(error.response?.data?.message || "Failed to add employee!");
    }
  } finally {
    isSubmitting.value = false;
  }
};

onMounted(fetchAttendances);
</script>

<template>
  <AppLayout>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

      <!-- Add Employee Button -->
      <div class="mb-4">
        <button
          @click="showModal = true"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow"
        >
          + Add Employee
        </button>
      </div>

      <!-- Attendance Table -->
      <div>
        <div v-if="isLoading" class="text-gray-500">Loading data...</div>

        <div v-else>
          <table class="w-full border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
            <thead>
              <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                <th class="px-4 py-2 border">Employee</th>
                <th class="px-4 py-2 border">Check-in</th>
                <th class="px-4 py-2 border">Check-out</th>
                <th class="px-4 py-2 border">Date</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="attendance in attendances"
                :key="attendance.id"
                class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200"
              >
                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                  {{ attendance.user.name }}
                </td>
                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                  {{ attendance.check_in || "Not Checked In" }}
                </td>
                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                  {{ attendance.check_out || "Not Checked Out" }}
                </td>
                <td class="border border-gray-300 dark:border-gray-700 px-4 py-2">
                  {{ new Date(attendance.created_at).toLocaleDateString() }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Add Employee Modal -->
      <div
        v-if="showModal"
        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50"
      >
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
          <h2 class="text-xl font-semibold mb-4">Add New Employee</h2>

          <form @submit.prevent="createEmployee" class="space-y-3">
            <!-- Name -->
            <div>
              <label class="block text-sm font-medium">Name</label>
              <input
                v-model="newEmployee.name"
                type="text"
                class="w-full px-3 py-2 border rounded"
                placeholder="Enter name"
              />
              <p v-if="formErrors.name" class="text-red-600 text-sm mt-1">
                {{ formErrors.name[0] }}
              </p>
            </div>

            <!-- Email -->
            <div>
              <label class="block text-sm font-medium">Email</label>
              <input
                v-model="newEmployee.email"
                type="email"
                class="w-full px-3 py-2 border rounded"
                placeholder="Enter email"
              />
              <p v-if="formErrors.email" class="text-red-600 text-sm mt-1">
                {{ formErrors.email[0] }}
              </p>
            </div>

            <!-- Password -->
            <div>
              <label class="block text-sm font-medium">Password</label>
              <input
                v-model="newEmployee.password"
                type="password"
                class="w-full px-3 py-2 border rounded"
                placeholder="Enter password"
              />
              <p v-if="formErrors.password" class="text-red-600 text-sm mt-1">
                {{ formErrors.password[0] }}
              </p>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end gap-2 mt-4">
              <button
                type="button"
                @click="showModal = false"
                class="bg-gray-300 hover:bg-gray-400 text-black px-4 py-2 rounded"
              >
                Cancel
              </button>
              <button
                type="submit"
                :disabled="isSubmitting"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
              >
                {{ isSubmitting ? "Adding..." : "Add" }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
