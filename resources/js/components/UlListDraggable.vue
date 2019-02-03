<template>
    
    
</template>

<script>
    import draggable from 'vuedraggable'
    export default {
        props : [
            'testimonials',
        ],
        components: {
            draggable
        },
        mounted() {
            console.log('Component mounted.');
            console.log(this.testimonials);
        },
        data() {
            return {
                //testimonialsNew: this.testimonials,
                //csrf: document.head.querySelector('meta[name="csrf-token"]').content
            }
        },
        methods: {
            /*update() {
                this.testimonialsNew.map((testimonial, index) => {
                    testimonial.order = index + 1;
                })
                axios.put('/admin/testimonials/updateAll', {
                    testimonials: this.testimonialsNew
                }).then((response) => {
                    // success message
                })
            }*/
        },
        
    }
</script>
