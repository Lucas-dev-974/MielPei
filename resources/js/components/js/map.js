import Vue from 'vue';
import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';

export default{
    components: {
        LMap,
        LTileLayer,
        LMarker,
    },

    data() {
        return {
            url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            zoom: 11,
            center: [-21.114533, 55.532062499999995],
        }
    },

    created() {
        this.init_map()
    },
    methods: {
        init_map: function(){
            
        }
    },
}
