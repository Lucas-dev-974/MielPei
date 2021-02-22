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

    methods: {
        updateName(){
            Axios.post('/api/products/update', {row_name: 'name', value: this.newName, product_id: this.product.id})
            .then(({data}) => {
                if(data.success){
                    this.modal = false
                    this.$emit('getVendorProducts')
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
            console.log('price')
            Axios.post('/api/products/update', {row_name: 'price', value: this.newPrice, product_id: this.product.id})
            .then(({data}) => {
                console.log(data);
                if(data.success){
                    this.modal = false
                    this.$emit('getVendorProducts')
                }
            })
        },

        updateQuantity(){   
            Axios.post('/api/products/update', {row_name: 'quantity', value: this.newQuantity, product_id: this.product.id})
            .then(({data}) => {
                console.log(data);
                if(data.success){
                    this.modal = false
                    this.$emit('getVendorProducts')
                }
            })
        }
    },
}