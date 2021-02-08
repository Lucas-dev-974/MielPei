import NavBar from '../../components/navbar-menu.vue'

export default{
    components:{
        NavBar,
    },

    data() {
        return {
            vendor_data: [],
            isTheVendor: false
        }
    },

    mounted() {
        console.log(JSON.parse(localStorage.getItem('user')));
    },

    methods: {
        getVendor: function(){

        }
    },
}