<template>
    <b-container>
        <h1 class="mt-3">
            Items
            <b-button size="sm" variant="primary" to="/item/new">
                <i class="fas fa-plus"></i>
            </b-button>
        </h1>
        <div v-if="loaded">
            <b-table responsive stacked="sm" hover tbody-tr-class="cursor-pointer" :no-local-sorting="true"
                     :items="items"
                     :fields="fields"
                     :sort-by.sync="sortBy" :sort-desc.sync="sortDesc"
                     @sort-changed="sortChanged"
                     @row-clicked="toItem"/>
            <div class="overflow-auto">
                <b-pagination-nav class="float-md-left" use-router
                                  base-url="/items/"
                                  :number-of-pages="lastPage"
                                  first-text="⇤"
                                  last-text="⇥"
                                  next-text="→"
                                  prev-text="←"
                                  v-model="currentPage"></b-pagination-nav>
                <b-form-select class="float-md-right w-auto mb-3" size="sm" :options="perPageOptions" v-model="perPage"
                               v-on:change="perPageChanged"/>
            </div>
        </div>
    </b-container>
</template>
<script>
    import Api from '../api';

    export default {
        data() {
            return {
                currentPage: parseInt(this.$router.currentRoute.params.page),
                lastPage: null,
                perPage: 10,
                perPageOptions: [2, 5, 10, 20, 50],
                sortBy: 'title',
                sortDesc: false,
                items: [],
                fields: [
                    {
                        key: 'title',
                        sortable: true
                    },
                    {
                        key: 'protein',
                        sortable: true
                    },
                    {
                        key: 'fat',
                        sortable: true
                    },
                    {
                        key: 'carbohydrates',
                        sortable: true
                    },
                    {
                        key: 'fiber',
                        sortable: true
                    }
                ],
                loaded: false
            };
        },
        methods: {
            toItem(item, index, button) {
                this.$router.push('/item/' + item.id);
            },
            sortChanged(ctx) {
                this.sortBy = ctx.sortBy;
                this.sortDesc = ctx.sortDesc;
                this.load();
            },
            perPageChanged() {
                this.currentPage = 1;
                this.load();
            },
            load() {
                Api.client().get(this.buildApiUrl()).then((response) => {
                    const result = response.data;
                    this.items = result.data;
                    this.lastPage = parseInt(result.meta.last_page);
                    this.perPage = parseInt(result.meta.per_page);
                    if (this.currentPage > this.lastPage) {
                        this.$router.push('/items/' + this.lastPage);
                    }
                    this.loaded = true;
                });
            },
            buildApiUrl() {
                let url = '';

                url += 'items?page=' + this.currentPage;
                url += '&perPage=' + this.perPage;
                url += '&sortBy=' + this.sortBy;
                url += '&sortDirection=' + (this.sortDesc ? 'desc' : 'asc');

                return url;
            }
        },
        mounted() {
            this.load();
        },
        watch: {
            '$route.params.page'(to, from) {
                this.load();
            }
        }
    }
</script>
