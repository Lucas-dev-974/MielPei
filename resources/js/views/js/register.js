import Axios from "axios";
export default{
    data() {
        return {
            alert: false,
            alert_msg: '',
            name: '',
            last_name: '',
            phone: '',
            email: '',
            password: ''
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
            this.alert_msg = ''
            Axios.post('/api/auth/register', {name: this.name, last_name: this.last_name, email: this.email, password: this.password, phone: this.phone})
            .then(({data}) => {
                if(!data.success){
                    this.alert = true
                    if(data.error.name){
                        this.alert_msg += data.error.name
                    }if(data.error.last_name){
                        this.alert_msg += data.error.last_name
                    }if(data.error.email){
                        this.alert_msg += data.error.email
                    }
                }else{
                    Axios.defaults.headers.common = {'Authorization': `bearer ${data.token}`}        
                    localStorage.setItem('token', data.token)
                    localStorage.setItem('user', data.user)

                    location.href = '/'
                }
            }).catch(error => {
                console.log(error);
            })
        }
    },
}