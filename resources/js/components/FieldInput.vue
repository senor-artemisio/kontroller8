<template>
    <div>
        <div :id="id" class="mdc-text-field">
            <input :type="type" :step="step" :id="id + '-input'" class="mdc-text-field__input">
            <label class="mdc-floating-label" :for="id">{{ title }}</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div :id="id + '-helper'" class="mdc-text-field-helper-line">
            <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"></div>
        </div>
    </div>
</template>
<script>
    import {MDCTextField} from '@material/textfield';

    export default {
        data: function () {
            return {
                field: null
            };
        },
        props: {
            id: {
                type: String,
            },
            title: {
                type: String
            },
            type: {
                type: String,
                default: "text"
            },
            step: {
                type: Number,
                default: 1
            }
        },
        mounted() {
            this.$data.field = new MDCTextField(document.querySelector('#' + this.id));
            this.$data.field.useNativeValidation = false;
        },
        methods: {
            error(message) {
                this.$data.field.valid = false;
                this.$data.field.helperTextContent = message;
            },
            clear() {
                this.$data.field.valid = true;
                this.$data.field.helperTextContent = '';
            },
            value() {
                return this.$data.field.value;
            },
        }
    }
</script>