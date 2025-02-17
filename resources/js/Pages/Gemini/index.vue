<script setup>
import ChatLayout from '@/Layouts/GeminiLayout.vue';
import { useForm, Link } from '@inertiajs/vue3';
import ChatContent from '@/Components/ChatContent.vue';
import { onMounted, ref } from 'vue';

const promptInput = ref(null);
const chatContainer = ref(null);

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
</script>
<template>
    <ChatLayout>
        <template #aside>
            <ul class="p-2">
                <template v-for="message in messages" :key="message.id">
                    <li
                        class="my-2 flex justify-between rounded-lg bg-slate-900 px-4 py-2 font-semibold text-slate-400 duration-200 hover:bg-slate-700"
                    >
                        <Link :href="route('gemini', message.id)">
                            {{ message.context[0].prompt }}
                        </Link>
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
