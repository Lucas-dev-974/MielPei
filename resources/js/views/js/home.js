import Axios from 'axios'

// Pages
import VendorShop from '../vendor_shop.vue'
import Account    from '../account.vue'

// Components
import NavBar from '../../components/navbar-menu.vue'
import Map         from '../../components/map.vue'
import ProductView from '../../components/product-view.vue'

 
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
            isConnect: false
        }
    },

    created() {
       this.isConnected();
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
                }
            })
        },

        logout: function(){
            this.isConnect = false
            localStorage.clear()
            Axios.post('/api/auth/logout').then(({data}) => {
                console.log(data);
            })
        }

        
    },
}