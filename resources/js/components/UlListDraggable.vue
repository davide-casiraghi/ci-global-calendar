<template>

    <draggable class="menuItemsList my-4" v-model="testimonialsNew" :options="{animation:200}" @start="drag=true" @end="drag=false">
        <div class="row p-1" v-bind:class="{'light-orange': $index % 2 === 0, 'green': $index % 2 !== 0 }" v-for="(element, index) in testimonialsNew" :key="element.id">
            {{element.name}} - {{ index }}
        </div>
    </draggable>

</template>

<script>
    // Options for the draggable: https://github.com/SortableJS/Sortable#options
    
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
