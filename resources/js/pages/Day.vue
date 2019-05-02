<template>
    <b-container>
        <b-breadcrumb class="mt-3" :items="breadcrumbs"></b-breadcrumb>
        <h1 class="mt-3">
            Portions
            <b-button to="/days" size="sm">
                <i class="fas fa-arrow-left"></i>
            </b-button>
            <b-button size="sm" variant="primary" @click="toNewDayForm()">
                <i class="fas fa-plus"></i>
            </b-button>
            <b-form-select class="w-auto" size="sm" :options="perPageOptions" v-model="perPage"
                           v-on:change="perPageChanged"/>
        </h1>
        <div v-if="loaded">
            <b-table responsive stacked="sm" no-local-sorting foot-clone no-footer-sorting
                     :items="items"
                     :fields="fields"
                     :sort-by.sync="sortBy" :sort-desc.sync="sortDesc"
                     @sort-changed="sortChanged">
                <template slot="meal" slot-scope="data">
                    <b-link :to="'/portion/'+day.id+'/'+data.item.id">{{ data.item.meal.title}}</b-link>
                    <b-link :to="'/meal/'+data.item.meal.id"><i class="fas fa-link"></i></b-link>
                </template>
                <template slot="eaten" slot-scope="data">
                    <b-form-checkbox v-model="data.item.eaten" :value="true" :unchecked-value="false"
                                     @change="toggleEaten(data.item)"/>
                </template>
                <template slot="FOOT_meal" slot-scope="data">Total</template>
                <template slot="FOOT_weight" slot-scope="data">{{ day.weight }}g</template>
                <template slot="FOOT_time" slot-scope="data">&nbsp;</template>
                <template slot="FOOT_eaten" slot-scope="data">&nbsp;</template>
                <template slot="FOOT_protein" slot-scope="data">{{ day.protein }}g</template>
                <template slot="FOOT_fat" slot-scope="data">{{ day.fat }}g</template>
                <template slot="FOOT_carbohydrates" slot-scope="data">{{ day.carbohydrates }}g</template>
                <template slot="FOOT_fiber" slot-scope="data">{{ day.fiber }}g</template>
            </b-table>
            <div class="pt-2" v-show="lastPage===1"></div>
            <div class="overflow-auto" v-show="lastPage>1">
                <b-pagination-nav class="float-md-left" use-router
                                  :base-url="getItemBaseUrl()"
                                  :number-of-pages="lastPage"
                                  first-text="⇤"
                                  last-text="⇥"
                                  next-text="→"
                                  prev-text="←"
                                  v-model="currentPage"></b-pagination-nav>
            </div>
        </div>

    </b-container>
</template>
<script>
    import Api from '../api';
    import items from '../mixins/items';

    export default {
        mixins: [items],
        data() {
            const dayId = this.$router.currentRoute.params.id;
            return {
                perPage: 10,
                sortDesc: false,
                sortBy: 'time',
                itemsUrl: 'days/' + dayId + '/portions',
                itemUrl: 'portions/',
                fields: [
                    {key: 'meal', label: 'Meal'},
                    {key: 'weight', sortable: true, formatter: this.formatterGramm},
                    {key: 'time', sortable: true},
                    {key: 'eaten', sortable: true,},
                    {key: 'protein', sortable: true, formatter: this.formatterGramm},
                    {key: 'fat', sortable: true, formatter: this.formatterGramm},
                    {key: 'carbohydrates', sortable: true, label: 'Carbs', formatter: this.formatterGramm},
                    {key: 'fiber', sortable: true, formatter: this.formatterGramm},
                ],
                day: {id: dayId, date: null},
                breadcrumbs: [{text: 'Days', to: '/days'}]
            };
        },
        mounted() {
            Api.client().get('days/' + this.day.id).then((response) => {
                this.day = response.data.data;
                this.breadcrumbs.push({text: this.day.title, active: true});
            });
        },
        methods: {
            getItemBaseUrl() {
                return '/day/' + this.day.id + '/';
            },
            toNewDayForm() {
                this.$router.push('/portion/' + this.day.id + '/new');
            },
            toggleEaten(portion) {
                Api.client().patch('/days/' + this.day.id + '/portions/' + portion.id, {
                    eaten: !portion.eaten
                });
            }
        }
    }
</script>