<template>
    <div :class="'logo-k8 '+ cssClass " :style="getStyle()">
        <span :class="'k k'+n" v-for="n in 10"></span>
    </div>
</template>
<script>
    export default {
        props: ['size', 'cssClass'],
        methods: {
            getStyle() {
                let style = {};
                if (this.size !== 1) {
                    style.transform = 'scale(' + this.size + ')';
                }

                return style;
            }
        }
    };
</script>