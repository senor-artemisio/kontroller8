<template>
    <b-container>
        <b-breadcrumb class="mt-3" :items="breadcrumbs"></b-breadcrumb>
        <h1 class="mt-3">Portion</h1>
        <b-row>
            <b-col md="6">
                <b-form @submit="onSubmit">
                    <b-form-group label="Weight" label-for="portion-weight" :state="getFieldState('weight')"
                                  :invalid-feedback="getFieldError('weight')">
                        <b-form-input id="portion-weight" type="number" v-model="form.weight" required min="0"
                                      step="1" autocomplete="off"/>
                    </b-form-group>
                    <b-form-group label="Time" label-for="portion-time" :state="getFieldState('time')"
                                  :invalid-feedback="getFieldError('time')">
                        <b-form-input id="portion-time" type="text" v-model="form.time" required autocomplete="off"/>
                    </b-form-group>
                    <b-form-group label="Eaten" label-for="portion-eaten" :state="getFieldState('eaten')"
                                  :invalid-feedback="getFieldError('eaten')">
                        <b-form-select v-model="form.eaten" :options="eatenOptions"></b-form-select>
                    </b-form-group>
                    <b-form-group label="Meal" label-for="portion-meal-id" :state="getFieldState('meal_id')"
                                  :invalid-feedback="getFieldError('meal_id')">
                        <b-form-input id="portion-meal" type="text" v-model="mealTitle" required autocomplete="off"/>
                        <input id="portion-meal-id" type="hidden" v-model="form.meal_id"/>
                    </b-form-group>
                    <b-form-group>
                        <b-button v-if="isNew()" variant="primary" size="lg" :disabled="buttonDisabled" type="submit">
                            Create
                        </b-button>
                        <b-button v-else size="lg" variant="primary" :disabled="buttonDisabled" type="submit">
                            Update
                        </b-button>
                        <b-button :to="backUrl" size="lg">Cancel</b-button>
                        <b-button variant="danger" size="lg" v-if="!isNew()" @click="remove">Delete</b-button>
                    </b-form-group>
                </b-form>
            </b-col>
        </b-row>
    </b-container>
</template>
<script>
    import form from '../mixins/form';
    import Api from '../api';
    import 'jquery-ui/ui/widgets/autocomplete.js';

    export default {
        mixins: [form],
        data() {
            return {
                dayId: null,
                mealTitle: null,
                form: {
                    id: this.$router.currentRoute.params.id,
                    weight: null,
                    eaten: false,
                    time: null,
                    meal_id: null,
                },
                breadcrumbs: [{text: 'Days', to: '/days'}],
                eatenOptions: [
                    {value: false, text: 'No'},
                    {value: true, text: 'Yes'},
                ]
            }
        },
        mounted() {
            const client = Api.client(), component = this;

            this.dayId = this.$router.currentRoute.params.dayId;
            this.formUrl = 'days/' + this.dayId + '/portions';
            this.backUrl = '/day/' + this.dayId + '/1';

            client.get('days/' + this.dayId).then((response) => {
                const day = response.data.data;
                this.breadcrumbs.push({
                    text: day.title,
                    to: '/day/' + day.id + '/1'
                });
            }).then(() => {
                if (this.form.id === 'new') {
                    this.breadcrumbs.push({text: 'Create', active: true});
                    return;
                }
                return client.get('/' + this.formUrl + '/' + this.form.id).then((response) => {
                    const data = response.data.data;
                    this.breadcrumbs.push({text: data.meal.title, active: true});
                    this.form.weight = data.weight;
                    this.form.time = data.time;
                    this.form.eaten = data.eaten;
                    this.form.meal_id = data.meal.id;
                    this.mealTitle = data.meal.title;
                });
            }).then(() => {
                $('#portion-meal').autocomplete({
                    minLength: 3,
                    focus: function (event, ui) {
                        component.mealTitle = ui.item.title;
                        return false;
                    },
                    select: function (event, ui) {
                        component.mealTitle = ui.item.title;
                        component.form.meal_id = ui.item.id;
                        return false;
                    },
                    source: (sourceRequest, sourceResponse) => {
                        client.get('meals?title=' + sourceRequest.term +
                            '&perPage=5&page=1&sortBy=title&sortDirection=asc')
                            .then((response) => {
                                sourceResponse(response.data.data)
                            });
                    },
                }).autocomplete("instance")._renderItem = function (ul, item) {
                    return $("<li>")
                        .append('<div>' + item.title + '<br>'
                            + item.protein + 'g / '
                            + item.fat + 'g / '
                            + item.carbohydrates + 'g'
                            + '</div>')
                        .appendTo(ul);
                };
            });
        }
    };
</script>