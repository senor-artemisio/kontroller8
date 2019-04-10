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
                    <span :class="getDayTitleCssClass(day)">
                        {{day.title}}
                        <b-link :to="getDayUrl(day)" class="day-edit-link"><i class="fas fa-pen ml-2"></i></b-link>
                    </span>
                    <small class="col d-sm-none text-center text-muted">{{day.dayOfWeek}}</small>
                    <span class="col-1"></span>
                </h5>
                <p class="text-primary" v-if="day.weight !== day.weight_eaten">
                    {{day.weight}}g / {{day.weight_eaten}}g<br>
                    <span class="text-success">{{day.protein}}g</span> /
                    <span class="text-light">{{day.fat}}g</span> /
                    <span class="text-danger">{{day.carbohydrates}}g</span>
                    <br>
                    <span class="text-success">{{day.protein_eaten}}g</span> /
                    <span class="text-light">{{day.fat_eaten}}g</span> /
                    <span class="text-danger">{{day.carbohydrates_eaten}}g</span>
                </p>
                <p class="text-primary" v-else>
                    {{day.weight}}g<br>
                    <span class="text-success">{{day.protein}}g</span> /
                    <span class="text-light">{{day.fat}}g</span> /
                    <span class="text-danger">{{day.carbohydrates}}g</span>
                </p>
                <p v-if="isEmptyPortions(day)">No portions</p>
                <div v-else>
                    <p v-for="portion in day.portions" :class="getPortionCssClass(portion, day)"
                       v-on:click.prevent="eatenToggle(portion)"
                       :id="'p-'+portion.id">
                        <span class="text-capitalize">{{portion.meal.title}}</span><br>
                        <small v-if="portion.eaten">{{portion.weight}}g / {{ portion.time_eaten }}</small>
                        <small v-else>{{portion.weight}}g / {{ portion.time_plan }}</small>
                        <br>
                        <small>
                            {{portion.protein}}g / {{portion.fat}}g / {{portion.carbohydrates}}g
                        </small>
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
                title: null,
                client: null
            };
        },
        mounted() {
            this.client = Api.client();
            this.date = this.$router.currentRoute.params.date;
            this.title = moment(this.date, 'YYYY-MM-DD').format('MMMM Do YYYY');
            this.load(this.date);
        },

        watch: {
            '$route.params.date'(to, from) {
                this.load(to); // reload items when url params is changed
            }
        },
        methods: {
            /**
             * Load week from API.
             * @param date
             */
            load(date) {
                const component = this;
                this.client.get('days/week/' + date).then(function (response) {
                    component.items = response.data.data;
                    component.date = date;
                    component.title = moment(date, 'YYYY-MM-DD').format('MMMM Do YYYY');
                });
            },
            /**
             * Make current day dark.
             * @param day
             * @returns {string}
             */
            getDayCssClass(day) {
                let cssClass = 'day col-sm p-2 border border-left-0 border-top-0 text-truncate';
                if (day.date !== this.date) {
                    cssClass += ' d-none d-sm-block bd-light text-dark';
                } else {
                    cssClass += ' bg-dark text-light'
                }

                return cssClass;
            },
            /**
             * @param day
             * @returns {string} url for manage day page
             */
            getDayUrl(day) {
                console.log(day);
                return '/day/' + day.date;
            },
            /**
             * Makes portion through line or not depends from eaten property all portions in day.
             * @param day
             * @returns {string}
             */
            getDayTitleCssClass(day) {
                return day.eaten && !this.isEmptyPortions(day) ? 'date col-1 text-overline' : 'date col-1';
            },
            /**
             * Makes portion through line or not depends from eaten property.
             * @param portion
             * @param day
             * @returns {string}
             */
            getPortionCssClass(portion, day) {
                let cssClass = 'cursor-pointer';

                if (portion.eaten) {
                    cssClass += ' text-muted text-overline';
                }
                return cssClass;
            },
            /**
             * Check what day have portions.
             * @param day
             * @returns {boolean}
             */
            isEmptyPortions(day) {
                return day.portions.length === 0;
            },
            /**
             * @returns {string} previous day url
             */
            getPrevUrl() {
                return '/days/' + moment(this.date, 'YYYY-MM-DD').subtract(1, 'days').format('YYYY-MM-DD');
            },
            /**
             * @returns {string} next day url
             */
            getNextUrl() {
                return '/days/' + moment(this.date, 'YYYY-MM-DD').add(1, 'days').format('YYYY-MM-DD');
            },
            /**
             * Toggle eaten state for portion, save it in database.
             * @param portion
             */
            eatenToggle(portion) {
                const component = this;
                let p = this.$el.querySelector('#p-' + portion.id);

                if (portion.eaten) {
                    p.classList.remove('text-overline');
                } else {
                    p.classList.add('text-overline');
                }

                let url = '';
                if (portion.eaten) {
                    url = 'portions/unmark-eaten/' + portion.id;
                } else {
                    url = 'portions/mark-eaten/' + portion.id;
                }

                this.client.post(url, {}).then(function (response) {
                    component.load(component.date);
                });

                portion.eaten = !portion.eaten;
            }
        }
    }
</script>