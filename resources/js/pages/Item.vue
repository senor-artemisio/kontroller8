<template>
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <form v-on:submit.prevent="onSubmit">
                    <h1 v-if="isNewItem" class="mdc-typography--subtitle1">
                        New item
                    </h1>
                    <h1 v-else class="mdc-typography--subtitle1">
                        {{ item.title }}
                    </h1>
                    <field-input id="title" title="Title" ref="title" type="text"></field-input>
                    <field-input id="protein" title="Protein" ref="protein" type="number" step="0.1"></field-input>
                    <field-input id="fat" title="Fat" ref="fat" type="number" step="0.1"></field-input>
                    <field-input id="carbohydrates" title="Carbohydrates" ref="carbohydrates" type="number"
                                 step="0.1"></field-input>
                    <field-input id="fiber" title="fiber" ref="fiber" type="number" step="0.1"></field-input>

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
            this.$data.button = document.querySelector('#item-submit-button');
        },
        data: function () {
            return {
                item: {},
                button: null
            };
        },
        props: {
            id: {
                type: String,
            }
        },
        methods: {
            isNewItem: function () {
                return !!this.item.id;
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
                    "title": this.$refs.title.value(),
                    "protein": this.$refs.protein.value(),
                    "fat": this.$refs.fat.value(),
                    "carbohydrates": this.$refs.carbohydrates.value(),
                    "fiber": this.$refs.fiber.value()
                }).then(response => {
                    location.href='/items';
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
                    this.$refs.email.error(errors.email.pop());
                }

                if (errors.title && errors.title.length > 0) {
                    this.$refs.title.error(errors.title.pop());
                }
                if (errors.protein && errors.protein.length > 0) {
                    this.$refs.protein.error(errors.protein.pop());
                }
                if (errors.fat && errors.fat.length > 0) {
                    this.$refs.fat.error(errors.fat.pop());
                }
                if (errors.carbohydrates && errors.carbohydrates.length > 0) {
                    this.$refs.carbohydrates.error(errors.carbohydrates.pop());
                }
                if (errors.fiber && errors.fiber.length > 0) {
                    this.$refs.fiber.error(errors.fiber.pop());
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