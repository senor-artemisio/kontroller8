<template>
    <b-navbar toggleable="sm" type="dark" variant="dark">
        <b-navbar-brand>
            <logo></logo>
        </b-navbar-brand>

        <b-navbar-toggle target="nav_collapse"/>

        <b-collapse is-nav id="nav_collapse">
            <b-navbar-nav>
                <b-nav-item to="/dashboard">Dashboard</b-nav-item>
                <b-nav-item to="/meals">Meals</b-nav-item>
                <b-nav-item to="/days">Days</b-nav-item>
            </b-navbar-nav>

            <b-navbar-nav class="ml-auto d-none d-sm-flex">
                <b-nav-item-dropdown text="Lang" right>
                    <b-dropdown-item href="#">EN</b-dropdown-item>
                    <b-dropdown-item href="#">RU</b-dropdown-item>
                </b-nav-item-dropdown>

                <b-nav-item-dropdown right>
                    <template slot="button-content"><b>{{ user.name }}</b></template>
                    <b-dropdown-item to="/profiile">Profile</b-dropdown-item>
                    <b-dropdown-item v-on:click="logOut()">Signout</b-dropdown-item>
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
                }
            };
        },
        mounted() {
            this.$store.dispatch('user').then(() => {
                this.user.name = this.$store.getters.user.name;
            });
        },
        methods: {
            logOut() {
                this.$store.dispatch('logout');
            }
        }
    }
</script>