<template>    
    <div class="form-group continent_id">    
        <select name="continent_id" id="continent_id" class="selectpicker" data-live-search="false" title="Pick one">
            <option v-if="continents.length>0" v-for="continent in continents" v-bind:value="continent.id">
                {{ continent.name }}
            </option>
        </select>
    </div>
        
</template>

<script>
    export default {
        
        mounted() {
            console.log('Component mounted.');
            this.loadData();
        },
        created(){
            //this.loadData();
        },
        
        data() {
            continents: '';
            return {
                continents: [],
            }
       },
       
       methods: {
            loadData: function() {
                axios.get('/api/continents')
                .then((response) => {
                    // handle success
                    console.log(response.data.data);
                    //now this refers to your vue instance and this can access you data property
                    this.continents = response.data.data;
                })
                .catch((error) => {
                    // handle error
                    console.log(error);
                })
                .then(() => {
                    // always executed
                });
            },
            
        },
       
    }

</script>
