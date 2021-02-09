import Axios from 'axios'
import NavBar from '../../components/navbar-menu.vue'
import VendorsCard from '../../components/vendors_card.vue'
import Map         from '../../components/map.vue'
export default{
    components:{
        NavBar,
        Map,
        VendorsCard
    },

    data() {
        return {
            user: [],
            isConnect: false
        }
    },

    created() {
       this.isConnected();
       console.log(this.isConnecta);
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