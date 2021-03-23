export default{
    props:{
        reservation:{
            required: true
        }
    },

    data() {
        return {
            modal: false
        }
    },

    mounted() {
        console.log('reservation');
        console.log(this.reservation);
    },

    methods: {
        buy_Product: function(){
            
        }
    },
}