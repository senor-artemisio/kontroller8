<template>
    <div>
        <div class="mdc-switch switch-sign-in">
            <div class="mdc-switch__track"></div>
            <div class="mdc-switch__thumb-underlay">
                <div class="mdc-switch__thumb">
                    <input type="checkbox" id="sign-in-up-switch" v-on:change="toggle"
                           class="mdc-switch__native-control" role="switch">
                </div>
            </div>
        </div>
        <label for="sign-in-up-switch">&nbsp;&nbsp;Sign up</label>
    </div>
</template>
<script>
    import {MDCSwitch} from '@material/switch';

    export default {
        mounted() {
            new MDCSwitch(document.querySelector('.mdc-switch'));
        },
        methods: {
            toggle: function (event) {
                if (event.srcElement.checked) {
                    document.querySelector('#auth-sign-in').classList.add('hidden');
                    document.querySelector('#auth-sign-up').classList.remove('hidden');
                    document.querySelector('#auth-sign-up').classList.remove('hidden');
                    document.querySelector('.mdc-switch').classList.remove('switch-sign-in');
                    document.querySelector('.mdc-switch').classList.add('switch-sign-up');
                } else {
                    document.querySelector('#auth-sign-in').classList.remove('hidden');
                    document.querySelector('#auth-sign-up').classList.add('hidden');
                    document.querySelector('.mdc-switch').classList.remove('switch-sign-up');
                    document.querySelector('.mdc-switch').classList.add('switch-sign-in');
                }
            }
        }
    }
</script>
<style>
    .switch-sign-up {
        margin-top: 20px;
    }
    .switch-sign-in{
        margin-top: 76px;
    }
</style>