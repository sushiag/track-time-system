<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref, defineProps } from 'vue';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

// ✅ Define Props from Laravel Controller
const props = defineProps<{
    attendances: {
        id: number;
        check_in: string | null;
        check_out: string | null;
        created_at: string;
    }[];
}>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
];

const loading = ref(false);
const message = ref('');
const attendance = ref<'none' | 'checked-in' | 'checked-out'>('none');

// Handle Check-In
const handleCheckIn = async () => {
    if (attendance.value === 'checked-in') {
        message.value =  'You have already checked in.';
        return;
    }

    loading.value = true;
    try {
        await router.post('/checkin', {}, {
            onSuccess: () => {
                attendance.value = 'checked-in';
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

// Handle Check-Out
const handleCheckOut = async () => {
    if (attendance.value !== 'checked-in') {
        message.value = 'You must check in first before checking out.';
        return;
    }

    loading.value = true;
    try {
        await router.post('/checkout', {}, {
            onSuccess: () => {
                attendance.value = 'checked-out';
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
</script>

<template>
    <Head title="My Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">

            <!-- Check-in / Check-out Section -->
            <div class="mt-6 flex gap-4">
                <button
                    @click="handleCheckIn"
                    :disabled="loading || attendance === 'checked-in'"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 disabled:opacity-50"
                >
                    {{ loading && attendance !== 'checked-in' ? 'Checking In...' : 'Check In' }}
                </button>

                <button
                    @click="handleCheckOut"
                    :disabled="loading || attendance !== 'checked-in'"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 disabled:opacity-50"
                >
                    {{ loading && attendance === 'checked-in' ? 'Checking Out...' : 'Check Out' }}
                </button>
            </div>

            <!-- Message -->
            <p v-if="message" class="mt-3 text-blue-600 font-medium">{{ message }}</p>

            <!-- Attendance History Table -->
            <div class="mt-6 bg-white dark:bg-gray-800 shadow rounded-lg p-4 transition duration-300">
                <h2 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-200">
                    Attendance History
                </h2>

                <table class="w-full border-collapse border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Date</th>
                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Check-In Time</th>
                            <th class="border border-gray-300 dark:border-gray-600 px-4 py-2 text-left">Check-Out Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in props.attendances"
                            :key="item.id"
                            class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200"
                        >
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-300">
                                {{ new Date(item.created_at).toLocaleDateString() }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-300">
                                {{ item.check_in ? new Date(item.check_in).toLocaleTimeString() : '-' }}
                            </td>
                            <td class="border border-gray-300 dark:border-gray-700 px-4 py-2 text-gray-800 dark:text-gray-300">
                                {{ item.check_out ? new Date(item.check_out).toLocaleTimeString() : 'Not yet' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
