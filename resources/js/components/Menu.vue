<template>
    <b-navbar toggleable="sm" type="dark" variant="dark">
        <b-navbar-brand>
            <logo></logo>
        </b-navbar-brand>

        <b-navbar-toggle target="nav_collapse"/>

        <b-collapse is-nav id="nav_collapse">
            <b-navbar-nav>
                <b-nav-item to="/dashboard">Dashboard</b-nav-item>
                <b-nav-item to="/days" :active="isDays">Days</b-nav-item>
                <b-nav-item to="/meals" :active="isMeals">Meals</b-nav-item>
            </b-navbar-nav>

            <b-navbar-nav class="ml-auto d-none d-sm-flex">
                <b-nav-item-dropdown right>
                    <template slot="button-content"><b>{{ user.name }}</b></template>
                    <b-dropdown-item to="/profile">Profile</b-dropdown-item>
                    <b-dropdown-item to="/account">Account</b-dropdown-item>
                    <b-dropdown-item v-on:click="logOut()">Sign out</b-dropdown-item>
                </b-nav-item-dropdown>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
    export default {
        data() {
            return {
                user: {
                    name: ""
                },
                isDays: false,
                isMeals: false
            };
        },
        mounted() {
            this.$store.dispatch('user').then(() => {
                this.user.name = this.$store.getters.user.name;
            });
            this.isDays = this.getIsDays(location.pathname);
            this.isMeals = this.getIsMeals(location.pathname);
        },
        methods: {
            logOut() {
                this.$store.dispatch('logout');
            },
            getIsMeals(path){
                return path.indexOf('/meal') === 0;
            },
            getIsDays(path){
                return path.indexOf('/day') === 0 || path.indexOf('/portion') === 0;
            }
        },
        watch: {
            '$route'(to) {
                this.isDays = this.getIsDays(to.path);
                this.isMeals = this.getIsMeals(to.path);
            }
        }
    }
</script>