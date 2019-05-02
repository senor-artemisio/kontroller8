<template xmlns="http://www.w3.org/1999/html">
    <b-container>
        <b-breadcrumb class="mt-3" :items="breadcrumbs"></b-breadcrumb>
        <h1 class="mt-3">
            Days
            <b-button size="sm" variant="primary" v-b-toggle.days-datepicker>
                <i class="fas fa-calendar"></i>
            </b-button>
            <b-form-select class="w-auto" size="sm" :options="perPageOptions" v-model="perPage"
                           v-on:change="perPageChanged"/>
        </h1>
        <b-collapse id="days-datepicker" class="position-absolute" style="z-index: 2"></b-collapse>
        <div v-if="loaded">
            <b-table responsive stacked="sm" :no-local-sorting="true"
                     :items="items"
                     :fields="fields"
                     :sort-by.sync="sortBy" :sort-desc.sync="sortDesc"
                     @sort-changed="sortChanged">
                <template slot="date" slot-scope="data">
                    <b-link :to="'/day/'+data.item.id+'/1'">{{ data.item.title }}</b-link>
                </template>
            </b-table>
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
    import 'jquery-ui/ui/widgets/datepicker.js';

    export default {
        mixins: [items],
        data() {
            return {
                datepickerContainer: null,
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
                        label: 'kCal'
                    },
                    {
                        key: 'ratio',
                        sortable: false,
                        formatter: (value) => {
                            return value.join(' / ');
                        }
                    },
                    {
                        key: 'progress',
                        sortable: false,
                        formatter: (value) => {
                            return value.join(' / ');
                        }
                    },
                ],
                breadcrumbs: [{text: 'Days', active:true}]
            };
        },
        mounted() {
            const component = this;
            this.datepickerContainer = $('#days-datepicker');
            this.datepickerContainer.datepicker({
                showOn: 'button',
                dateFormat: "yy-mm-dd",
                onSelect: (date) => {
                    const client = Api.client();
                    client.get('days?page=1&perPage=1&sortBy=date&sortDirection=asc&date=' + date).then((response) => {
                        const result = response.data;
                        const items = result.data;
                        if (items.length > 0) {
                            component.$router.push('/day/' + items[0].id + '/1');
                        } else {
                            client.post('days', {date}).then((response) => {
                                const result = response.data;
                                component.$router.push('/day/' + result.data.id + '/1');
                            });
                        }
                    })
                }
            })
        },
    }
</script>