<template>
    <b-container class="mt-3">
        <b-card v-if="today"
                title="Daily progress"
                tag="article"
                class="mb-2 dashboard-item">
            <b-card-text>
                {{today.calories}} kCal
                <b-progress :value="caloriesProgress" :max="100" class="mt-1 mb-3" show-progress>
                    <b-progress-bar :value="caloriesProgress" :label="caloriesProgress+'%'"></b-progress-bar>
                </b-progress>
                Protein / Fat / Carbohydrates
                <b-progress :max="100" show-progress class="mt-1 mb-3">
                    <b-progress-bar variant="primary" :value="today.ratio[0]"
                                    :label="today.ratio[0]+'%'"></b-progress-bar>
                    <b-progress-bar variant="secondary" :value="today.ratio[1]"
                                    :label="today.ratio[1]+'%'"></b-progress-bar>
                    <b-progress-bar variant="primary" :value="today.ratio[2]" :label="today.ratio[2]+'%'"></b-progress-bar>
                </b-progress>
            </b-card-text>

            <b-button @click="editToday()" variant="primary">Edit</b-button>
        </b-card>
    </b-container>
</template>
<script>
    import moment from 'moment';
    import Api from '../api';

    export default {
        data() {
            return {
                today: null,
                caloriesProgress: 5
            }
        },
        mounted() {
            const client = Api.client(), date = moment().format('YYYY-MM-DD');
            client.get('days?page=1&perPage=1&sortBy=date&sortDirection=asc&date=' + date).then((response) => {
                const result = response.data;
                const items = result.data;
                if (items.length > 0) {
                    this.today = items.shift();
                    this.caloriesProgress = this.today.calories_eaten_percent;
                }
            })
        },
        methods: {
            editToday() {
                this.$router.push('/day/' + this.today.id + '/1');
            }
        }

    }
</script>
