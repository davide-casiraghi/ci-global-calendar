<template>
    <div>
        <div class="form-group continent_id">    
            <select name="continent_id" v-model="continent_selected" id="continent_id" class="selectpicker" data-live-search="false" v-bind:title="select_a_continent_placeholder" v-on:change="getAllCountries(continents)">
                <option v-if="continents.length>0" v-for="continent in continents" v-bind:value="continent.id">
                    {{ continent.name }}
                </option>
            </select>
        </div>
        
        <div class="form-group country_id">    
            <select name="country_id" v-model="country_selected" id="country_id" class="selectpicker" data-live-search="true" v-bind:title="select_a_country_placeholder" v-on:change="changeContinent(country_selected)">
                <option  v-for="(country, index) in optionCountries" v-bind:value="country.id" >
                    {{ country.name }}
                </option>  
            </select>
        </div>
        
    </div>
</template>

<script>
    export default {
        props : [
           'select_a_continent_placeholder',
           'select_a_country_placeholder',
           'continent-selected', 
           'country-selected',
       ],
        mounted() {
            console.log('Component mounted.');
            this.loadData();
            //console.log('Loaded datas.');
            //console.log(this.continents);
            //console.log(this.countries);
            console.log(this.select_a_continent_placeholder);
            console.log(this.select_a_country_placeholder);
            jQuery('.selectpicker').selectpicker('refresh');  // Refresh the filters when the page is loaded to show $searchContinent and $searchCountry (after the search button get pressed) 
        },
        data() {
            return {
                continents: [],  // in the console - $vm0.$children[0].$options.parent.$children[0].countries
                countries: [],
                continent_selected: this.continentSelected, // continentSelected is the kebab case that correspond to continent-selected
                country_selected: this.countrySelected,  // countrySelected is the kebab case that correspond to country-selected
            }
       },
       computed: {
           optionCountries:{   // in the console - $vm0.$children[0].$options.parent.$children[0].optionCountries 
                                        //    or - $vm0.$options.parent.$children[0].optionCountries
               get: function () {
                   //console.log("GET");
                return this.countries;
                },
                set: function (newValue) {
                    //console.log("SET");
                    //console.log(newValue);
                    this.countries = newValue;
                    setTimeout(() => {
                      jQuery('.selectpicker').selectpicker('refresh');
                    }, 500);
                }
            } 
        },
       
       
       methods: {
               
            /**
             * Load continents and countries from /api/continents API trough axios - https://github.com/axios/axios#request-config
             * Populate the continents array for the continents dropdown
             */
            loadData: function() {  // In the console - $vm0.$children[0].$options.parent.$children[0].loadData()
                axios.get('/api/continents')
                .then((response) => {
                    // handle success
                    //console.log(response.data.data);
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
            /**
             * Populate the countries array for the countries dropdown 
             * this function is also called every time the continents dropdown change
             */
            getAllCountries: function(continents) {
                //eg: //this.countries[1] = {name: 'apple', price: '10'};
                //console.log(this.continent_selected);
                //console.log(continents);
                
                var j = 0;
                this.countries = [];
                    
                for (var i = 0, len = continents.length; i < len; i++) {
                    
                    if (!this.continent_selected){
                        //console.log("No Continent selected");
                        for (var key in continents[i].active_countries) {
                            //console.log(key);
                            this.countries[j] = {id: continents[i].active_countries[key], name: key, continent_id: continents[i].id};
                            j++;
                        }
                    }
                    else{
                        //console.log("continent selected: "+ this.continent_selected);
                        for (var key in continents[i].active_countries) {
                            if (continents[i].id == this.continent_selected){
                                this.countries[j] = {id: continents[i].active_countries[key], name: key, continent_id: continents[i].id};
                                j++;
                            }
                        }
                        this.optionCountries = this.countries;
                    }
                }
            },
            
            /**
             * Select the continent that correspond to the selected country 
             * This function is called every time the countries dropdown change
             */
            changeContinent(country_id){
                
                // Get from the countries array the country object that correspond to the selected country_id
                    let obj = this.countries.find(o => o.id === country_id);  // https://stackoverflow.com/questions/12462318/find-a-value-in-an-array-of-objects-in-javascript
                    //console.log(obj);
                // Then pick its continent_id
                    //console.log(obj.continent_id);
                    //console.log(this.continent_selected);
                    
                    if (obj.continent_id != this.continent_selected){
                        this.continent_selected = obj.continent_id;
                        setTimeout(() => {
                          jQuery('.selectpicker').selectpicker('refresh');
                        }, 200);
                    }
            }
        },
       
    }

</script>
