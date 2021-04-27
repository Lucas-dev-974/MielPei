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
            user: [],
            products: [],
        }
    },
    
    mounted(){
        // console.log(this.$store.state.token);
        this.user = (localStorage.getItem('user')) ? JSON.parse(localStorage.getItem('user')) : null
        if(localStorage.getItem('defaultPages')) this.pages = localStorage.getItem('defaultPages')
        this.getBestProduct()
    },

    methods: {
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