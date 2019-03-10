<template>
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <h1 v-if="isNewItem" class="mdc-typography--subtitle1">
                    New item
                </h1>
                <h1 v-else class="mdc-typography--subtitle1">
                    {{ item.title }}
                </h1>
                <div class="mdc-text-field">
                    <input type="text" id="item-title" class="mdc-text-field__input">
                    <label class="mdc-floating-label" for="item-title">Title</label>
                    <div class="mdc-line-ripple"></div>
                </div>
                <div></div>
                <div id="sign-in-item-helper" class="mdc-text-field-helper-line mdc-theme--error">
                    <div id="sign-in-item-message" class="mdc-text-field-helper-text mdc-text-field-helper-text--persistent"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {MDCTextField} from '@material/textfield';

    export default {
        data: function () {
            return {item: {}};
        },
        methods: {
            isNewItem: function () {
                return !!this.item.id;

            }
        },
        mounted() {
            document.querySelectorAll('.mdc-text-field').forEach(function (field) {
                new MDCTextField(field);
            });
        }
    }
</script>