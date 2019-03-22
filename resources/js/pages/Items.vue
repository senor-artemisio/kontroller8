<template>
    <div>
        <b-table striped hover :items="items" :fields="fields" no-local-sorting="true" @sort-changed="sortChanged"/>
    </div>
</template>
<script>
    import Api from '../api';
    export default {
        data() {
          return {
              sortBy:null,
              items:[],
              fields:[
                  {
                      key:'title',
                      sortable: true
                  },
                  'protein',
                  'fat',
                  'carbohydrates',
                  'fiber'
              ]
          };
        },
        methods:{
            sortChanged(ctx)  {
              this.sortBy = ctx.sortBy;
          }
        },
        mounted() {
            Api.client().get('items').then((response) => {
               this.items = response.data.data;
            });
        }
    }
</script>
