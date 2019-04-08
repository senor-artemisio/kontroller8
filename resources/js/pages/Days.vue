<template>
    <div class="container-fluid calendar">
        <header>
            <h4 class="display-5 mb-3 mt-3 text-center caption">
                <b-link :to="getPrevUrl()">
                    <i class="fas fa-arrow-left"></i>
                </b-link>
                {{ title }}
                <b-link :to="getNextUrl()">
                    <i class="fas fa-arrow-right"></i>
                </b-link>
            </h4>
            <div class="row d-none d-sm-flex p-1 bg-dark text-white pt-3">
                <h5 v-for="item in items" class="col-sm p-1 text-center">
                    {{item.dayOfWeek}}
                </h5>
            </div>
        </header>
        <div class="row border border-right-0 border-bottom-0 border-top-0">
            <div v-for="day in items" :class="getDayCssClass(day)">
                <h5 class="row align-items-center">
                    <span class="date col-1">{{day.title}}</span>
                    <small class="col d-sm-none text-center text-muted">{{day.dayOfWeek}}</small>
                    <span class="col-1"></span>
                </h5>
                <p v-if="isEmptyPortions(day)">No portions</p>
                <div v-else>
                    <p v-for="portion in day.portions" :class="getPortionCssClass(portion, day)"
                       v-on:click.prevent="eatenToggle(portion)"
                       :id="'p-'+portion.id">
                        <span class="text-capitalize">{{portion.meal.title}}</span><br>
                        <small>{{portion.weight}}g / {{portion.time_plan}}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Api from '../api';
    import moment from 'moment';

    export default {
        data: function () {
            return {
                items: [],
                date: null,
                title: null
            };
        },
        mounted() {
            this.date = this.$router.currentRoute.params.date;
            this.title = moment(this.date, 'YYYY-MM-DD').format('MMMM Do YYYY');
            this.load(this.date);
        },
        watch: {
            '$route.params.date'(to, from) {
                this.load(to);
            }
        },
        methods: {
            load(date) {
                const component = this;
                Api.client().get('days/week/' + date).then(function (response) {
                    component.items = response.data.data;
                    component.date = date;
                    component.title = moment(date, 'YYYY-MM-DD').format('MMMM Do YYYY');
                });
            },
            getDayCssClass(day) {
                let cssClass = 'day col-sm p-2 border border-left-0 border-top-0 text-truncate';
                if (day.date !== this.date) {
                    cssClass += ' d-none d-sm-block bd-light text-dark';
                } else {
                    cssClass += ' bg-dark text-light'
                }

                return cssClass;
            },
            getPortionCssClass(portion, day) {
                let cssClass = 'cursor-pointer';

                if (portion.eaten) {
                    cssClass += ' text-muted text-overline';
                }
                return cssClass;
            },
            isEmptyPortions(item) {
                return item.portions.length === 0;
            },
            getPrevUrl() {
                return '/days/' + moment(this.date, 'YYYY-MM-DD').subtract(1, 'days').format('YYYY-MM-DD');
            },
            getNextUrl() {
                return '/days/' + moment(this.date, 'YYYY-MM-DD').add(1, 'days').format('YYYY-MM-DD');
            },
            eatenToggle(portion) {
                let p = this.$el.querySelector('#p-' + portion.id);
                if (portion.eaten) {
                    p.classList.remove('text-overline');
                } else {
                    p.classList.add('text-overline');
                }
                portion.eaten = !portion.eaten;

                this.load(this.date);

                console.log(portion.id, portion.eaten);
            }
        }
    }
</script>