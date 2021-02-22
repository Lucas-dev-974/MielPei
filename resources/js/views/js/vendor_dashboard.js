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

    props:{
        vendor: {
            required: true
        },
    },

    data() {
        return {
            alert: {
                type: '',
                msg:  '',
                state: ''
            },
            products: []
        }
    },

    mounted() {
        this.getVendorProducts()
    },


    methods: {
        getVendorProducts: function(){
            this.products = []
            Axios.get('/api/products/get-my-products').then(({data}) => {
                console.log(data);
                this.products = data.products
                console.log(this.products);
            })
        },

        increaseQuantity: function(state, product_id){
            Axios.post('/api/products/update', { row_name: 'quantity', value: state, product_id: product_id})
            .then(({data}) => {
                if(data.success){
                    this.products.forEach(element => {
                        let options = state.split(":")
                        if(element.id === product_id && options[0] === '+'){
                            element.quantity += 1
                        }else if(element.id === product_id && options[0] === '-'){
                            element.quantity -= 1
                        }
                    });
                }
            })
        },
    },
}