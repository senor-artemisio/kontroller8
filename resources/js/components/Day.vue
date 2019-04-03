<template>
    <div :class="'day col-sm p-2 border border-left-0 border-top-0 text-truncate' + cssClass">
        <h5 class="row align-items-center">
            <span class="date col-1">{{ getDay() }}</span>
            <small class="col d-sm-none text-center text-muted">{{ getDayOfWeek() }}</small>
            <span class="col-1"></span>
        </h5>
        <p class="d-sm-none" v-if="isEmpty">No events</p>
        <span v-for="item in items">{{item.title}}</span>
        <b-button>Add</b-button>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                items: [],
                cssClass: '',
                isCurrent: false
            };
        },
        props: ['value'],
        mounted() {
            if (this.isCurrent) {
                this.cssClass += ' d-none d-sm-inline-block';
            }
        },
        methods: {
            getDay() {
                return this.value.format("MMMM Do YYYY");
            },
            getDayOfWeek() {
                return this.value.format('dddd');
            },
            isEmpty() {
                return this.items.length === 0;
            }
        }
    }
</script>