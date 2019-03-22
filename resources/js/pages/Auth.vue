<template>
    <b-container class="h-100">
        <b-row align-v="center" class="h-100">
            <b-col md="4" offset-md="4" align="center">
                <b-form @submit="onSubmit" class="mr-auto ml-auto mt-2 w-100">
                    <b-card>
                        <logo size="2" css-class="dark on-white mt-3 mb-3"></logo>

                        <h1 class="h3 mb-3 font-weight-normal" v-if="isRegister">Join Kontroller8</h1>
                        <h1 class="h3 mb-3 font-weight-normal" v-else>Sign in to Kontroller8</h1>

                        <b-form-group id="login-group-name" v-if="isRegister">
                            <b-form-input type="text" id="login-name" required placeholder="Name"
                                          v-model="form.name"/>
                        </b-form-group>
                        <b-form-group id="login-group-email"
                                      :state="getFieldState('email')"
                                      :invalid-feedback="getFieldError('email')">
                            <b-form-input id="login-email" type="email" required placeholder="E-mail"
                                          v-model="form.email"
                                          :state="getFieldState('email')"/>
                        </b-form-group>
                        <b-form-group id="login-group-password"
                                      :state="getFieldState('password')"
                                      :invalid-feedback="getFieldError('password')">
                            <b-form-input id="login-password" type="password" required placeholder="Password"
                                          v-model="form.password"
                                          :state="getFieldState('password')"/>
                        </b-form-group>
                        <b-form-group id="login-group-password-repeat" v-if="isRegister">
                            <b-form-input id="login-repeat-password" type="password" required
                                          placeholder="Repeat password"
                                          v-model="form.passwordRepeat"/>
                        </b-form-group>

                        <button v-if="isRegister" class="btn btn-lg btn-primary btn-block" type="submit">Sign up
                        </button>
                        <button v-else class="btn btn-lg btn-primary btn-block" type="submit"
                                :disabled="buttonDisabled">
                            Sign in
                        </button>
                    </b-card>

                    <div class="mt-3" v-if="isRegister">
                        Already have an account?
                        <b-link href="#" v-on:click="toggleRegister">Sign in.</b-link>
                    </div>
                    <div class="mt-3" v-else>
                        New to Kontroller8?
                        <b-link href="#" v-on:click="toggleRegister">Create an account.</b-link>
                    </div>
                </b-form>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import Api from '../api';

    export default {
        data: function () {
            return {
                isRegister: false,
                form: {
                    name: '',
                    email: '',
                    password: '',
                    passwordRepeat: '',
                },
                errors: {},
                buttonDisabled: false
            };
        },
        methods: {
            onSubmit(evt) {
                evt.preventDefault();
                this.buttonDisabled = true;
                if (this.isRegister) {
                    this.register();
                } else {
                    this.login();
                }
            },
            toggleRegister() {
                this.isRegister = !this.isRegister;

                return false;
            },
            register() {
                Api.client().post('/auth/sign-up', {
                    name: this.form.name,
                    email: this.form.email,
                    password: this.form.password,
                    password_confirmation: this.form.passwordRepeat
                }).then(response => {
                    const data = response.data.data;
                    if (data.id) {
                        this.login();
                    } else {
                        this.buttonDisabled = false;
                        throw response;
                    }
                }).catch(this.processError);
            },
            login() {
                Api.client().post('auth/sign-in', {
                    email: this.form.email,
                    password: this.form.password
                }).then(response => {
                    let token = null;
                    let options = {};
                    if (response.data) {
                        if (response.data.data.access_token) {
                            token = response.data.data.access_token;
                        }
                        if (response.data.data.expires_at) {
                            options.expires = response.data.data.expires_at;
                        }
                        if (token) {
                            this.$store.commit('token', token);
                            location.href = '/dashboard';
                        } else {
                            throw 'token not found';
                        }
                    } else {
                        this.buttonDisabled = false;
                        throw response;
                    }
                }).catch(this.processError);
            },
            getFieldState(field) {
                if (this.errors[field] && this.errors[field].length > 0) {
                    return false;
                }
                return null;
            },
            getFieldError(field) {
                if (this.errors[field] && this.errors[field].length > 0) {
                    return this.errors[field].join('<br>');
                }
                return null;
            },
            processError(error) {
                this.buttonDisabled = false;

                if (error.response && error.response.data) {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                        return;
                    }
                    return console.error(error.response);

                }
                console.error(error);
            }
        }
    }
</script>
