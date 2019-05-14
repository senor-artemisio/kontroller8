<template>
    <b-container>
        <b-breadcrumb class="mt-3" :items="breadcrumbs"></b-breadcrumb>
        <h1 class="mt-3">Profile</h1>
        <b-row>
            <b-col md="6">
                <b-form>
                    <b-form-group label="Age" label-for="meal-protein" :state="getFieldState('age')"
                                  :invalid-feedback="getFieldError('age')">
                        <b-form-input id="meal-protein" type="number" min="18" max="99" v-model="form.age" required/>
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
                formUrl: 'profile',
                backUrl: '/profile',
                form: {
                    user_id: null,
                    age: null,
                    weight: null,
                    height: null,
                    gender: null,
                    modifier: null,
                    activity: null,
                    calories: null
                },
                breadcrumbs: [{text: 'Profile', active: true}]
            }
        },
        mounted() {
            Api.client().get(this.formUrl)
        }
    };
</script>