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
                            <form @submit.prevent="onSubmit" v-show="!secureMessage">
                                <jet-label for="password" value="Password" />
                                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" />
                                <jet-input-error :message="form.errors.password" class="mt-2" />
                                <div class="mt-3 text-sm text-gray-600">
                                    <p>
                                        Please fill in the password you got from your password to decrypt the message.
                                    </p>
                                </div>

                                <div class="flex items-center justify-end py-3 text-right">
                                    <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                        Decrypted.
                                    </jet-action-message>

                                    <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Decrypt
                                    </jet-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
        },

        props: {
            message    : { type: Object, required: true },
            signedRoute: { type: String, required: false },
        },

        data() {
            return {
                form: this.$inertia.form({
                    password: null,
                }),
            };
        },

        methods: {
            onSubmit() {
                this.form.post(this.signedRoute);
            },
        },
    };
</script>
