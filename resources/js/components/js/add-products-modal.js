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
            image: null
        }
    },

    methods: {
        addProduct: function(){
            let formData = new FormData()
                formData.append('img', this.image)
                formData.append('name', this.name)
                formData.append('details', this.details)
                formData.append('quantity', this.quantity)
                formData.append('price', this.price)

            Axios.post('/api/products/add', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(({data}) => {
                if(data.success == false){  
                    Object.values(data.error).map(error => {
                        this.alert.msg += error + '\n'
                    })
                    this.alert.type = 'warning'
                    this.alert.state = true
                }else if(data.success){
                    this.modal = false
                    this.$emit("getVendorProducts")
                    this.$emit('getBestProduct')
                }
            })
        },

    },
}