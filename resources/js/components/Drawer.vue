<template>
    <aside class="mdc-drawer mdc-drawer--dismissible">
        <div class="mdc-drawer__header">
            <h3 class="mdc-drawer__title">{{ user.name }}</h3>
            <h6 class="mdc-drawer__subtitle">{{ user.email }}</h6>
        </div>
        <div class="mdc-drawer__content">
            <nav class="mdc-list">
                <router-link to="/dashboard" class="mdc-list-item" aria-selected="true">
                    <i class="material-icons mdc-list-item__graphic" aria-hidden="true">dashboard</i>
                    <span class="mdc-list-item__text">Dashboard</span>
                </router-link>
                <router-link to="/calendar" class="mdc-list-item">
                    <i class="material-icons mdc-list-item__graphic" aria-hidden="true">event</i>
                    <span class="mdc-list-item__text">Calendar</span>
                </router-link>
                <router-link to="/items" class="mdc-list-item">
                    <i class="material-icons mdc-list-item__graphic" aria-hidden="true">view_list</i>
                    <span class="mdc-list-item__text">Items</span>
                </router-link>
            </nav>
        </div>
    </aside>
</template>

<script>
    import {MDCDrawer} from "@material/drawer/index";

    export default {
        mounted() {
            const drawer = MDCDrawer.attachTo(document.querySelector('.mdc-drawer'));
            this.$store.commit('drawer', drawer);
            const route = this.$route.name;
        },
        computed: {
            user() {
                return this.$store.getters.user;
            }
        }
    }
</script>