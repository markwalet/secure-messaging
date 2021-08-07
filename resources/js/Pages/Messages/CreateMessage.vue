<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <jet-form-section @submitted="createMessage" ref="form">
                    <template #title>
                        Send secure message
                    </template>

                    <template #description>
                        Create a secure message and send it to one of your colleagues.
                    </template>

                    <template #form>
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="colleague" value="Colleague" />
                            <model-select id="colleague" type="text" class="mt-1 block w-full" v-model="form.colleague" :options="colleagues" />
                            <jet-input-error :message="form.errors.colleague" class="mt-2" />
                        </div>

                        <!-- Message -->
                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="message" value="Message" />
                            <jet-input id="message" type="text" class="mt-1 block w-full" v-model="form.message" />
                            <jet-input-error :message="form.errors.message" class="mt-2" />
                        </div>
                    </template>

                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                            Saved.
                        </jet-action-message>

                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </jet-button>
                    </template>
                </jet-form-section>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import ModelSelect from '@/Components/ModelSelect';
    import JetActionMessage from '@/Jetstream/ActionMessage';
    import JetButton from '@/Jetstream/Button';
    import JetFormSection from '@/Jetstream/FormSection';
    import JetInput from '@/Jetstream/Input';
    import JetInputError from '@/Jetstream/InputError';
    import JetLabel from '@/Jetstream/Label';
    import JetSecondaryButton from '@/Jetstream/SecondaryButton';
    import AppLayout from '@/Layouts/AppLayout.vue';

    export default {
        components: {
            ModelSelect,
            AppLayout,
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: {
            colleagues: { type: Array, required: true },
        },

        data() {
            return {
                form: this.$inertia.form({
                    _method  : 'POST',
                    colleague: null,
                    message  : '',
                }),
            };
        },

        methods: {
            createMessage() {
                this.form.post(route('messages.store'), {
                    onSuccess: () => {
                        this.form.colleague = null;
                        this.form.message = '';
                    }
                });

            },
        },
    };
</script>
