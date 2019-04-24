<template>
    <b-container>
        <b-row>
            <b-col md="6">
                <b-form @submit="onSubmit">
                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4">
                        <h2 class="mt-3" v-if="isNew()">New meal</h2>
                        <h2 class="mt-3" v-else>Meal {{form.title}}</h2>
                    </b-form-group>
                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4" label="Title"
                                  label-for="meal-title"
                                  :state="getFieldState('title')"
                                  :invalid-feedback="getFieldError('title')">
                        <b-form-input id="meal-title" type="text" v-model="form.title" required/>
                    </b-form-group>

                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4" label="Protein"
                                  label-for="meal-protein"
                                  :state="getFieldState('protein')"
                                  :invalid-feedback="getFieldError('protein')">
                        <b-form-input id="meal-protein" type="number" min="0" max="100" step="0.1"
                                      v-model="form.protein"
                                      required/>
                    </b-form-group>

                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4" label="Fat" label-for="meal-fat"
                                  :state="getFieldState('fat')"
                                  :invalid-feedback="getFieldError('fat')">
                        <b-form-input id="meal-fat" type="number" min="0" max="100" step="0.1" v-model="form.fat"
                                      required/>
                    </b-form-group>

                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4" label="Carbohydrates"
                                  label-for="meal-carbohydrates"
                                  :state="getFieldState('carbohydrates')"
                                  :invalid-feedback="getFieldError('carbohydrates')">
                        <b-form-input id="meal-carbohydrates" type="number" min="0" max="100" step="0.1"
                                      v-model="form.carbohydrates" required/>
                    </b-form-group>

                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4" label="Fiber"
                                  label-for="meal-fiber"
                                  :state="getFieldState('fiber')"
                                  :invalid-feedback="getFieldError('fiber')">
                        <b-form-input id="meal-fiber" type="number" min="0" max="100" step="0.1"
                                      v-model="form.fiber" required/>
                    </b-form-group>

                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4">
                        <b-button v-if="isNew()" variant="primary" size="lg" :disabled="buttonDisabled" type="submit">
                            Create
                        </b-button>
                        <b-button v-else size="lg" variant="primary" :disabled="buttonDisabled" type="submit">
                            Update
                        </b-button>
                        <b-button to="/meals" size="lg">Back</b-button>
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
                formUrl: 'meals',
                form: {
                    id: this.$router.currentRoute.params.id,
                    protein: null,
                    fat: null,
                    carbohydrates: null,
                    fiber: null
                },
                breadcrumbs: [
                    {
                        text: 'Meals',
                        href: '/meals'
                    }
                ]
            }
        },
        mounted() {
            if (this.form.id === 'new') {
                return;
            }
            Api.client().get('/' + this.formUrl + '/' + this.form.id).then((response) => {
                const data = response.data.data;
                this.form.title = data.title;
                this.form.protein = data.protein;
                this.form.fat = data.fat;
                this.form.carbohydrates = data.carbohydrates;
                this.form.fiber = data.fiber;
            });
        }
    }
</script>