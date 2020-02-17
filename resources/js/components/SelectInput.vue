<template>
    <div>
        <multiselect 
            v-model="selected" 
            :options="options" 
            track-by="name" 
            label="name" 
            :placeholder="placeholder"
            :searchable="searchable" 
            :allow-empty="true"
            :multiple="multiple"
            :taggable="multiple"
            @input="$emit('changed', selected)"
        >
             <template slot="singleLabel" slot-scope="{ option }">
                {{ option.name }}
            </template>
        </multiselect>
    </div>
    
</template>
<script>
    import Multiselect from 'vue-multiselect'

    export default {
        components: { Multiselect },

        props:['value', 'options', 'placeholder', 'multiple', 'reset', 'searchable'],

        data(){
            return{
                selected: this.value
            }
        }, 
        
        watch:{
            reset(){
                this.reset ? this.selected = null : ''
            }
        },  
        
        
        
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>
    .multiselect__tags{
        min-height: 50px;
        background-color: #e2e8f0;
        font-size: 1em;
        border-color: #e2e8f0;
        border-radius: 0.5rem;        
        padding: 10px 40px 0 16px;
    }

    .multiselect__input{
        background:  #e2e8f0;
    }

    .multiselect__select {  
        top: 4px;
    }

    .multiselect__content-wrapper {       
        border-bottom-left-radius: .5rem;
        border-bottom-right-radius: .5rem;
        z-index: 0;        
    }

    .multiselect__single {
        background: #e2e8f0;
        padding-left: 3px;
        margin-bottom: 12px;
        margin-top: 4px;
    }
    
</style>

