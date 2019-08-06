<template>
    <default-modal
        :name="'create-tender'"
        @close="$modal.hide('create-tender')"
    >
        <h1 class="text-xl text-teal-500 mb-5">New Tender</h1> 
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
