<template>

    <local-draggable :items="items"/>

</template>


<!--<script type="text/x-template" id="template-dra">
  
</script>-->

<script>
    // Example of draggable - https://github.com/David-Desmaisons/draggable-example/blob/master/src/components/Hello.vue#L57
    // https://github.com/SortableJS/Vue.Draggable
    // Options for the draggable: https://github.com/SortableJS/Sortable#options
    
    var local = {
      template: '#template-dra',
      props: ['items']
    };

    
    import draggable from 'vuedraggable'
    import localDraggable from './localDraggable.vue'
    
    export default {
        props : [
            'items_input',
            'locale',
        ],
        components: {
            draggable,
            localDraggable
        },
        mounted() {
            console.log('Component UlListDraggable mounted.');
            //console.log(this.locale);
            //console.log(this.items_input);
        },
        data() {
            console.log(this.items_input);
            return {
                items: this.items_input,
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
                console.log(this.items);
                /*var itemEl = evt.item;  // dragged HTMLElement
        		evt.to;    // target list
        		evt.from;  // previous list
        		evt.oldIndex;  // element's old index within old parent
        		evt.newIndex;  // element's new index within new parent*/
                axios.put('/menuItem/updateOrder', {
                    items: this.items
                }).then((response) => {
                    // success message
                })
                
                
        	},
            handleChange() {
              console.log('changed');
              //console.log(this.items);
              
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
