<template>
    <b-container>
        <b-breadcrumb class="mt-3" :items="breadcrumbs"></b-breadcrumb>
        <h2 class="mt-3">
            Portions
            <b-button to="/days" size="sm">
                <i class="fas fa-arrow-left"></i>
            </b-button>
            <b-button size="sm" variant="primary">
                <i class="fas fa-plus"></i>
            </b-button>
            <b-form-select class="w-auto" size="sm" :options="perPageOptions" v-model="perPage"
                           v-on:change="perPageChanged"/>
        </h2>
        <div v-if="loaded">
            <b-table responsive stacked="sm" hover no-local-sorting foot-clone no-footer-sorting
                     tbody-tr-class="cursor-pointer"
                     tfoot-class="tfoot-hide-sort"
                     :items="items"
                     :fields="fields"
                     :sort-by.sync="sortBy" :sort-desc.sync="sortDesc"
                     @sort-changed="sortChanged"
                     @row-clicked="toItem">
                <template slot="meal" slot-scope="data">
                    <b-link :to="'/meal/'+data.item.meal.id">{{ data.item.meal.title }}</b-link>
                </template>
                <template slot="FOOT_meal" slot-scope="data">Total</template>
                <template slot="FOOT_weight" slot-scope="data">{{ day.weight }}</template>
                <template slot="FOOT_time" slot-scope="data">&nbsp;</template>
                <template slot="FOOT_eaten" slot-scope="data">&nbsp;</template>
                <template slot="FOOT_protein" slot-scope="data">{{ day.protein }}</template>
                <template slot="FOOT_fat" slot-scope="data">{{ day.fat }}</template>
                <template slot="FOOT_carbohydrates" slot-scope="data">{{ day.carbohydrates }}</template>
                <template slot="FOOT_fiber" slot-scope="data">{{ day.fiber }}</template>
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
                perPage: 5,
                sortDesc: false,
                sortBy: 'time',
                itemsUrl: 'days/' + dayId + '/portions',
                itemUrl: 'portions/',
                fields: [
                    {key: 'meal', label: 'Meal'},
                    {key: 'weight', sortable: true},
                    {key: 'time', sortable: true},
                    {
                        key: 'eaten',
                        sortable: true,
                        formatter: (value) => {
                            return value ? 'yes' : 'no';
                        }
                    },
                    {key: 'protein', sortable: true},
                    {key: 'fat', sortable: true},
                    {key: 'carbohydrates', sortable: true},
                    {key: 'fiber', sortable: true},
                ],
                day: {id: dayId, date: null},
                breadcrumbs: [{text: 'Days', href: '/days'}]
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
            }
        }
    }
</script>