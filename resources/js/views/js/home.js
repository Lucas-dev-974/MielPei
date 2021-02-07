import NavBar from '../../components/navbar-menu.vue'
import Axios from 'axios'
export default{
    components:{
        NavBar
    },

    data() {
        return {
            user: [],
            isConnect: false
        }
    },

    created() {
       this.isConnected();
       console.log(this.isConnect);
    },

    methods: {
        isConnected: function(){
            Axios.get('/api/auth/validToken')
            .then(({data}) => {
                if(!data.success){
                    console.log('pas connecté');
                    this.isConnect = false
                }
                if(data.success){
                    console.log('connecté');
                    this.isConnect = true
                    this.user = data.user
                }
            })
        }
    },
}