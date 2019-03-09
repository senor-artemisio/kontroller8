<template>
    <div id="auth-sign-up" class="hidden">
        <div class="mdc-text-field">
            <input type="text" id="sign-up-email" class="mdc-text-field__input">
            <label class="mdc-floating-label" for="sign-up-email">E-mail</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div></div>
        <div id="sign-up-email-helper" class="mdc-text-field-helper-line">
            <div id="sign-up-email-message"
                 class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent"></div>
        </div>
        <div></div>
        <div class="mdc-text-field">
            <input type="password" id="sign-up-password" class="mdc-text-field__input">
            <label class="mdc-floating-label" for="sign-up-password">Password</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div></div>
        <div id="sign-up-password-helper" class="mdc-text-field-helper-line">
            <div id="sign-up-password-message"
                 class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent"></div>
        </div>
        <div></div>
        <div class="mdc-text-field">
            <input type="name" id="sign-up-name" class="mdc-text-field__input">
            <label class="mdc-floating-label" for="sign-up-name">Name</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div></div>
        <div id="sign-up-name-helper" class="mdc-text-field-helper-line">
            <div id="sign-up-name-message"
                 class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent"></div>
        </div>
        <div></div>
        <button id="auth-sign-up-button" class="mdc-button" v-on:click="signUp">
            <span class="mdc-button__label">Sign up</span>
        </button>
    </div>
</template>
<script>
    import {MDCTextField} from '@material/textfield';
    import api from '../../api';
    import cookies from '../../cookies';

    export default {
        mounted() {
            document.querySelectorAll('.mdc-text-field').forEach(function (field) {
                new MDCTextField(field);
            });
        },
        methods: {
            signUp: function (event) {
                this.disableButton();
                this.clearErrors();
                api.post('/api/auth/signup', {
                    'email': document.querySelector('#sign-up-email').value,
                    'password': document.querySelector('#sign-up-password').value,
                    'name': document.querySelector('#sign-up-name').value,
                }).then(response => {
                    api.post('/api/auth/signin', {
                        'email': document.querySelector('#sign-up-email').value,
                        'password': document.querySelector('#sign-up-password').value,
                    }).then(response => {
                        let token = null;
                        let expiresAt = null;
                        if (response.data) {
                            if (response.data.data.access_token) {
                                token = response.data.data.access_token;
                            }
                            if (response.data.data.expires_at) {
                                expiresAt = response.data.data.expires_at;
                            }
                            this.storeToken(token, expiresAt);
                            location.href = '/';
                        }
                        console.error(error);
                    }).catch(error => {
                        console.error(error);
                        this.enableButton();
                    });
                }).catch(error => {
                    if (error.response && error.response.status === 422) {
                        let data = error.response.data;
                        if (data && data.errors) {
                            this.processErrors(data.errors);
                        }
                        this.enableButton();
                        return;
                    }
                    console.error(error);
                    this.enableButton();
                });
            },
            disableButton: function () {
                document.querySelector('#auth-sign-up-button').setAttribute('disabled', 'disabled');
            },
            enableButton: function () {
                document.querySelector('#auth-sign-up-button').removeAttribute('disabled');
            },
            clearErrors: function () {
                document.querySelectorAll('.mdc-text-field-helper-text').forEach(function (value) {
                    value.innerHTML = '';
                });
            },
            processErrors: function (errors) {
                if (errors.email && errors.email.length > 0) {
                    document.querySelector('#sign-up-email-message').innerHTML = errors.email.pop();
                }
                if (errors.password && errors.password.length > 0) {
                    document.querySelector('#sign-up-password-message').innerHTML = errors.password.pop();
                }
                if (errors.name && errors.name.length > 0) {
                    document.querySelector('#sign-up-name-message').innerHTML = errors.name.pop();
                }
            },
            storeToken: function (token, expiresAt) {
                cookies.set('X-AUTH-TOKEN', token, {expires: new Date((new Date).getTime() + expiresAt * 1000)});
            }
        }
    }
</script>

<style>
    .mdc-text-field-helper-line {
        display: inline-block;
    }
</style>