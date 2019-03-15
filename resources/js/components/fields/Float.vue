<template>
    <div>
        <div :id="id" class="mdc-text-field">
            <input type="number" :id="id + '-input'" class="mdc-text-field__input" autocomplete="off" step="0.1" min="0" v-model="value">
            <label class="mdc-floating-label" :for="id" v-bind:class="{ 'mdc-floating-label--float-above': value }">{{ title }}</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div :id="id + '-helper'" class="mdc-text-field-helper-line">
            <div class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg"></div>
        </div>
    </div>
</template>
<script>
    import field from './field';

    export default field.default();
</script>