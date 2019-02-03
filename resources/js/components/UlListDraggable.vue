<template>

    <draggable v-model="testimonialsNew" :options="{group:'people'}" @start="drag=true" @end="drag=false">
        <div v-for="element in testimonialsNew" :key="element.id">{{element.name}}</div>
    </draggable>

</template>

<script>
    import draggable from 'vuedraggable'
    export default {
        components: {
            draggable
        },
        props : [
            'testimonials',
        ],
        mounted() {
            console.log('Component mounted.');
            //console.log(this.testimonials);
        },
        data() {
            return {
                testimonialsNew: this.testimonials.data,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content
            }
        },
        methods: {
            update() {
                console.log("update");
                this.testimonialsNew.map((testimonial, index) => {
                    testimonial.order = index + 1;
                })
                /*axios.put('/admin/testimonials/updateAll', {
                    testimonials: this.testimonialsNew
                }).then((response) => {
                    // success message
                })*/
            }
        },
        
    }
</script>
