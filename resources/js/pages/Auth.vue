<template>
    <b-row align-v="center" class="h-100">
        <b-col cols="4" offset-md="4" align="center">
            <b-form @submit="onSubmit" class="mr-auto ml-auto mt-2 w-100">
                <b-card>
                    <div class="logo-k8 dark on-white mt-3 mb-3" style="transform: scale(2)">
                        <span class="k k1"></span>
                        <span class="k k2"></span>
                        <span class="k k3"></span>
                        <span class="k k4"></span>
                        <span class="k k5"></span>
                        <span class="k k6"></span>
                        <span class="k k7"></span>
                        <span class="k k8"></span>
                        <span class="k k9"></span>
                        <span class="k k10"></span>
                    </div>
                    <h1 class="h3 mb-3 font-weight-normal" v-if="register">Join Kontroller8</h1>
                    <h1 class="h3 mb-3 font-weight-normal" v-else>Sign in to Kontroller8</h1>
                    <b-form-group id="login-group-name" v-if="register">
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
                    <b-form-group id="login-group-password-repeat" v-if="register">
                        <b-form-input id="login-repeat-password" type="password" required
                                      placeholder="Repeat password"
                                      v-model="form.passwordRepeat"/>
                    </b-form-group>
                    <button v-if="register" class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
                    <button v-else class="btn btn-lg btn-primary btn-block" type="submit" :disabled="buttonDisabled">
                        Sign in
                    </button>
                </b-card>

                <div class="mt-3" v-if="register">
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
</template>

<script>
    import Api from '../api';
    import Cookies from 'js-cookie';

    export default {
        data: function () {
            return {
                register: false,
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
                this.login();
            },
            toggleRegister() {
                this.register = !this.register;

                return false;
            },
            login() {
                const component = this;
                Api.post('/auth/sign-in', {
                    email: this.form.email,
                    password: this.form.password
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
                            Cookies.set('X-AUTH-TOKEN', token, {expires: 7}); // todo read expires from expiresAt
                            component.$router.push({name: "dashboard"});
                        }
                    }
                    console.error(response);
                }).catch(error => {
                    component.buttonDisabled = false;

                    if (error.response && error.response.data) {
                        if (error.response.status === 422) {
                            component.errors = error.response.data.errors;
                            console.log(component.errors.email);
                            return;
                        }
                        return console.error(error.response);

                    }
                    console.error(error);
                });
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
            }
        }
    }
</script>
