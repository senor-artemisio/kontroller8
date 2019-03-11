<template>
    <form id="auth-sign-up" class="hidden" v-on:submit.prevent="onSubmit">
        <field-input id="sign-up-email" title="E-mail" ref="email" type="email"></field-input>
        <field-input id="sign-up-password" title="Password" ref="password" type="password"></field-input>
        <field-input id="sign-up-name" title="Name" ref="name" type="text"></field-input>
        <button id="auth-sign-up-button" class="mdc-button form-button">
            <span class="mdc-button__label">Sign up</span>
        </button>
    </form>
</template>
<script>
    import api from '../../api';
    import cookies from '../../cookies';

    export default {
        mounted() {
            this.$data.button = document.querySelector('#auth-sign-up-button');
        },
        data() {
            return {
                button: null
            };
        },
        methods: {
            onSubmit: function () {
                this.disableButton();
                this.clearErrors();

                api.post('/api/auth/signup', {
                    'email': this.$refs.email.value(),
                    'password': this.$refs.password.value(),
                    'name': this.$refs.name.value(),
                }).then(response => {
                    api.post('/api/auth/signin', {
                        'email': this.$refs.email.value(),
                        'password': this.$refs.password.value(),
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
                this.$data.button.setAttribute('disabled', 'disabled');
            },
            enableButton: function () {
                this.$data.button.removeAttribute('disabled');
            },
            processErrors: function (errors) {
                if (errors.email && errors.email.length > 0) {
                    this.$refs.email.error(errors.email.pop());
                }
                if (errors.password && errors.password.length > 0) {
                    this.$refs.password.error(errors.password.pop());
                }
                if (errors.name && errors.name.length > 0) {
                    this.$refs.name.error(errors.name.pop());
                }
            },
            clearErrors(){
                this.$refs.email.clear();
                this.$refs.password.clear();
                this.$refs.name.clear();
            },
            storeToken: function (token, expiresAt) {
                cookies.set('X-AUTH-TOKEN', token, {expires: new Date((new Date).getTime() + expiresAt * 1000)});
            }
        }
    }
</script>
