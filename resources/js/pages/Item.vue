<template>
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <form v-on:submit.prevent="onSubmit">
                    <h1 v-if="isNewItem()" class="mdc-typography--subtitle1">
                        New item
                    </h1>
                    <h1 v-else class="mdc-typography--subtitle1">
                        {{ item.title }}
                    </h1>
                    <field-text id="title" title="Title" ref="title" type="text" v-model="item.title"></field-text>
                    <field-float id="protein" title="Protein" ref="protein" type="number"
                                 v-bind:step="0.1" v-model="item.protein"></field-float>
                    <field-float id="fat" title="Fat" ref="fat" type="number" v-bind:step="0.1"
                                 v-bind:min="0" v-model="item.fat"></field-float>
                    <field-float id="carbohydrates" title="Carbohydrates" ref="carbohydrates" type="number"
                                 v-bind:step="0.1" v-model="item.carbohydrates"></field-float>
                    <field-float id="fiber" title="Fiber" ref="fiber" type="number" v-bind:step="0.1"
                                 v-model="item.fiber"></field-float>

                    <button id="item-submit-button" class="mdc-button form-button">
                        <span v-if="isNewItem" class="mdc-button__label">Create</span>
                        <span v-else class="mdc-button__label">Update</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import api from '../api';

    export default {
        mounted() {
            const itemId = this.$router.currentRoute.params.itemId;

            this.$data.item.id = itemId;
            this.$data.button = document.querySelector('#item-submit-button');

            if (itemId) {
                this.loadData();
            }
        },
        data: function () {
            return {
                item: {id: 'new'},
                button: null
            };
        },
        props: {
            id: {
                type: String,
            }
        },
        methods: {
            loadData() {
                const component = this;
                api.get('/api/items/' + this.$data.item.id).then(function (response) {
                    if (response.data.data.id === component.$data.item.id) {
                        component.$data.item = response.data.data;
                    }
                }).catch(error => {
                    error.log(error);
                })
            },
            isNewItem: function () {
                return this.$data.item.id === 'new';
            },
            onSubmit() {
                this.disableButton();
                this.clearErrors();

                let url = '/api/items';
                let method = api.post;

                if (this.id) {
                    url += '/' + id;
                    method = api.patch;
                }

                method(url, {
                    "title": this.$refs.title.getValue(),
                    "protein": this.$refs.protein.getValue(),
                    "fat": this.$refs.fat.getValue(),
                    "carbohydrates": this.$refs.carbohydrates.getValue(),
                    "fiber": this.$refs.fiber.getValue()
                }).then(response => {
                    location.href = '/items';
                }).catch(error => {
                    if (error.response && error.response.status === 422) {
                        let data = error.response.data;
                        if (data && data.errors) {
                            this.processErrors(data.errors);
                        }
                        this.enableButton();
                        return;
                    }
                    console.error(error);
                    this.enableButton();
                });
            },
            processErrors(errors) {
                if (errors.email && errors.email.length > 0) {
                    this.$refs.email.setError(errors.email.pop());
                }

                if (errors.title && errors.title.length > 0) {
                    this.$refs.title.setError(errors.title.pop());
                }
                if (errors.protein && errors.protein.length > 0) {
                    this.$refs.protein.setError(errors.protein.pop());
                }
                if (errors.fat && errors.fat.length > 0) {
                    this.$refs.fat.setError(errors.fat.pop());
                }
                if (errors.carbohydrates && errors.carbohydrates.length > 0) {
                    this.$refs.carbohydrates.setError(errors.carbohydrates.pop());
                }
                if (errors.fiber && errors.fiber.length > 0) {
                    this.$refs.fiber.setError(errors.fiber.pop());
                }
            },
            clearErrors() {
                this.$refs.title.clear();
                this.$refs.protein.clear();
                this.$refs.fat.clear();
                this.$refs.carbohydrates.clear();
                this.$refs.fiber.clear();
            },
            disableButton() {
                this.$data.button.setAttribute('disabled', 'disabled');
            },
            enableButton() {
                this.$data.button.removeAttribute('disabled');
            }
        }
    }
</script>