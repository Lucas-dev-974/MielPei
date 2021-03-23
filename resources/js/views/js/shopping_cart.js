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
        this.get_Product()
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

        get_Product: function(){
            this.panier = []
            Axios.get('/api/shopping-card/get-non-buyed-products')
            .then(({data}) => {
                if(data.success){
                    this.panier = data.cards
                }
            })
        }
    },
}