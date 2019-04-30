<template>
    <b-container>
        <h1 class="mt-3">
            Meals
            <b-button size="sm" variant="primary" to="/meal/new">
                <i class="fas fa-plus"></i>
            </b-button>
            <b-form-select class="w-auto" size="sm" :options="perPageOptions" v-model="perPage"
                           v-on:change="perPageChanged"/>
        </h1>
        <div v-if="loaded">
            <b-table responsive stacked="sm" @sort-changed="sortChanged"
                     :no-local-sorting="true" :items="items" :fields="fields"
                     :sort-by.sync="sortBy" :sort-desc.sync="sortDesc">
                <template slot="title" slot-scope="data">
                    <b-link :to="'/meal/'+data.item.id">{{ data.item.title }}</b-link>
                </template>
            </b-table>
            <div class="overflow-auto">
                <b-pagination-nav class="float-md-left" use-router
                                  base-url="/meals/"
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
    import items from '../mixins/items';

    export default {
        mixins: [items],
        data() {
            return {
                itemsUrl: 'meals',
                itemUrl: 'meal',
                perPage: 10,
                sortBy: 'title',
                sortDesc: false,
                fields: [
                    {key: 'title', sortable: true},
                    {key: 'calories', sortable: true, label: 'kCal'},
                    {key: 'protein', sortable: true, formatter: this.formatterGramm},
                    {key: 'fat', sortable: true, formatter: this.formatterGramm},
                    {key: 'carbohydrates', sortable: true, formatter: this.formatterGramm, label: 'Carbs',},
                    {key: 'fiber', sortable: true, formatter: this.formatterGramm}
                ],
            };
        },
    }
</script>
