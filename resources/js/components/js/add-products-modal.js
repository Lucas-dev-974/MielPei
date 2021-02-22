import Axios from "axios"

export default{
    props:{
        alert:{
            required: true
        }
    },

    data() {
        return {
            modal: false,
            name: '',
            details: '',
            price: 0,
            quantity: 0,
        }
    },

    methods: {
        addProduct: function(){
            Axios.post('/api/products/add', {
                name: this.name,
                details: this.details,
                price: this.price,
                quantity: this.quantity
            })
            .then(({data}) => {
                if(data.success == false){  
                    Object.values(data.error).map(error => {
                        this.alert.msg += error + '\n'
                    })
                    this.alert.type = 'warning'
                    this.alert.state = true
                }else if(data.success){
                    this.modal = false
                    this.$emit("getVendorProducts")
                }
            })
        }
    },
}