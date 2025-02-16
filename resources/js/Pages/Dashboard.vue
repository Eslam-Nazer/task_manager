<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    tasks: Array,
});

const confirmDelete = (taskTitle, taskId) => {
    if (!confirm('Do you want delete this task: ' + taskTitle + ' ?')) {
        // window.location.href = route('delete-task', taskId);
        return 0;
    }
    router.delete(route('delete-task', taskId), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Task deleted successfully!');
        },
        onError: (errors) => {
            console.error('Error deleting task:', errors);
        },
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        You're logged in!
                    </div>
                </div>
            </div>
        </div>

        <div class="py-3">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="flex overflow-hidden bg-white py-3 shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <form class="mx-auto w-1/3">
                        <label
                            for="default-search"
                            class="sr-only mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Search</label
                        >
                        <div class="relative">
                            <div
                                class="pointer-events-none absolute inset-y-0 start-0 flex items-center ps-3"
                            >
                                <svg
                                    class="h-4 w-4 text-gray-500 dark:text-gray-400"
                                    aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        stroke="currentColor"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                                    />
                                </svg>
                            </div>
                            <input
                                type="search"
                                id="default-search"
                                class="w-full rounded-lg border border-gray-300 bg-gray-50 p-4 ps-10 text-sm text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                                placeholder="Search for tasks"
                                required
                            />
                            <a
                                href="#"
                                class="absolute bottom-2.5 end-2.5 rounded-lg bg-blue-700 px-4 py-2 text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                >Search</a
                            >
                        </div>
                    </form>

                    <div class="mr-3 flex justify-end">
                        <a
                            :href="route('create-task')"
                            class="m-2 mb-2 me-2 cursor-pointer rounded-full bg-blue-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >New Task</a
                        >
                    </div>
                </div>
            </div>
        </div>

        <div class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800"
                >
                    <div
                        class="relative overflow-x-auto shadow-md sm:rounded-lg"
                    >
                        <table
                            class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400"
                        >
                            <thead
                                class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-6 py-3">title</th>
                                    <th scope="col" class="px-6 py-3">
                                        username
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        status
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- @foreach ($tasks as $task) -->
                                <tr
                                    class="border-b border-gray-200 odd:bg-white even:bg-gray-50 dark:border-gray-700 odd:dark:bg-gray-900 even:dark:bg-gray-800"
                                    v-for="task in tasks"
                                    :key="task.id"
                                >
                                    <th
                                        scope="row"
                                        class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                                    >
                                        {{ task.title }}
                                    </th>
                                    <td class="px-6 py-4">
                                        <span
                                            v-for="user in task.users"
                                            :key="user.id"
                                        >
                                            {{ user.name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ task.status }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <Link
                                            :href="route('edit-task', task.id)"
                                            class="font-medium text-blue-600 hover:underline dark:text-blue-500"
                                            >Edit</Link
                                        >
                                        <Link
                                            @click.prevent="
                                                confirmDelete(
                                                    task.title,
                                                    task.id,
                                                )
                                            "
                                            class="ml-3 font-medium text-red-600 hover:underline dark:text-red-500"
                                            >Delete</Link
                                        >
                                    </td>
                                </tr>
                                <!-- @endforeach -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
