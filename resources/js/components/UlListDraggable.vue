<template>

    <draggable class="menuItemsList my-4" v-model="testimonialsNew" :options="{animation:200}" @start="drag=true" @end="onEnd" :move="update" :component-data="getComponentData()">
        <div class="row p-1" v-bind:id="index" v-bind:class="{'bg-light': index % 2 === 0, 'bg-white': index % 2 !== 0 }" v-for="(element, index) in testimonialsNew" :key="element.id">
            <div class="col-12 py-3 title"><i class="far fa-arrows-alt-v float-right border px-2 py-1 text-secondary"></i><a :href="'/menuItems/'+element.id+'/edit'">{{element.name}}</a></div>
            <div class="col-12 pb-2 action">
                <form :action="'/'+localCode+'/menuItems/'+element.id" method="POST">
                    <a :href="'/menuItems/'+element.id+'/edit'" class="btn btn-primary">Modifica</a> 
                    <input type="hidden" name="_token" :value="csrf"> 
                    <input type="hidden" name="_method" value="DELETE"> 
                    <button type="submit" class="btn btn-danger float-right">Cancella</button>
                </form>
            </div>
            <local-draggable v-if="element.testimonialsNew" :testimonialsNew="element.testimonialsNew" > 
            </local-draggable>
        </div>
    </draggable>

</template>

<script>
    // Example of draggable - https://github.com/David-Desmaisons/draggable-example/blob/master/src/components/Hello.vue#L57
    // https://github.com/SortableJS/Vue.Draggable
    // Options for the draggable: https://github.com/SortableJS/Sortable#options
    
    import draggable from 'vuedraggable'
    export default {
        props : [
            'testimonials',
            'locale',
        ],
        components: {
            draggable
        },
        mounted() {
            console.log('Component UlListDraggable mounted.');
            //console.log(this.locale);
            //console.log(this.testimonials);
        },
        data() {
            //console.log(this.testimonials);
            return {
                testimonialsNew: this.testimonials,
                csrf: document.head.querySelector('meta[name="csrf-token"]').content,
                localCode: this.locale
            }
        },
        methods: {
            update(event) {
                //console.log("update");
            },
            onEnd: function (/**Event*/evt) {
        		console.log("END!!!!");
                console.log(this.testimonialsNew);
                /*var itemEl = evt.item;  // dragged HTMLElement
        		evt.to;    // target list
        		evt.from;  // previous list
        		evt.oldIndex;  // element's old index within old parent
        		evt.newIndex;  // element's new index within new parent*/
                axios.put('/menuItem/updateOrder', {
                    items: this.testimonialsNew
                }).then((response) => {
                    // success message
                })
                
                
        	},
            handleChange() {
              console.log('changed');
              //console.log(this.testimonialsNew);
              
              //console.log(event);
              //console.log(event.dragged.id);
              
              /*var orderElementPosition = event.dragged.id;
              var elementId = event.draggedContext.element.id;
              event.draggedContext.element.order = event.dragged.id;
              
              console.log(orderElementPosition);
              console.log(elementId);*/
              
              
            },
            inputChanged(value) {
              this.activeNames = value;
              console.log("eeeee");
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
            },
            
            
            
        },
        
    }
</script>
