<template>
    <b-container>
        <b-table responsive striped hover :no-local-sorting="true"
                 :items="items"
                 :fields="fields"
                 @sort-changed="sortChanged"/>
        <div class="overflow-auto">
            <b-pagination-nav id="items-pagination" use-router no-page-detect ref="pagination" base-url="/items/"
                              :number-of-pages="lastPage"
                              v-model="currentPage"
            />
        </div>
    </b-container>
</template>
<script>
    import Api from '../api';

    export default {
        data() {
            return {
                currentPage: this.$router.currentRoute.params.page,
                lastPage: 999,
                sortBy: null,
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
                    'fat',
                    'carbohydrates',
                    'fiber'
                ]
            };
        },
        methods: {
            sortChanged(ctx) {
                this.sortBy = ctx.sortBy;
            },
            getPageLink(pageNumber) {
                return '/items/' + pageNumber;
            },
            load() {
                Api.client().get('items?page=' + this.currentPage).then((response) => {
                    const result = response.data;
                    this.items = result.data;
                    this.lastPage = result.meta.last_page;
                    this.perPage = result.meta.per_page
                    // dirty hack because b-pagination component does not switch current page correctly
                    if (this.currentPage != 1) {
                        this.$refs.pagination.currentPage = this.currentPage;
                    }
                });
            }
        },
        mounted() {
            this.load();
        },
        watch: {
            '$route.params.page'(to, from) {
                this.currentPage = to;
                this.load();
            }
        }
    }
</script>
