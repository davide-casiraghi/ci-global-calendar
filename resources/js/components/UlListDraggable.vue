<template>

    <draggable class="menuItemsList my-4" v-model="testimonialsNew" :options="{animation:200}" @start="drag=true" @end="drag=false" :move="update" :component-data="getComponentData()">
        <div class="row p-1" v-bind:id="index" v-bind:class="{'bg-light': index % 2 === 0, 'bg-white': index % 2 !== 0 }" v-for="(element, index) in testimonialsNew" :key="element.id">
            <i class="fas fa-ellipsis-v"></i> {{element.name}} - {{element.id}}
        </div>
    </draggable>

</template>

<script>
    // https://github.com/SortableJS/Vue.Draggable
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
                //console.log("update");
                
                
                
            },
            handleChange() {
              //console.log('changed');
              
              console.log(this.testimonialsNew);
              //console.log(event);
              //console.log(event.dragged.id);
              
              /*var orderElementPosition = event.dragged.id;
              var elementId = event.draggedContext.element.id;
              event.draggedContext.element.order = event.dragged.id;
              
              console.log(orderElementPosition);
              console.log(elementId);*/
              
              axios.put('/menuItem/updateOrder', {
                  items: this.testimonialsNew
              }).then((response) => {
                  // success message
              })
            },
            inputChanged(value) {
              this.activeNames = value;
            },
            getComponentData() {
              return {
                on: {
                  change: this.handleChange,
                  input: this.inputChanged
                },
                props: {
                  value: this.activeNames
                }
              };
            }
        },
        
    }
</script>
