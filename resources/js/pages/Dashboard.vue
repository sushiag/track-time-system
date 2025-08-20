<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const loading = ref(false);
const message = ref('');

const handleCheckIn = async () => {
    loading.value = true;
    try {
        await router.post('/checkin', {}, {
            onSuccess: () => {
                message.value = '✅ You have successfully checked in!';
            },
            onError: () => {
                message.value = '❌ Something went wrong during check-in.';
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
                message.value = '✅ You have successfully checked out!';
            },
            onError: () => {
                message.value = '❌ Something went wrong during check-out.';
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
    <Head title=" My Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>

            <!-- Check-in / Check-out Section -->
            <div class="mt-6 flex gap-4">
                <button
                    @click="handleCheckIn"
                    :disabled="loading"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 disabled:opacity-50"
                >
                    {{ loading ? 'Checking In...' : 'Check In' }}
                </button>

                <button
                    @click="handleCheckOut"
                    :disabled="loading"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 disabled:opacity-50"
                >
                    {{ loading ? 'Checking Out...' : 'Check Out' }}
                </button>
            </div>

            <p v-if="message" class="mt-3 text-blue-600 font-medium">{{ message }}</p>
        </div>
    </AppLayout>
</template>
