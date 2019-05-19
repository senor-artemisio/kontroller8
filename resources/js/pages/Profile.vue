<template>
    <b-container>
        <b-breadcrumb class="mt-3" :items="breadcrumbs"></b-breadcrumb>
        <h1 class="mt-3">Profile</h1>
        <b-row>
            <b-col md="6">
                <b-form @submit="updateProfile">
                    <b-form-group label="Age" label-for="profile-age" :state="getFieldState('age')"
                                  :invalid-feedback="getFieldError('age')">
                        <b-form-input id="profile-age" type="number" min="18" max="99" v-model="form.age" required
                                      autocomplete="off"/>
                    </b-form-group>
                    <b-form-group label="Weight" label-for="profile-weight" :state="getFieldState('weight')"
                                  :invalid-feedback="getFieldError('weight')">
                        <b-form-input id="profile-weight" type="number" min="30" max="200" v-model="form.weight"
                                      required autocomplete="off"/>
                    </b-form-group>
                    <b-form-group label="Height" label-for="profile-height" :state="getFieldState('height')"
                                  :invalid-feedback="getFieldError('height')">
                        <b-form-input id="profile-height" type="number" min="100" max="250" v-model="form.height"
                                      required autocomplete="off"/>
                    </b-form-group>
                    <b-form-group label="Gender" label-for="portion-gender" :state="getFieldState('gender')"
                                  :invalid-feedback="getFieldError('gender')">
                        <b-form-select v-model="form.gender" :options="genderOptions"></b-form-select>
                    </b-form-group>
                    <b-form-group label="Modifier" label-for="profile-modifier" :state="getFieldState('modifier')"
                                  :invalid-feedback="getFieldError('modifier')">
                        <b-form-input id="profile-modifier" type="number" step="0.01" v-model="form.modifier" required
                                      autocomplete="off"/>
                    </b-form-group>
                    <b-form-group label="Activity 1,2 / 1,375 / 1,55 / 1,725" label-for="profile-activity"
                                  :state="getFieldState('activity')"
                                  :invalid-feedback="getFieldError('activity')">
                        <b-form-input id="profile-activity" type="number" step="any" v-model="form.activity" required
                                      autocomplete="off"/>
                    </b-form-group>
                    <b-form-group>
                        <b-button size="lg" variant="primary" :disabled="buttonDisabled" type="submit">
                            Update
                        </b-button>
                        <b-button :to="backUrl" size="lg">Cancel</b-button>
                    </b-form-group>
                </b-form>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
    import form from '../mixins/form';
    import Api from '../api';

    export default {
        mixins: [form],
        data() {
            return {
                backUrl: '/dashboard',
                form: {
                    user_id: null,
                    age: null,
                    weight: null,
                    height: null,
                    gender: null,
                    modifier: null,
                    activity: null
                },
                breadcrumbs: [{text: 'Profile', active: true}],
                genderOptions: [
                    {value: true, text: 'Male'},
                    {value: false, text: 'Female'},
                ],
                calories: 0
            }
        },
        mounted() {
            this.$store.dispatch('user').then(() => {
                this.formUrl = 'profiles/' + this.$store.getters.user.id;

                Api.client().get(this.formUrl).then((response) => {
                    const data = response.data.data;
                    this.form.user_id = data.user_id;
                    this.form.age = data.age;
                    this.form.weight = data.weight;
                    this.form.height = data.height;
                    this.form.gender = data.gender;
                    this.form.modifier = data.modifier;
                    this.form.activity = data.activity;
                    this.calories = data.calories;
                });
            });
        },
        methods: {
            updateProfile(evt) {
                evt.preventDefault();
                let data = Object.assign({}, this.form);
                delete data['user_id'];

                return Api.client().patch(this.formUrl, data).then(() => {
                    this.errors = {};
                    this.$router.push(this.backUrl);
                }).catch(this.processError);
            }
        }
    };
</script>