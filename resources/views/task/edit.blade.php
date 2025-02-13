<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Update Task') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            {{ __('Update Task') }}
                        </h2>
                    </header>

                    <form class="max-w-md py-2" method="post">
                        @csrf
                        <x-input-label for='title'>{{ 'title' }}</x-input-label>
                        <x-text-input id="title" name="title" value="{{ old('title', $task->title) }}" class="w-full" />
                        @error('title')
                        <div class="text-red-600">{{ $message }}</div>
                        @enderror

                        <label for="status" class="block my-2 text-sm font-medium text-gray-900 dark:text-white">Select an option</label>
                        <select id="status" name="status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option selected>Choose a status</option>
                            @foreach ($status as $stat)
                            <option {{ old('status',$task->status) == $stat->value ? 'selected' : ''}} value="{{ $stat->value }}">{{ $stat->value }}</option>
                            @endforeach
                        </select>
                        @error('status')
                        <div class="text-red-600">{{ $message }}</div>
                        @enderror
                        <x-primary-button class="mt-4">Save</x-primary-button>
                    </form>


                </div>
            </div>
        </div>
    </div>

</x-app-layout>