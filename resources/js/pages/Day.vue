<template>
    <b-container>
        <b-row>
            <b-col md="6">
                <b-form @submit="onSubmit">
                    <b-form-group label-align="right" label-cols="4" label-cols-lg="4">
                        <h2 class="mt-3">{{form.title}}</h2>
                    </b-form-group>
                </b-form>
            </b-col>
        </b-row>
    </b-container>
</template>
<script>
    import Api from '../api';

    export default {
        data: function () {
            return {
                date: this.$router.currentRoute.params.date,
                day: {}
            }
        },
        mounted() {
            this.load();
        },
        methods: {
            load() {
                Api.client().get('days/date/' + this.date).then((response) => {
                    this.day = response.data.data;
                })
            }
        }
    }
</script>