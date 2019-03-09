<template>
    <div class="mdc-layout-grid">
        <div class="mdc-layout-grid__inner">
            <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-6">
                <h1 v-if="item.id === null" class="mdc-typography--subtitle1">
                    New item
                </h1>
                <h1 v-else class="mdc-typography--subtitle1">
                    {{ item.title }}
                </h1>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data:function () {
            return {item:{}};
        }
    }
</script>