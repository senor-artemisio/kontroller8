<template>
    <form id="auth-sign-in" v-on:submit.prevent="onSubmit">
        <text-field id="sign-in-email" title="E-mail" ref="email" type="text"></text-field>
        <text-field id="sign-in-password" title="Password" ref="password" type="password"></text-field>
        <button id="auth-sign-in-button" class="mdc-button">
            <span class="mdc-button__label">Sign in</span>
        </button>
    </form>
</template>
<script>
    import api from '../../api';
    import cookies from '../../cookies';

    export default {
        mounted() {
            this.$data.button = document.querySelector('#auth-sign-in-button');
        },
        data() {
            return {
                button: null
            }
        },
        methods: {
            onSubmit() {
                this.disableButton();
                this.clearErrors();

                api.post('/api/auth/signin', {
                    'email': this.$refs.email.value(),
                    'password': this.$refs.password.value()
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
                        if (token && expiresAt) {
                            this.storeToken(token, expiresAt);
                            location.href = '/';
                        }
                    }
                    console.error(error);
                }).catch(error => {
                    if (error.response) {
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
                });

                this.enableButton();
            },
            processErrors(errors) {
                if (errors.email && errors.email.length > 0) {
                    this.$refs.email.error(errors.email.pop());
                }
                if (errors.password && errors.password.length > 0) {
                    this.$refs.password.error(errors.password.pop());
                }
            },
            clearErrors(){
                this.$refs.email.clear();
                this.$refs.password.clear();
            },
            storeToken(token, expiresAt) {
                cookies.set('X-AUTH-TOKEN', token, {expires: new Date((new Date).getTime() + expiresAt * 1000)});
            },
            disableButton() {
                this.$data.button.setAttribute('disabled', 'disabled');
            },
            enableButton() {
                this.$data.button.removeAttribute('disabled');
            }
        }
    }
</script>