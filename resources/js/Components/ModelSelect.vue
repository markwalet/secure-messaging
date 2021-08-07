<template>
    <select :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            ref="input"
            name="location"
            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">

        <option v-for="option in options" :value="option[valueAttribute]">
            {{ option[labelAttribute] }}
        </option>
    </select>
</template>

<script>
    export default {
        props: {
            modelValue: { type: String, required: false, default: undefined },
            options: { type: Array, required: true },
            valueAttribute: { type: String, required: false, default: 'id' },
            labelAttribute: { type: String, required: false, default: 'label' },
        },

        emits: ['update:modelValue'],

        methods: {
            focus() {
                this.$refs.input.focus();
            },
        },
    };
</script>
