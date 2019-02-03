<template>
    
    
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Quote</th>
                <th>Visible</th>
                <th>Order</th>
                <th>Sort</th>
            </tr>
        </thead>

        <draggable :list="testimonialsNew" :options="{animation:200, handle:'.my-handle'}" :element="'tbody'" @change="update">

            <div v-for="element in testimonialsNew" :key="element.id">{{element.name}}</div>

        </draggable>

    </table>
</template>

<script>
    import draggable from 'vuedraggable'
    export default {
        components: {
            draggable
        },
        props: ['testimonials'],
        data() {
            return {
                testimonialsNew: this.testimonials,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content
            }
        },
        methods: {
            update() {
                this.testimonialsNew.map((testimonial, index) => {
                    testimonial.order = index + 1;
                })
                axios.put('/admin/testimonials/updateAll', {
                    testimonials: this.testimonialsNew
                }).then((response) => {
                    // success message
                })
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
