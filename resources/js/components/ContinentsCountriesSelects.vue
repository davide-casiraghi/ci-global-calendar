<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
                        <ul>
                            <li v-if="continents.length>0" v-for="continent in continents">
                              {{ continent.name }}
                            </li>
                        </ul>
                        
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
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
