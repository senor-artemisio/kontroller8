<template>
    <b-container>
        <b-breadcrumb class="mt-3" :items="breadcrumbs"></b-breadcrumb>
        <b-row>
            <b-col md="6">
                <b-form @submit="onSubmit">
                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4" label="Weight"
                                  label-for="portion-weight"
                                  :state="getFieldState('weight')"
                                  :invalid-feedback="getFieldError('weight')">
                        <b-form-input id="portion-weight" type="number" v-model="form.weight" required min="0"
                                      step="1"/>
                    </b-form-group>
                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4" label="Time"
                                  label-for="portion-time" :state="getFieldState('time')"
                                  :invalid-feedback="getFieldError('time')">
                        <b-form-input id="portion-time" type="text" v-model="form.time" required autocomplete="off"/>
                    </b-form-group>
                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4" label="Eaten"
                                  label-for="portion-eaten" :state="getFieldState('eaten')"
                                  :invalid-feedback="getFieldError('eaten')">
                        <b-form-checkbox id="portion-eaten" v-model="form.eaten" :value="true"
                                         :unchecked-value="false"/>
                    </b-form-group>
                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4" label="Meal"
                                  label-for="portion-meal-id" :state="getFieldState('meal_id')"
                                  :invalid-feedback="getFieldError('meal_id')">
                        <b-form-input id="portion-meal-id" type="text" v-model="form.meal_id" required/>
                    </b-form-group>
                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4">
                        <b-button v-if="isNew()" variant="primary" size="lg" :disabled="buttonDisabled" type="submit">
                            Create
                        </b-button>
                        <b-button v-else size="lg" variant="primary" :disabled="buttonDisabled" type="submit">
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
                dayId: null,
                form: {
                    id: this.$router.currentRoute.params.id,
                    weight: null,
                    eaten: null,
                    time: null,
                    meal_id: null,
                },
                breadcrumbs: [{text: 'Days', href: '/days'}]
            }
        },
        mounted() {
            this.dayId = this.$router.currentRoute.params.dayId;
            this.formUrl = 'days/' + this.dayId + '/portions';
            this.backUrl = '/day/' + this.dayId + '/1';
            if (this.form.id === 'new') {
                this.breadcrumbs.push({text: 'Create', active: true});
                return;
            }
            Api.client().get('/' + this.formUrl + '/' + this.form.id).then((response) => {
                const data = response.data.data;
                this.breadcrumbs.push({text: data.day.title, href: '/day/' + data.day.id + '/1'});
                this.breadcrumbs.push({text: data.meal.title, active: true});
                this.form.weight = data.weight;
                this.form.time = data.time;
                this.form.eaten = data.eaten;
                this.form.meal_id = data.meal.id;

                // this.form.protein = data.protein;
                // this.form.fat = data.fat;
                // this.form.carbohydrates = data.carbohydrates;
                // this.form.fiber = data.fiber;
            });
        }
    };
</script>