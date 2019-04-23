<template xmlns="http://www.w3.org/1999/html">
    <b-container>
        <h1 class="mt-3">
            Days
            <b-button size="sm" variant="primary" v-b-modal.days-add>
                <i class="fas fa-plus"></i>
            </b-button>
        </h1>
        <b-modal id="days-add" title="Add new day" @ok="onSubmitDate" ref="add">
            <b-form-group label="Date of day"
                          label-for="day-date"
                          :state="getFieldState('date')"
                          :invalid-feedback="getFieldError('date')">
                <b-form-input id="day-date" type="text" width="276" required/>
            </b-form-group>
        </b-modal>
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
                <b-form-select class="float-md-right w-auto mb-3" size="sm" :options="perPageOptions" v-model="perPage"
                               v-on:change="perPageChanged"/>
            </div>
        </div>
    </b-container>
</template>
<script>
    import items from '../mixins/items';
    import form from '../mixins/form';
    import moment from 'moment';

    export default {
        mixins: [items, form],
        data() {
            return {
                formUrl: 'days',
                form: {
                    id: 'new',
                    date: null,
                },
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
                        sortable: true
                    },
                    {
                        key: 'ratio',
                        sortable: false,
                        label: 'Ratio %',
                        formatter: (value, key, item) => {
                            return value.join(' / ');
                        }
                    },
                    {
                        key: 'calories_eaten_percent',
                        label: 'Progress %',
                        sortable: false
                    },
                ],
            };
        },
        mounted() {
            let component = this;
            $('#day-date').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'yyyy-mm-dd'
            }).change(function () {
                component.form.date = $(this).val();
            });
        },
        methods: {
            onSubmitDate(evt) {
                evt.preventDefault();
                this.save().then(() => {
                    if (!Object.keys(this.errors).length) {
                        this.$refs.add.hide();
                        this.load();
                    }
                });
            },
        }
    }
</script>