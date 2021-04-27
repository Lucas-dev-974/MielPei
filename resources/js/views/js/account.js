import VendorDash from '../profile/vendor_dashboard.vue'
import Commands   from '../profile/commands.vue'
import ShoppingCart from '../profile/shopping_cart.vue'
import BecomeVendor from '../../components/become-vendor.vue'

export default{

    components:{
        VendorDash, Commands, ShoppingCart, BecomeVendor
    },

    props:{
        user:   { required: true }
    },

    data() {
        return {
            page: "panier",
            profile: true,
            
        }
    },

    mounted() {
    },

    methods: {
        updatePanier: function(){
            this.$emit('updatePanier')
        }
    },
}