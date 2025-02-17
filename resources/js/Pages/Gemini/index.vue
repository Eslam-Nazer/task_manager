<script setup>
import ChatLayout from '@/Layouts/GeminiLayout.vue';
import { useForm, Link, Head } from '@inertiajs/vue3';
import ChatContent from '@/Components/ChatContent.vue';
import { computed, onMounted, ref } from 'vue';
import Skeleton from '@/Components/Skeleton.vue';

const promptInput = ref(null);
const chatContainer = ref(null);
const showDeleteButton = ref(false);

const props = defineProps({
    messages: Array,
    chat: null | Object,
});

const form = useForm({
    prompt: '',
});

const submit = () => {
    const url = props.chat ? `/chat/gemini/${props.chat?.id}` : '/chat/gemini';
    form.post(url, {
        onFinish: () => clear(),
    });
};

const scrollToBottom = () => {
    if (props.chat) {
        const el = chatContainer.value;
        el.scrollTop = el.scrollHeight;
    }
};

const clear = () => {
    form.prompt = '';
    promptInput.value.focus();
    scrollToBottom();
};
onMounted(() => {
    clear();
});

const title = computed(() => props.chat?.context[0].prompt ?? 'New Chat');
</script>
<template>
    <Head :title="title" />
    <ChatLayout>
        <template #aside>
            <ul class="p-2">
                <li
                    class="my-2 flex justify-between rounded-lg bg-slate-900 font-semibold text-green-400 duration-200 hover:bg-slate-700"
                    v-if="chat"
                >
                    <Link
                        :href="route('gemini')"
                        class="h-full w-full px-4 py-2"
                    >
                        <div class="flex justify-between">
                            <span class="block">New Chat</span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="size-6"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                />
                            </svg>
                        </div>
                    </Link>
                </li>
                <template v-for="message in messages" :key="message.id">
                    <li
                        :class="[
                            message.id === chat?.id
                                ? 'bg-slate-700'
                                : 'bg-slate-900',
                            'my-2 flex justify-between rounded-lg font-semibold text-slate-400 duration-200 hover:bg-slate-700',
                        ]"
                    >
                        <Link
                            :href="route('gemini', message.id)"
                            class="h-full w-full px-4 py-2"
                        >
                            {{ message.context[0].prompt }}
                        </Link>
                        <div
                            v-if="message.id === chat?.id"
                            class="flex items-center justify-center"
                        >
                            <button
                                @click="showDeleteButton = !showDeleteButton"
                                class="h-full w-full p-2"
                                v-if="!showDeleteButton"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="size-6 text-red-500"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"
                                    />
                                </svg>
                            </button>
                            <span
                                class="flex items-center justify-between"
                                v-if="showDeleteButton"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="mx-1 size-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                    />
                                </svg>

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="mr-2 size-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                    />
                                </svg>
                            </span>
                        </div>
                    </li>
                </template>
            </ul>
        </template>

        <div class="flex w-full text-white">
            <template v-if="chat">
                <div class="flex h-screen w-full bg-slate-900">
                    <div class="w-full overflow-auto pb-36" ref="chatContainer">
                        <template
                            v-for="(contect, index) in chat?.context"
                            :key="index"
                        >
                            <ChatContent :content="contect" />
                        </template>
                        <Skeleton v-show="form.processing" />
                    </div>
                </div>
            </template>
        </div>

        <template #form>
            <section class="top-0 px-6">
                <div class="w-full">
                    <div class="relative flex flex-1 items-center">
                        <input
                            type="text"
                            class="w-full rounded-lg bg-slate-700 text-white"
                            placeholder="Ask laravel gemini"
                            v-model="form.prompt"
                            @keyup.enter="submit"
                            :disabled="form.processing"
                            ref="promptInput"
                        />

                        <div
                            class="absolute inset-y-0 right-0 flex cursor-pointer items-center pl-3"
                        >
                            <svg
                                v-if="!form.processing"
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
                            <div
                                class="dot-typing -ml-10"
                                v-if="form.processing"
                            ></div>
                        </div>
                    </div>
                </div>
            </section>
        </template>
    </ChatLayout>
</template>
<style>
.dot-typing {
    position: relative;
    left: -9999px;
    width: 10px;
    height: 10px;
    border-radius: 5px;
    background-color: #9880ff;
    color: #9880ff;
    box-shadow:
        9984px 0 0 0 #9880ff,
        9999px 0 0 0 #9880ff,
        10014px 0 0 0 #9880ff;
    animation: dot-typing 1.5s infinite linear;
}
@keyframes dot-typing {
    0% {
        box-shadow:
            9984px 0 0 0 #9880ff,
            9999px 0 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
    16.667% {
        box-shadow:
            9984px -10px 0 0 #9880ff,
            9999px 0 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
    33.333% {
        box-shadow:
            9984px 0 0 0 #9880ff,
            9999px 0 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
    50% {
        box-shadow:
            9984px 0 0 0 #9880ff,
            9999px -10px 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
    66.667% {
        box-shadow:
            9984px 0 0 0 #9880ff,
            9999px 0 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
    83.333% {
        box-shadow:
            9984px 0 0 0 #9880ff,
            9999px 0 0 0 #9880ff,
            10014px -10px 0 0 #9880ff;
    }
    100% {
        box-shadow:
            9984px 0 0 0 #9880ff,
            9999px 0 0 0 #9880ff,
            10014px 0 0 0 #9880ff;
    }
}
</style>
