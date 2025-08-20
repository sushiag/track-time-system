<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Form, Head } from '@inertiajs/vue3';

defineProps<{
    status?: string;
    canResetPassword: boolean;
}>();
</script>

<template>
    <AuthBase title="Log in to your account" description="Enter your email and password below to log in">
        <Head title="Log in" />

        <!-- Status Message -->
        <div v-if="status" class="mb-4 text-sm font-medium text-center text-green-600">
            {{ status }}
        </div>

        <!-- LOGIN FORM -->
        <Form
            method="post"
            :action="route('login')"
            :reset-on-success="['password']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6"
        >
            <!-- Input Fields -->
            <div class="grid gap-6">
                <!-- Email -->
                <div class="grid gap-2">
                    <Label for="email">Email address</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="email"
                        placeholder="email@example.com"
                    />
                    <InputError :message="errors.email" />
                </div>

                <!-- Password -->
                <div class="grid gap-2">
                    <div class="flex items-center justify-between">
                        <Label for="password">Password</Label>
                        <TextLink
                            v-if="canResetPassword"
                            :href="route('password.request')"
                            class="text-sm"
                            :tabindex="5"
                        >
                            Forgot password?
                        </TextLink>
                    </div>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        required
                        :tabindex="2"
                        autocomplete="current-password"
                        placeholder="Password"
                    />
                    <InputError :message="errors.password" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center gap-2">
                    <Checkbox id="remember" name="remember" :tabindex="3" />
                    <Label for="remember">Remember me</Label>
                </div>

                <!-- Submit Button -->
                <Button
                    type="submit"
                    class="w-full mt-4 bg-blue-600 hover:bg-blue-700 text-white"
                    :tabindex="4"
                    :disabled="processing"
                >
                    Log in
                </Button>
            </div>

            <!-- Footer Links -->
            <div class="text-sm text-center text-muted-foreground">
                Don't have an account?
                <TextLink :href="route('register')" :tabindex="5" class="underline underline-offset-4 ml-1">
                    Sign up
                </TextLink>
            </div>
        </Form>
    </AuthBase>
</template>