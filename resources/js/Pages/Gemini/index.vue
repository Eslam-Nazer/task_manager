<script setup>
import ChatLayout from '@/Layouts/GeminiLayout.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    promt: '',
});

const submit = () => {
    form.post('/chat/gemini');
};
</script>
<template>
    <ChatLayout>
        <template #aside> </template>
        <div class="flex w-full text-white"></div>
        <template #form>
            <section class="top-0 px-6">
                <div class="w-full">
                    <div class="relative flex flex-1 items-center">
                        <input
                            type="text"
                            class="w-full rounded-lg bg-slate-700 text-white"
                            placeholder="Ask laravel gemini"
                            v-model="form.promt"
                            @keyup.enter="submit"
                        />
                        <div
                            class="absolute inset-y-0 right-0 flex cursor-pointer items-center pl-3"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="-ml-8 size-6 text-slate-200"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5"
                                />
                            </svg>
                        </div>
                    </div>
                </div>
            </section>
        </template>
    </ChatLayout>
</template>
