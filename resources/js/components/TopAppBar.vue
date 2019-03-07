<template>
    <header class="mdc-top-app-bar mdc-top-app-bar--fixed">
        <div class="mdc-top-app-bar__row">
            <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
                <button class="material-icons mdc-top-app-bar__navigation-icon">menu</button>

                <span class="mdc-top-app-bar__title">
                    KONTROLLER
                </span>
                <span class="mdc-top-app-bar__title" style="padding-left: 5px">
                    <span class="logo logo-k8">
                        <span class="k k1"></span>
                        <span class="k k2"></span>
                        <span class="k k3"></span>
                        <span class="k k4"></span>
                        <span class="k k5"></span>
                        <span class="k k6"></span>
                        <span class="k k7"></span>
                        <span class="k k8"></span>
                        <span class="k k9"></span>
                        <span class="k k10"></span>
                    </span>
                </span>
            </section>
            <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end">
                <span class="mdc-top-app-bar__title">{{ user.name }}</span>
                <span class="mdc-top-app-bar__title">
                    <button class="material-icons mdc-top-app-bar__action-item" aria-label="Logout">lock_open</button>
                </span>
            </section>
        </div>
    </header>
</template>

<script>
    import {MDCTopAppBar} from '@material/top-app-bar/index';

    export default {
        mounted() {
            const topAppBarElement = document.querySelector('.mdc-top-app-bar');
            const topAppBar = new MDCTopAppBar(topAppBarElement);
            const drawer = this.$store.getters.drawer;
            topAppBar.listen('MDCTopAppBar:nav', function () {
                drawer.open = !drawer.open;
            });
        },
        computed: {
            user() {
                return this.$store.getters.user;
            }
        }
    }
</script>
