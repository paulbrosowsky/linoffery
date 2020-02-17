<template>
    <default-modal
        :name="'create-tender'"
        @close="$modal.hide('create-tender')"
        :classes="'li-create-tender-modal'"
    >
        <h1 class="text-xl text-teal-500 my-5">{{$t('tender.new_tender')}}</h1> 
        <tender-form @cancel="$modal.hide('create-tender')"></tender-form> 

    </default-modal>
</template>
<script>
    import TenderForm from '../views/tenders/TenderForm'

    export default {

        components:{
            TenderForm
        }
        
    }
</script>
<style>
    .li-create-tender-modal .v--modal{
        overflow: visible !important;
    }
</style>


