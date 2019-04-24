<template>
    <b-container>
        <h1 class="mt-3">
            <small>{{day.date}}</small>
            <b-button to="/days" size="sm">
                <i class="fas fa-arrow-left"></i>
            </b-button>
            <b-button size="sm" variant="primary">
                <i class="fas fa-plus"></i>
            </b-button>
            <b-form-select class="w-auto" size="sm" :options="perPageOptions" v-model="perPage"
                           v-on:change="perPageChanged"/>
        </h1>
        <div v-if="loaded">
            <b-table responsive stacked="sm" hover tbody-tr-class="cursor-pointer" :no-local-sorting="true"
                     :items="items"
                     :fields="fields"
                     :sort-by.sync="sortBy" :sort-desc.sync="sortDesc"
                     @sort-changed="sortChanged"
                     @row-clicked="toItem">
                <template slot="meal" slot-scope="data">
                    <b-link :to="'/meal/'+data.item.meal.id">{{ data.item.meal.title }}</b-link>
                </template>
            </b-table>
            <div class="overflow-auto">
                <b-pagination-nav class="float-md-left" use-router
                                  :base-url="getItemUrl()"
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
                fields: [
                    {
                        key: 'meal',
                        label: 'Meal',
                        sortable: true,
                    },
                    {
                        key: 'weight',
                        sortable: true
                    },
                    {
                        key: 'time',
                        sortable: true
                    },
                    {
                        key: 'eaten',
                        sortable: true,
                        formatter: (value) => {
                            return value ? 'yes' : 'no';
                        }
                    },
                    {
                        key: 'protein'
                    },
                    {
                        key: 'fat'
                    },
                    {
                        key: 'carbohydrates',
                        label: 'Carbs'
                    },
                    {
                        key: 'fiber'
                    },
                ],
                day: {
                    id: dayId,
                    date: null
                },
            };
        },
        mounted() {
            Api.client().get('days/' + this.day.id).then((response) => {
                this.day = response.data.data;
            });
        },
        methods: {
            getItemUrl() {
                return '/day/' + this.day.id + '/';
            }
        }
    }
</script>