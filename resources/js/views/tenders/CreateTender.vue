<template>
    <section class="px-5 pb-10">        
        <p class="text-xl text-teal-500 my-5">{{$t('tender.new_tender')}}</p> 
        <tender-form></tender-form>
    </section>    
</template>
<script>
    import TenderForm from './TenderForm'; 

    export default {
        components:{         
            TenderForm,
        }, 

        created(){
            setTimeout(() => {
                // Listener in Mapped 
                Event.$emit('drawerUp')
            }, 200);
        }        
    }
</script>
