<template>
    <div class="w-full px-5 my-10 mx-auto xl:w-1/2">
        <div class="mb-5">
            <p class="text-2xl text-teal-500 leading-tight md:text-3xl">
                {{ $t('conditions.conclusion_of_contract')}}
            </p>         
        </div>

        <div>
            <ol class="list-decimal" >
                <li><p>{{ $t('conditions.contract_text_1')}}</p> </li>
                <li><p>{{ $t('conditions.contract_text_2')}}</p> </li>
                <li><p>{{ $t('conditions.contract_text_3')}}</p> </li>
                <li><p>{{ $t('conditions.contract_text_4')}}</p> </li>
                <li><p>{{ $t('conditions.contract_text_5')}}</p> </li>
            </ol>

           <conditions></conditions>
        </div>     
    </div>    
</template>
<script>
    import Conditions from './legals/Conditions';
    export default {
        components:{Conditions},
    }
</script>