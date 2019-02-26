<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Example Component</div>

                    <div class="card-body">
                        I'm an example component.
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
        },
        created(){
            axios.get('/api/continents')
              .then(function (response) {
                // handle success
                console.log(response);
                this.retrievedContinents = response.data;
              })
              .catch(function (error) {
                // handle error
                console.log(error);
              })
              .then(function () {
                // always executed
              });
        },
        
        data() {
            retrievedContinents: {}
            //console.log(continents);
           
            return {
                continents: this.retrievedContinents,
            }

       }
    }
    /*
    function getContinents(){
        // Make a request for a user with a given ID
         axios.get('/api/continents')
           .then(function (response) {
             // handle success
             console.log(response);
           })
           .catch(function (error) {
             // handle error
             console.log(error);
           })
           .then(function () {
             // always executed
           });
           
           return "aaa";
    }
    */
    
</script>
