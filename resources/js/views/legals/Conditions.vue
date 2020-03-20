<template>
    <div>
        <h1>{{ $t('conditions.conditions')}}</h1>
        <p>{{ $t('conditions.conditions_of')}}</p>
               
        
            <ol class="list-decimal" >
                <li>
                    <p class="font-bold text-lg">{{ $t('conditions.conditions_header_1')}}</p>
                    <p>{{ $t('conditions.conditions_text_1')}}</p> 
                </li>
                <li>
                    <p class="font-bold text-lg leading-tight">{{ $t('conditions.conditions_header_2')}}</p>
                    <p>{{ $t('conditions.conditions_text_2')}}</p> 
                    <p>{{ $t('conditions.conditions_text_2_1')}}</p> 
                </li>

                <li>
                    <p class="font-bold text-lg leading-tight">{{ $t('conditions.conditions_header_3')}}</p>
                    <span>{{ $t('conditions.conditions_text_3')}}</span>   
                    <a href="/pricing" class="link">https://linoffery.com/pricing</a>
                    <span>{{ $t('conditions.conditions_text_3_1')}}</span>                   
                </li>

                <li>
                    <p class="font-bold text-lg leading-tight">{{ $t('conditions.conditions_header_4')}}</p>
                    <p>{{ $t('conditions.conditions_text_4')}}</p>                     
                </li>

                <li>
                    <p class="font-bold text-lg leading-tight">{{ $t('conditions.conditions_header_5')}}</p>
                    
                    <ol class="list-decimal">
                        <li>
                            <p>{{ $t('conditions.conditions_text_5_1')}}</p>
                            <ul>
                                <li><p>{{ $t('conditions.conditions_text_5_1_a')}}</p></li>
                                <li><p>{{ $t('conditions.conditions_text_5_1_b')}}</p></li>
                                <li><p>{{ $t('conditions.conditions_text_5_1_c')}}</p></li>
                            </ul>                             
                        </li>
                        <li><p>{{ $t('conditions.conditions_text_5_2')}}</p></li>
                        <li><p>{{ $t('conditions.conditions_text_5_3')}}</p></li>
                        <li><p>{{ $t('conditions.conditions_text_5_4')}}</p></li>
                        <li><p>{{ $t('conditions.conditions_text_5_5')}}</p></li>
                        <li><p>{{ $t('conditions.conditions_text_5_6')}}</p></li>
                    </ol>            
                </li>

                <li>
                    <p class="font-bold text-lg leading-tight">{{ $t('conditions.conditions_header_6')}}</p>
                    <p>{{ $t('conditions.conditions_text_6')}}</p>  
                </li>

                <li>
                    <p class="font-bold text-lg leading-tight">{{ $t('conditions.conditions_header_7')}}</p>
                    <span>{{ $t('conditions.conditions_text_7')}}</span>  
                    <a href="/privacy" class="link">https://linoffery.com/privacy</a> 
                    <span>{{ $t('conditions.conditions_text_7_1')}}</span>                     
                </li>
               
            </ol>
    </div>
</template>
