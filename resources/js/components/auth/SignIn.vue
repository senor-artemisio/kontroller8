<template>
    <div id="auth-sign-in">
        <div class="mdc-text-field">
            <input type="text" id="sign-in-email" class="mdc-text-field__input">
            <label class="mdc-floating-label" for="sign-in-email">E-mail</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div></div>
        <div id="sign-in-email-helper" class="mdc-text-field-helper-line">
            <div id="sign-in-email-message" class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent"></div>
        </div>
        <div></div>
        <div class="mdc-text-field">
            <input type="password" id="sign-in-password" class="mdc-text-field__input">
            <label class="mdc-floating-label" for="sign-in-password">Password</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div></div>
        <div id="sign-in-password-helper" class="mdc-text-field-helper-line">
            <div id="sign-in-password-message" class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent"></div>
        </div>
        <div></div>
        <button id="auth-sign-in-button" class="mdc-button">
            <span class="mdc-button__label">Sign in</span>
        </button>
    </div>
</template>
<script>
    import {MDCTextField} from '@material/textfield';
    export default {
        mounted() {
            document.querySelectorAll('.mdc-text-field').forEach(function (field) {
                new MDCTextField(field);
            });
        }
    }
</script>