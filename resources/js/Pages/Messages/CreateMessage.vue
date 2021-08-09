<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create message
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

                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="message" value="Message" />
                            <jet-input id="message" type="text" class="mt-1 block w-full" v-model="form.message" />
                            <jet-input-error :message="form.errors.message" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <jet-label for="password" value="Password" />
                            <jet-input id="password" type="text" class="mt-1 block w-full" v-model="form.password" />
                            <jet-input-error :message="form.errors.password" class="mt-2" />
                            <div class="mt-3 text-sm text-gray-600">
                                <p>
                                    The password will not be sent via mail to your colleague. You have to share it manually with him, preferably not by mail.
                                </p>
                            </div>
                        </div>
                    </template>

                    <template #actions>
                        <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                            The mail is sent to your colleage.
                        </jet-action-message>

                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Send
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
                    password : '',
                }),
            };
        },

        mounted() {
            this.form.password = this.generatePassword();
        },

        methods: {
            createMessage() {
                this.form.post(route('messages.store'), {
                    onSuccess: () => {
                        this.form.colleague = null;
                        this.form.message = '';
                        this.form.password = this.generatePassword();
                    },
                });
            },
            generatePassword() {
                let result = '';
                const characters = 'ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghjkmnpqrstuvwxyz23456789';
                const charactersLength = characters.length;
                for (let i = 0; i < 16; i++) {
                    result += characters.charAt(Math.floor(Math.random() *
                                                           charactersLength));
                }
                return result;
            },
        },
    };
</script>
