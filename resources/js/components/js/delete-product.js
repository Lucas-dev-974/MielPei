import Axios from "axios"

export default{
    props:{
        product:{
            required: true
        }
    },

    data() {
        return {
            modal: false,
        }
    },

    methods: {
        deleteProduct: function(){
            Axios.post('/api/products/delete', {product_id: this.product.id}).then(({data}) => {
                if(data.success){
                    this.modal = false
                    this.$emit('getVendorProducts')
                }
            })
        }
    },
}