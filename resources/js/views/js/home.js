import Axios from 'axios'

// Pages
import ProducerProduct from '../producer_product.vue'
import Account    from '../profile/account.vue'

// Components
import NavBar from '../../components/navbar-menu.vue'
import Map         from '../../components/map.vue'
import ProductView from '../../components/products-view.vue'

 
export default{
    components:{
        ProducerProduct, Account,
        NavBar, Map, ProductView,
    },

    data() {
        return {
            pages: 'home',
        }
    },
    
    mounted(){  
        if(this.$store.state.token) Axios.defaults.headers.common = {'Authorization': `bearer ${this.$store.state.token}`}
        if(localStorage.getItem('defaultPages')) this.pages = localStorage.getItem('defaultPages')
        this.getBestProduct()
    },

    methods: {
        getBestProduct(){
            this.products = []
            Axios.get('/api/products/get-best-products-sold').then(({data}) => {
                if(data.success){
                    this.$store.commit('set_best_products', data.products)
                    console.log(this.$store.state.best_products);
                }
            })
        },

        isConnected: function(){
            if(this.$store.state.token !== null){
                Axios.get('/api/auth/validToken')
                .then(({data}) => {
                    if(data.success){ // Si le token est valide
                        this.$store.commit('set_islogged', true)  // Met la variable de store.state.is_logged a true
                        this.$store.commit('set_user', data.user)  
                    }else{           // Sinon si token non valide
                        this.$store.commit('set_islogged', false)
                    }
                })
            }
        },
        
    },
}