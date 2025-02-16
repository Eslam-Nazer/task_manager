<script setup></script>
<template>
    <aside
        class="fixed top-0 z-10 ml-[-100%] flex h-screen w-full flex-col justify-between border-r border-slate-700 bg-slate-800 px-4 pb-3 transition duration-300 md:w-4/12 lg:ml-0 lg:w-[25%] xl:w-[20%] 2xl:w-[15%]"
    >
        <div>
            <slot name="aside" />
        </div>
    </aside>
    <div class="mb-6 ml-auto lg:w-[75%] xl:w-[80%] 2xl:w-[85%]">
        <div class="pt-6">
            <main>
                <slot />
            </main>
        </div>
        <div
            class="fixed bottom-0 z-20 h-28 bg-slate-900 bg-opacity-70 shadow-2xl lg:w-[75%] lg:py-2.5 xl:w-[80%]"
        >
            <slot name="form" />
        </div>
    </div>
</template>
