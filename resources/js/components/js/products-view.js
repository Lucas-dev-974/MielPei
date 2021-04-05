import Axios from "axios"

export default{
    props:{
        product: { required: true },
    },

    data() {
        return {
            loading: false,
            selection: 1,
        }
    },

    mounted() {
    },

    methods: {
    reserve () {
        this.loading = true
        setTimeout(() => (this.loading = false), 1500)
    },

    addToShoppingCard(){
        Axios.post('/api/shopping-card/add', {
            vendor_id: this.product.vendor_id,
            quantity: this.selection,
            product_id: this.product.id,
            price: this.product.price
        }).then(({data}) => {
            if(data.success){
                this.reserve()
            }
        })
    }
    },
  
}