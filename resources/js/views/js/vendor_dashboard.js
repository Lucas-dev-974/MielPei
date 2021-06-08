import Axios from 'axios'
import AddProdcust from '../../components/add-products-modal.vue'
import Alert from '../../services/alert.vue'
import UpdateProduct from '../../components/update-product.vue'
import DeleteProduct from '../../components/delete-product.vue'

export default{
    components: {
        AddProdcust,
        Alert,
        UpdateProduct,
        DeleteProduct
    },

    data() {
        return {
            alert: {
                type: '',
                msg:  '',
                state: ''
            },
        }
    },

    mounted() {
        this.get_Products()
    },

    methods: {
        get_Products: function(){
            this.products = []
            Axios.get('/api/products/get-my-products')
            .then(({data}) => {
                this.$store.commit('set_vendor_products', data.products)
            })
        },

        update_quantity: function(options, product_id){
            let products_options = [ options, product_id ];
            this.$store.commit('update_quantity_vp', products_options)
        },
    },
}