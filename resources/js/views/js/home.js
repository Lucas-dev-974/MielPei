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
        ProducerProduct,
        Account,

        NavBar,
        Map,
        ProductView,
    },

    data() {
        return {
            pages: 'home',
            user: [],
            isConnect: false,
            defaultPage: {},
            products: [],
            panier: []
        }
    },

    mounted() {
        this.isConnected();
        let defaultPages = localStorage.getItem('defaultPages')
        if(defaultPages){
            this.pages = defaultPages
        }
        this.getBestProduct()
        console.log('home mounted');
    },

    methods: {
        isConnected: function(){
            Axios.get('/api/auth/validToken')
            .then(({data}) => {
                if(!data.success){ // Si le token n'est plus valide
                    this.isConnect = false
                    localStorage.setItem('defaultPages', 'home')
                }
                if(data.success){
                    this.isConnect = true
                    this.user = data.user
                }
            })
        },

        logout: function(){
            this.isConnect = false
            localStorage.clear()
            Axios.post('/api/auth/logout')
        },

        setDefaultPages: function(page){
            this.pages = page
            localStorage.setItem('defaultPages', this.pages)
        },

        getBestProduct(){
            this.products = []
            Axios.get('/api/products/get-best-products-sold').then(({data}) => {
                if(data.success){
                    this.products = data.products
                }
            })
        },

        
    },
}