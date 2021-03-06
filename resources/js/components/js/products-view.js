import Axios from "axios"

export default{
    props:{
        product: { required: true },
    },

    data() {
        return {
            added: false,
            quantity_to_add: 1,
            notif_msg: "",
            msg_color: ""
        }
    },
    
    methods: {
    reserve (msg) {
        this.added = true
        this.notif_msg = msg
        setTimeout(() => (this.added = false), 2000)
    },

    addToShoppingCard(){
        Axios.post('/api/shopping-card/add', {
            vendor: this.product.vendor.id,
            quantity: this.quantity_to_add,
            product_id: this.product.id,
            price: this.product.price,
            img: this.img
        }).then(({data}) => {
            console.log(data);
            if(data.success){
                this.msg_color = "success"
                this.reserve("Produit ajouté au panier")

            }else{
                if(!data.success && data.error === "unauthorized"){
                    this.msg_color = "danger"
                    this.reserve("Veuillez vous connectez !")
                }
            }
        })
    }
    },
  
}