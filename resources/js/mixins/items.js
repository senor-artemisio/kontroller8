import Api from '../api';

export default {
    data() {
        return {
            currentPage: null,
            lastPage: null,
            perPage: 5,
            perPageOptions: [1, 2, 5, 10, 20, 50],
            sortBy: null,
            sortDesc: true,
            items: [],
            loaded: false,
            itemsUrl: null,
            itemUrl: null,
        }
    },
    methods: {
        /**
         * Sort attribute or direction change handler
         * @param ctx
         */
        sortChanged(ctx) {
            this.sortBy = ctx.sortBy;
            this.sortDesc = ctx.sortDesc;
            this.load();
        },
        /**
         * Per page change handler
         */
        perPageChanged() {
            this.currentPage = 1;
            this.load();
        },
        /**
         * Load items from API
         */
        load() {
            Api.client().get(this.buildApiUrl()).then((response) => {
                const result = response.data;
                this.items = result.data;
                this.lastPage = parseInt(result.meta.last_page);
                this.perPage = parseInt(result.meta.per_page);
                if (this.currentPage > this.lastPage) {
                    this.$router.push('/' + this.itemsUrl + '/' + this.lastPage);
                }
                this.loaded = true;
            });
        },
        /**
         * Build API url for load items
         * @returns {string}
         */
        buildApiUrl() {
            let url = '';

            url += this.itemsUrl + '?page=' + this.currentPage;
            url += '&perPage=' + this.perPage;
            url += '&sortBy=' + this.sortBy;
            url += '&sortDirection=' + (this.sortDesc ? 'desc' : 'asc');

            return url;
        },
        /**
         * Route to item page
         * @param item
         * @param index
         * @param button
         */
        toItem(item, index, button) {
            this.$router.push('/' + this.itemUrl + '/' + item.id);
        },
    },
    mounted() {
        if (this.currentPage === null) {
            this.currentPage = parseInt(this.$router.currentRoute.params.page);
        }
        this.load();
    },
    watch: {
        '$route.params.page'(to) {
            // noinspection JSUnusedGlobalSymbols
            this.currentPage = to;
            this.load();
        }
    }
}