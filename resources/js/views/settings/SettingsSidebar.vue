<template>
    <div>
        <h1 class="text-gray-700 font-light text-2xl mb-5">
            {{$t('settings.settings')}}
        </h1>
        <tabs>
            <tab :name="$t('settings.account')" hash="#account"> </tab>
            <tab :name="$t('settings.company')" hash="#company"> </tab>           
            <tab :name="$t('settings.invoices')" hash="#invoices"> </tab>
            <tab :name="$t('settings.notifications')" hash="#notification"> </tab>            
        </tabs>
    </div>
</template>
<script>
    export default {
        
    }
</script>