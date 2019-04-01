<template>
    <div :class="getCssClass()">
        <h5 class="row align-items-center">
            <span class="date col-1">{{ getDay() }}</span>
            <small class="col d-sm-none text-center text-muted">{{ getDayOfWeek() }}</small>
            <span class="col-1"></span>
        </h5>
        <p class="d-sm-none" v-if="isEmpty">No events</p>
        <span v-for="value.items in item">{{item.title}}</span>
    </div>
</template>
<script>
    export default {
        props: ['today', 'value'],
        methods: {
            getCssClass() {
                let cssClass = 'day col-sm p-2 border border-left-0 border-top-0 text-truncate';
                if (this.today === false) {
                    cssClass += ' d-none d-sm-inline-block';
                }
                return cssClass;
            },
            getDayOfWeek() {
                return this.value.date.format('day of week');
            },
            getDay() {
                return this.value.date.format('day');
            },
            isEmpty() {
                return this.value.items.length === 0;
            }
        }
    }
</script>