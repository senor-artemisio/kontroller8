<template>
    <div id="auth-sign-up" class="hidden">
        <div class="mdc-text-field">
            <input type="text" id="sign-up-email" class="mdc-text-field__input">
            <label class="mdc-floating-label" for="sign-up-email">E-mail</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div></div>
        <div class="mdc-text-field">
            <input type="password" id="sign-up-password" class="mdc-text-field__input">
            <label class="mdc-floating-label" for="sign-up-password">Password</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div></div>
        <div class="mdc-text-field">
            <input type="password" id="sign-up-name" class="mdc-text-field__input">
            <label class="mdc-floating-label" for="sign-up-name">Name</label>
            <div class="mdc-line-ripple"></div>
        </div>
        <div></div>
        <button id="auth-sign-up-button" class="mdc-button" v-on:click="signUp">
            <span class="mdc-button__label">Sign up</span>
        </button>
    </div>
</template>
<script>
    import {MDCTextField} from '@material/textfield';
    import axios from 'axios';
    export default {
        mounted() {
            document.querySelectorAll('.mdc-text-field').forEach(function (field) {
                new MDCTextField(field);
            });
        },
        methods:{
            signUp: function(event) {
                axios.post('/api/auth/signup', {
                    'email': document.querySelector('#sign-up-email').value,
                    'password': document.querySelector('#sign-up-password').value,
                    'name': document.querySelector('#sign-up-name').value,
                });
            }
        }
    }
</script>