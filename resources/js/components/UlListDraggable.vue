<template>

    <draggable class="menuItemsList my-4" v-model="testimonialsNew" :options="{animation:200}" @start="drag=true" @end="drag=false" :move="update">
        <div class="row p-1" v-bind:id="index" v-bind:title="element.id" v-bind:class="{'bg-light': index % 2 === 0, 'bg-white': index % 2 !== 0 }" v-for="(element, index) in testimonialsNew" :key="element.id">
            <i class="fas fa-ellipsis-v"></i> {{element.name}} - {{element.id}}
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
            update(event) {
                console.log("update");
                console.log(this.testimonialsNew);
                //console.log(event);
                //console.log(event.dragged.id);
                
                var orderElementPosition = event.dragged.id;
                var elementIndex = event.dragged.title;
                
                console.log(orderElementPosition);
                console.log(elementIndex);
                
                
                
                
                
                axios.put('/menuItem/updateOrder', {
                    testimonials: this.testimonialsNew
                }).then((response) => {
                    // success message
                })
                
                /*this.testimonialsNew.map((testimonial, index) => {
                    testimonial.order = index + 1;
                })
                axios.put('/menuItems/updateOrder', {
                    testimonials: this.testimonialsNew
                }).then((response) => {
                    // success message
                })*/
            },
            onMoveCallback(evt, originalEvent){
               console.log("ciao22");
           },
           handleChange() {
             console.log('changed');
           },
        },
        
    }
</script>
