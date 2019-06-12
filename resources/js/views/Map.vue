<template>
    <div class="map"></div>
</template>
<script>
    import gmapsInit from '../utilities/gmaps';

    export default {        
        async mounted() {
            try {
            const google = await gmapsInit();
            const geocoder = new google.maps.Geocoder();
            const map = new google.maps.Map(this.$el);

            geocoder.geocode({ address: 'Stuttgart' }, (results, status) => {
                if (status !== 'OK' || !results[0]) {
                    throw new Error(status);
                }

                map.setCenter(results[0].geometry.location);
                map.fitBounds(results[0].geometry.viewport);
            });
            } catch (error) {
                console.error(error);
            }
        },
        
    }

</script>
<style>
    .map{
        height: 100vh;
    }
</style>

