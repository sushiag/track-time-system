<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Welcome">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>

    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a] dark:text-[#EDEDEC]">
        
        <!-- HEADER NAVIGATION -->
        <header class="mb-6 w-full max-w-[335px] lg:max-w-4xl text-sm not-has-[nav]:hidden">
            <nav class="flex items-center justify-end gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm font-medium leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]"
                >
                    Dashboard
                </Link>
            </nav>
        </header>

        <!-- MAIN WELCOME SECTION -->
        <main class="flex flex-1 flex-col items-center justify-center text-center space-y-6">
            <!-- Heading -->
            <h1 class="text-4xl font-extrabold leading-tight tracking-tight sm:text-5xl md:text-6xl">
                Welcome to <span class="text-[#3B82F6]">TimeTracker</span>
            </h1>
            
            <!-- Subtitle -->
            <p class="max-w-xl text-lg text-[#4b4b4b] dark:text-[#cfcfcf]">
                Build for fast, secure and easy use for
                <span class="font-semibold">Small Companies</span>
            </p>

            <!-- Buttons -->
            <div class="flex gap-4 mt-6">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="rounded-lg bg-[#3B82F6] px-6 py-3 text-white font-semibold hover:bg-[#2563EB] transition"
                >
                    Go to Dashboard
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-lg bg-[#3B82F6] px-6 py-3 text-white font-semibold hover:bg-[#2563EB] transition"
                    >
                        Log In
                    </Link>
                    <Link
                        :href="route('register')"
                        class="rounded-lg border border-[#3B82F6] px-6 py-3 font-semibold text-[#3B82F6] hover:bg-[#3B82F6] hover:text-white transition"
                    >
                        Register
                    </Link>
                </template>
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="mt-12 text-sm text-[#888] dark:text-[#777]">
            &copy; {{ new Date().getFullYear() }} TimeTracker. All rights reserved.
        </footer>
    </div>
</template>
