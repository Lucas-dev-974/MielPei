import VendorDash from '../profile/vendor_dashboard.vue'
import Commands   from '../profile/commands.vue'
import ShoppingCart from '../profile/shopping_cart.vue'

export default{

    components:{
        VendorDash,
        Commands,
        ShoppingCart,
    },

    props:{
        user:{ required: true }, 
        panier: { required:true }
    },

    data() {
        return {
            page: "panier",
            profile: true,
            
        }
    },

    methods: {
        updatePanier: function(){
            this.$emit('updatePanier')
        }
    },
}