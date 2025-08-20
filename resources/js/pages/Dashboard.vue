<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    attendances: Array,
});

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
];

const loading = ref(false);
const message = ref('');

const handleCheckIn = async () => {
    loading.value = true;
    try {
        await router.post('/checkin', {}, {
            onSuccess: () => {
                message.value = 'You have successfully checked in!';
            },
            onError: () => {
                message.value = 'Something went wrong during check-in.';
            },
            onFinish: () => {
                loading.value = false;
            }
        });
    } catch (error) {
        console.error(error);
        loading.value = false;
    }
};

const handleCheckOut = async () => {
    loading.value = true;
    try {
        await router.post('/checkout', {}, {
            onSuccess: () => {
                message.value = 'You have successfully checked out!';
            },
            onError: () => {
                message.value = 'Something went wrong during check-out.';
            },
            onFinish: () => {
                loading.value = false;
            }
        });
    } catch (error) {
        console.error(error);
        loading.value = false;
    }
};

const formatDate = (dateString: string) => {
    return new Date(dateString).toLocaleDateString('en-US', {
        weekday: 'short',
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    });
};

const formatTime = (timeString: string) => {
    return new Date(timeString).toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
    });
};
</script>

<template>
    <Head title="My Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col gap-6 p-6 bg-gray-50 min-h-screen">
            <!-- Check-in / Check-out Buttons -->
            <div class="flex gap-4">
                <button
                    @click="handleCheckIn"
                    :disabled="loading"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg shadow-md transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    {{ loading ? 'Checking In...' : 'Check In' }}
                </button>

                <button
                    @click="handleCheckOut"
                    :disabled="loading"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 rounded-lg shadow-md transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    {{ loading ? 'Checking Out...' : 'Check Out' }}
                </button>
            </div>

            <p v-if="message" class="mt-2 text-green-700 font-semibold">{{ message }}</p>

            <!-- Attendance History -->
            <div class="mt-6 bg-white shadow-lg rounded-lg p-5">
                <h2 class="text-xl font-bold mb-4 text-gray-800">My Attendance History</h2>

                <template v-if="props.attendances.length > 0">
                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200 rounded-lg overflow-hidden">
                            <thead>
                                <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                                    <th class="border border-gray-200 px-4 py-3 text-left">Date</th>
                                    <th class="border border-gray-200 px-4 py-3 text-left">Check-In</th>
                                    <th class="border border-gray-200 px-4 py-3 text-left">Check-Out</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="(attendance, index) in props.attendances"
                                    :key="index"
                                    class="hover:bg-gray-50 transition"
                                >
                                    <td class="border border-gray-200 px-4 py-2 font-medium text-gray-700">
                                        {{ formatDate(attendance.created_at) }}
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2 text-gray-600">
                                        {{ attendance.check_in ? formatTime(attendance.check_in) : '-' }}
                                    </td>
                                    <td class="border border-gray-200 px-4 py-2 text-gray-600">
                                        {{ attendance.check_out ? formatTime(attendance.check_out) : '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </template>

                <!-- Empty State -->
                <template v-else>
                    <div class="text-center py-6">
                        <p class="text-gray-500 text-lg">No attendance records yet</p>
                        <p class="text-gray-400">Check in to start tracking your time!</p>
                    </div>
                </template>
            </div>
        </div>
    </AppLayout>
</template>
