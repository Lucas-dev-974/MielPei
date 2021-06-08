import Axios from "axios"
import { unset } from "lodash"

export default{
    data() {
        return {
            user_roles: '',
            Connected: false,
            sub_state: false
        }
    },

    mounted() {
        console.log('navbar mounted');
    },

    methods: {
        logout: function(){
            Axios.post('/api/auth/logout')
            .then(({data}) => {
                localStorage.clear()
                location.href = "/"
                this.$store.is_logged = false
            })
        },

        show_submenu: function(){
            let submenu = document.getElementById('submenuburger');
            if(!this.sub_state){
                submenu.style.transform = 'translateY(0)'
                this.sub_state = true
            }else{
                submenu.style.transform = 'translateY(-100vh)'
                this.sub_state          = false
            }

        }
    },
}