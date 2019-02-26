<template>
    <div>
        <div class="form-group continent_id">    
            <select name="continent_id" v-model="continent_selected" id="continent_id" class="selectpicker" data-live-search="false" title="Pick a continent" v-on:change="getAllCountries(continents)">
                <option v-if="continents.length>0" v-for="continent in continents" v-bind:value="continent.id">
                    {{ continent.name }}
                </option>
            </select>
        </div>
        
        <div class="form-group country_id">    
            <select name="country_id" v-model="country_selected" id="country_id" class="selectpicker" data-live-search="true" title="Pick a country">
                <option  v-for="(country, index) in countries" v-bind:value="country.id" >
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
            return {
                continents: [],
                countries: [],
                continent_selected: '',
                country_selected: '',
            }
       },
       /*computed: {
        // a computed getter
            continent_selected: function () {
                // `this` points to the vm instance
                //console.log(continent_selected);
                //continents = 
                //return this.continent_selected + "ss";
                
                var map = this.getAllCountries(response.data.data, 1);
                return map;
            }
        },*/
       
       
       methods: {
           // https://github.com/axios/axios#request-config
            loadData: function() {
                axios.get('/api/continents')
                .then((response) => {
                    // handle success
                    //console.log(response.data.data);
                    //now this refers to your vue instance and this can access you data property
                    this.continents = response.data.data;
                    this.getAllCountries(this.continents);
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
                console.log(this.continent_selected);
                //console.log(continents);
                console.log(continents);
                
                var j = 0;
                this.countries = [];
                    
                for (var i = 0, len = continents.length; i < len; i++) {
                    
                    if (!this.continent_selected){
                        console.log("No Continent selected");
                        for (var key in continents[i].active_countries) {
                            this.countries[j] = {id: continents[i].active_countries[key], name: key};
                            j++;
                        }
                    }
                    else{
                        console.log("continent selected: "+ this.continent_selected);
                        for (var key in continents[i].active_countries) {
                            if (continents[i].id == this.continent_selected){
                                console.log("THE SAME");
                                this.countries[j] = {id: continents[i].active_countries[key], name: key};
                                j++;
                            }
                        }
                        
                    }
                    
                }
            }
        },
       
    }

</script>
