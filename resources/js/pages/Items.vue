<template>
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <h1 class="mdc-typography--subtitle1">
                    Items
                    <router-link to="/item" class="mdc-fab mdc-fab--mini text-decoration-none"
                                 aria-label="Favorite" aria-hidden="true">
                        <span class="mdc-fab__icon material-icons">add</span>
                    </router-link>
                </h1>
                <ul v-if="items.length > 0"
                    class="entities-list mdc-list mdc-list--two-line mdc-list--avatar-list">
                    <li class="mdc-list-item mdc-ripple-upgraded" v-for="(item, index) in items" aria-hidden="true"
                        v-on:click="routeToItem(item)">

                        <span v-if="item.type === 'protein'" class="mdc-list-item__graphic material-icons"
                              aria-hidden="true">share</span>
                        <span v-else-if="item.type === 'fat'" class="mdc-list-item__graphic material-icons"
                              aria-hidden="true">bubble_chart</span>
                        <span v-else-if="item.type === 'carbohydrates'" class="mdc-list-item__graphic material-icons"
                              aria-hidden="true">flash_on</span>
                        <span v-else class="mdc-list-item__graphic material-icons" aria-hidden="true">group_work</span>

                        <span class="mdc-list-item__text">
                            <span class="mdc-list-item__primary-text">{{ item.title }}</span>
                            <span class="mdc-list-item__secondary-text">
                                {{ item.protein }}g / {{ item.fat }}g / {{ item.carbohydrates }}g
                            </span>
                        </span>
                        <span class="mdc-list-item__meta" aria-hidden="true">
                            <span class="material-icons">info</span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-12">
                <button v-for="page in getPages()"
                        class="mdc-button mdc-button--raised page-button" :disabled="page.current"
                        v-on:click="routeToPage(page.number)">
                    {{ page.number }}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import api from '../api';

    export default {
        props: {
            page: {
                type: Number,
                default: 1
            },
            limit: {
                type: Number,
                default: 10
            }
        },
        data: function () {
            return {
                items: [],
                meta: {}
            };
        },
        mounted() {
            this.loadData();
        },
        methods: {
            routeToItem(item) {
                this.$router.push({name: 'item', params: {itemId: item.id}});
            },
            getPages() {
                let pages = [];
                for (let i = 1; i <= this.meta.last_page; i++) {
                    pages.push({number: i, current: this.meta.current_page === i});
                }

                return pages.length > 1 ? pages : [];
            },
            routeToPage(number) {
                this.$router.push({name: 'items', params: {page: number}});
                this.loadData();
            },
            loadData() {
                const component = this;
                let page = this.$router.currentRoute.params.page;
                if (!page) {
                    page = 1;
                }
                api.get('/api/items?page=' + page).then(function (response) {
                    if (response.data && response.data.data) {
                        component.items = response.data.data;
                        component.meta = response.data.meta;
                    }
                });
            }
        }
    }
</script>