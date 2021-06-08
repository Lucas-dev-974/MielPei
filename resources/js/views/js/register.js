import Axios from "axios";
import Alert from "../../services/alert.vue"

export default{
    components: {
        Alert
    },

    data() {
        return {
            alert_state: false,
            alert_msg: '',
            alert_type: '',
            name: '',
            last_name: '',
            phone: '',
            email: '',
            password: '',
            password_confirm: ''
        }
    },

    mounted() 
    {
        Axios.get('/api/auth/validToken').then(({data}) => {
            if(data.success){
                location.href = '/'
            }
        })
    },

    methods: {
        register: function(){
            console.log(this.$store.state.user);
            Axios.post('/api/auth/register', {
                name: this.name,
                last_name: this.last_name,
                email: this.email, 
                password: this.password,
                password_confirm: this.password_confirm,  
                phone: this.phone
            })                
            .then(({data}) => {
                console.log(data);
                if(!data.success){
                    this.alert_state = true
                    this.alert_msg   = data.errors
                    this.alert_type  = "error"
                }else{
                    Axios.defaults.headers.common = {'Authorization': `bearer ${data.token}`}   
                    this.$store.commit('set_user', data.user)
                    console.log(this.$store.state.user);
                    // location.href = '/'
                }
            }).catch(error => {
                console.log(error);
            })
        }
    },
}