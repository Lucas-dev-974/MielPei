import Axios from "axios"
import { unset } from "lodash"

export default{
    data() {
        return {
            user_roles: '',
            Connected: false
        }
    },

    mounted() {
        console.log('navbar mounted');
        this.isConnected()
    },

    methods: {
        isConnected: function(){
            if(localStorage.getItem('token') && localStorage.getItem('user')){
                Axios.get('/api/auth/validToken')
                .then(({data}) => {
                    if(data.success){ // Si le token est valide
                        localStorage.setItem('defaultPages', 'home')
                        this.Connected = true
                        this.user = data.user
                    }else{ // Sinon si token non valide
                        this.Connected = false
                        localStorage.removeItem('defaultPages')
                        localStorage.removeItem('user   ')
                        this.pages = "home"
                    }
                })
            }
        },

        logout: function(){
            Axios.post('/api/auth/logout')
            .then(({data}) => {
                localStorage.clear()
                location.href = "/"
                this.isConnected = false
            })
        }
    },
}