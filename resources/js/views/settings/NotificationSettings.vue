<template>
    <div>
        <card classes="py-5 px-5 mb-5 md:px-10">
            <p class="font-bold">{{$t('settings.notifications')}}</p>
            <checkbox 
                :value="newsletters" 
                :text="$t('settings.agree_with_newsletters')"
                @toggled="toggleNewsletters"
            ></checkbox>

            <p class="ml-10 -mt-5 mb-5">{{$t('settings.newsletters_info')}}                   
            </p>
                       

        </card>
    </div>
    
</template>
<script>
    export default {
        
        props:['user'],

        data(){
            return{
                newsletters: this.user.newsletters,         
            }
        },       

        methods:{
            toggleNewsletters(){
                this.newsletters = !this.newsletters

                this.$store
                    .dispatch('toggleNewsletters')
                    .then((response) => flash(response.message))
            }
        },
        
    }
</script>
