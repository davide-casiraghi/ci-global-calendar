<template>
    <div class="">
        
    
        <div class="form-group continent_id">    
            <select name="continent_id" id="continent_id" class="selectpicker" data-live-search="false" title="Pick a continent">
                <option v-if="continents.length>0" v-for="continent in continents" v-bind:value="continent.id">
                    {{ continent.name }}
                </option>
            </select>
        </div>
        
        <div class="form-group country_id">    
            <select name="country_id" id="country_id" class="selectpicker" data-live-search="true" title="Pick a country">
                <option  v-for="(country, index) in countries" >
                    {{ country.name }}
                </option>
            </select>
        </div>
        
    </div>

        
</template>

<script>
    export default {
        
        mounted() {
            console.log('Component mounted.');
            this.loadData();
            console.log('Loaded datas.');
            console.log(this.continents);
            console.log(this.countries);
        },
        created(){
            //this.loadData();
        },
        
        data() {
            continents: '';
            countries: '';
            return {
                continents: [],
                countries: [],
            }
       },
       
       methods: {
           // https://github.com/axios/axios#request-config
            loadData: function() {
                axios.get('/api/continents')
                .then((response) => {
                    // handle success
                    //console.log(response.data.data);
                    //now this refers to your vue instance and this can access you data property
                    this.continents = response.data.data;
                    this.getAllCountries(response.data.data);
                })
                .catch((error) => {
                    // handle error
                    console.log(error);
                })
                .then(() => {
                    // always executed
                });
            },
            getAllCountries: function(continents) {
                //eg: //this.countries[1] = {name: 'apple', price: '10'};
                var j = 0;
                for (var i = 0, len = continents.length; i < len; i++) {
                    for (var key in continents[i].active_countries) {
                        this.countries[j] = {id: continents[i].active_countries[key], name: key};
                        j++;
                    }
                }
            }
        },
       
    }

</script>
