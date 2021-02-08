import Axios from "axios"
import { unset } from "lodash"

export default{
    
    data() {
        return {
            isConnected: false,
            user_roles: ''
        }
    },

    mounted() {
        this.init()
    },

    methods: {
        init: function(){
            Axios.get('/api/auth/validToken').then(({data}) => {
                console.log(data);
                if(data.success){
                    this.isConnected = true
                    this.user_roles = data.user.role
                }
            })
        },

        logout: function(){
            this.isConnected = false
            localStorage.clear()
            Axios.post('/api/auth/logout').then(({data}) => {
                console.log(data);
                location.href = "/"
            })
        }
    },
}