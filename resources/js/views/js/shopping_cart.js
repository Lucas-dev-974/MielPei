import Axios from 'axios'
import DetailsProduct from '../../components/product-details.vue'

export default{
    components:{
        DetailsProduct
    },
    
    data() {
        return {
            panier: []
        }
    },

    mounted() {
        this.get_Products()
    },

    methods: {
        remove_Product: function(id){
            Axios.post('/api/shopping-card/remove-to-card', {card_id: id})
            .then(({data}) => {
                if(data.success){
                    let i = this.panier.indexOf(id)
                    this.panier.splice(i)
                }
            })
        },

        get_Products: function(){
            this.panier = []
            Axios.get('/api/shopping-card/get-non-buyed-products')
            .then(({data}) => {
                if(data.success){
                    this.panier = data.cards
                }
            })
        },

        update_Quantity: function(id, option){ // ID du panier, l'option de l'update (+, -) 
            console.log(id);
            Axios.post('/api/shopping-card/update-quantity', {options: option, value: 1, shopping_card_id: id})
            .then(({data}) => {
                console.log(data);
                if(data.success){
                    
                    let shopping_cart = this.panier.findIndex((obj => obj.id == id))
                    switch(option){
                        case "+": 
                            this.panier[shopping_cart].quantity += 1 // Augmente la quantité choisi pour ce produit dans le panier
                            this.panier[shopping_cart].final_price  = parseFloat(this.panier[shopping_cart].product.price) + parseFloat(this.panier[shopping_cart].final_price)  
                            break
                        case "-":
                            this.panier[shopping_cart].quantity -= 1
                            this.panier[shopping_cart].final_price  = parseFloat(this.panier[shopping_cart].product.price) - parseFloat(this.panier[shopping_cart].final_price)  
                            break
                    }
                }   
            })
        }
    },
}