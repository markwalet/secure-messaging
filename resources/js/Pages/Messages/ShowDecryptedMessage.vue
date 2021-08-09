<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                View message
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="max-w-6xl mx-auto p-6 lg:p-8 flex justify-center">
                        <div class="lg:w-1/2">
                            <div class="flex items-start my-3">
                                <div class="flex-shrink-0">
                                    <!-- Heroicon name: outline/check-circle -->
                                    <svg class="h-6 w-6 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3 w-0 flex-1 pt-0.5">
                                    <p class="text-sm font-medium text-gray-600">
                                        Message unlocked! Your message is shown below:
                                    </p>
                                </div>
                            </div>
                            <pre class="bg-gray-200 p-4 rounded-md shadow-inner">{{ secureMessage }}</pre>
                            <div class="mt-3 text-sm text-gray-600">
                                <p>
                                    This message will self-destruct after you refresh the page.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout.vue';

    export default {
        components: {
            AppLayout,
        },

        props: {
            secureMessage: { type: String, required: true },
        },
    };
</script>
