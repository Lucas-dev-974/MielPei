import Axios from "axios"

export default{
    props:{
        product: {
            required: true
        }
    },

    data() {
        return {
            newName: '',
            newQuantity: '',    
            newPrice: '',
            newDetails: '',
            modal: false
        }
    },

    mounted() {
        this.newName = this.product.name
        this.newQuantity = this.product.quantity
        this.newPrice    = this.product.price
        this.newDetails  = this.product.details
    },

    methods: {
        updateName(){
            Axios.post('/api/products/update', {row_name: 'name', value: this.newName, product_id: this.product.id})
            .then(({data}) => {
                if(data.success){
                    this.modal = false
                    this.$emit('getVendorProducts')
                    this.product.name = this.newName
                }
            })
        },

        updateDetails(){
            Axios.post('/api/products/update', {row_name: 'details', value: this.newDetails, product_id: this.product.id})
            .then(({data}) => {
                if(data.success){
                    this.modal = false
                    this.$emit('getVendorProducts')
                }
            })
        },

        updatePrice(){
            if(this.newPrice > 0){
                Axios.post('/api/products/update', {row_name: 'price', value: this.newPrice, product_id: this.product.id})
                .then(({data}) => {
                    console.log(data);
                    if(data.success){
                        this.modal = false
                        this.$emit('getVendorProducts')
                    }
                })
            }else{
                console.log("Impossible de définir un prix négatif");
            }

        },

        updateQuantity(){   
            if(this.newQuantity > 0){
                Axios.post('/api/products/update', {row_name: 'quantity', value: this.newQuantity, product_id: this.product.id})
                .then(({data}) => {
                    console.log(data);
                    if(data.success){
                        this.modal = false
                        this.$emit('getVendorProducts')
                    }
                })
            }else{
                console.log("Impossible de définir une quantité");
            }

        }
    },
}