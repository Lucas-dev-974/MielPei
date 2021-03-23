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

    mounted() {console.log('-----');
        console.log(this.product);
        console.log(this.panier);
        console.log(this.user);
    },

    methods: {
    reserve () {
        this.loading = true
        setTimeout(() => (this.loading = false), 1500)
    },

    addToShoppingCard(){
        console.log(this.product.id);
        Axios.post('/api/shopping-card/add', {
            vendor_id: this.product.vendor_id,
            quantity: this.selection,
            product_id: this.product.id,
            price: this.product.price
        }).then(({data}) => {
            console.log(data);
            if(data.success){
                this.reserve()
                this.$emit('updatePanier')
            }
        })
    }
    },
  
}