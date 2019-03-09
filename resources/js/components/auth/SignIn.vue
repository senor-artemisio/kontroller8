<template>
    <div id="auth-sign-in">
        <div class="mdc-text-field">
            <input type="text" id="sign-in-email" class="mdc-text-field__input">
            <label class="mdc-floating-label" for="sign-in-email">E-mail</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div></div>
        <div id="sign-in-email-helper" class="mdc-text-field-helper-line mdc-theme--error">
            <div id="sign-in-email-message" class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent"></div>
        </div>
        <div></div>
        <div class="mdc-text-field">
            <input type="password" id="sign-in-password" class="mdc-text-field__input">
            <label class="mdc-floating-label" for="sign-in-password">Password</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div></div>
        <div id="sign-in-password-helper" class="mdc-text-field-helper-line mdc-theme--error">
            <div id="sign-in-password-message" class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent"></div>
        </div>
        <div></div>
        <button id="auth-sign-in-button" class="mdc-button" v-on:click="signIn">
            <span class="mdc-button__label">Sign in</span>
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
        methods:{
            signIn:function(){
                this.clearErrors();
                api.post('/api/auth/signin', {
                    'email': document.querySelector('#sign-in-email').value,
                    'password': document.querySelector('#sign-in-password').value,
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
                    if(error.response) {
                        if (error.response.status === 422) {
                            let data = error.response.data;
                            if (data && data.errors) {
                                this.processErrors(data.errors);
                            }
                            this.enableButton();
                            return;
                        }
                    }
                    console.error(error);
                    this.enableButton();
                });
            },
            disableButton: function () {
                document.querySelector('#auth-sign-in-button').setAttribute('disabled', 'disabled');
            },
            enableButton: function () {
                document.querySelector('#auth-sign-in-button').removeAttribute('disabled');
            },
            clearErrors: function () {
                document.querySelectorAll('.mdc-text-field-helper-text').forEach(function (value) {
                    value.innerHTML = '';
                });
            },
            processErrors: function (errors) {
                if (errors.email && errors.email.length > 0) {
                    document.querySelector('#sign-in-email-message').innerHTML = errors.email.pop();
                }
                if (errors.password && errors.password.length > 0) {
                    document.querySelector('#sign-in-password-message').innerHTML = errors.password.pop();
                }
            },
            storeToken: function (token, expiresAt) {
                cookies.set('X-AUTH-TOKEN', token, {expires: new Date((new Date).getTime() + expiresAt * 1000)});
            }
        }
    }
</script>