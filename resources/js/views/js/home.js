import Axios from 'axios'

// Pages
import VendorShop from '../vendor_shop.vue'
import Account    from '../profile/account.vue'

// Components
import NavBar from '../../components/navbar-menu.vue'
import Map         from '../../components/map.vue'
import ProductView from '../../components/products-view.vue'

 
export default{
    components:{
        VendorShop,
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

    created() {
       this.isConnected();
       
    },

    mounted() {
        let defaultPages = localStorage.getItem('defaultPages')
        if(defaultPages){
            this.pages = defaultPages
        }
        this.getBestProduct()
        this.updatePanier()
    },

    methods: {
        isConnected: function(){
            Axios.get('/api/auth/validToken')
            .then(({data}) => {
                if(!data.success){
                    this.isConnect = false
                }
                if(data.success){
                    this.isConnect = true
                    this.user = data.user
                    if(data.user.role == 'vendor' || data.user.role == 'admin'){
                        this.getVendor()
                    }
                }
            })
        },

        getVendor: function(){
            Axios.get('/api/vendors/get').then(({data}) => {
                this.user.vendor = data.vendor
            })
        },

        logout: function(){
            this.isConnect = false
            localStorage.clear()
            Axios.post('/api/auth/logout')
        },

        setDefaultPages: function(){
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

        updatePanier: function(){
            this.panier = []
            Axios.get('/api/shopping-card/get-non-buyed-products').then(({data}) => {
                if(data.success){
                    this.panier = data.cards
                    console.log(this.panier);
                }
            })
        }

        
    },
}