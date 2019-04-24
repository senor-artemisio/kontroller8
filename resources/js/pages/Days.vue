<template xmlns="http://www.w3.org/1999/html">
    <b-container>
        <h1 class="mt-3">
            Days
            <b-button size="sm" variant="primary" v-on:click="showDatepicker">
                <i class="fas fa-calendar"></i>
            </b-button>
            <b-form-select class="w-auto" size="sm" :options="perPageOptions" v-model="perPage"
                           v-on:change="perPageChanged"/>
        </h1>
        <div class="d-none">
            <b-form-input id="day-date"/>
        </div>
        <div v-if="loaded">
            <b-table responsive stacked="sm" hover tbody-tr-class="cursor-pointer" :no-local-sorting="true"
                     :items="items"
                     :fields="fields"
                     :sort-by.sync="sortBy" :sort-desc.sync="sortDesc"
                     @sort-changed="sortChanged"
                     @row-clicked="toItem"/>
            <div class="overflow-auto">
                <b-pagination-nav class="float-md-left" use-router
                                  base-url="/days/"
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
    import Api from '../api';

    export default {
        mixins: [items],
        data() {
            return {
                datepicker: null,
                sortBy: 'date',
                itemsUrl: 'days',
                itemUrl: 'day',
                fields: [
                    {
                        key: 'date',
                        sortable: true
                    },
                    {
                        key: 'calories',
                        sortable: true,
                        label: 'Calories kkal'
                    },
                    {
                        key: 'ratio',
                        sortable: false,
                        label: 'Ratio %',
                        formatter: (value) => {
                            return value.join(' / ');
                        }
                    },
                    {
                        key: 'progress',
                        label: 'Progress %',
                        sortable: false,
                        formatter: (value) => {
                            return value.join(' / ');
                        }
                    },
                ],
            };
        },
        mounted() {
            const component = this;
            this.datepicker = $('#day-date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd',
                modal: true
            }).change(function () {
                const date = $(this).val(), client = Api.client();
                client.get('days?page=1&perPage=1&sortBy=date&sortDirection=asc&date=' + date).then((response) => {
                    const result = response.data;
                    const items = result.data;
                    if (items.length > 0) {
                        component.$router.push('/day/' + items[0].id+'/1');
                    } else {
                        client.post('days', {date}).then((response) => {
                            const result = response.data;
                            component.$router.push('/day/' + result.data.id+'/1');
                        });
                    }
                })
            });


            // .change(function () {const date = $(this).val();});
        },
        methods: {
            showDatepicker() {
                this.datepicker.open();
            },
            toItem(item, index, button) {
                this.$router.push('/' + this.itemUrl + '/' + item.id+'/1');
            },
        }
    }
</script>