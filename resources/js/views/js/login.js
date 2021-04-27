import Axios from 'axios'

export default{
    data() {
        return {
            email: '',     password: '',
            alert: false, alert_msg: ''
        }
    },

    mounted() 
    {
        Axios.get('/api/auth/validToken').then(({data}) => {
            if(data.success) location.href = '/'
        })
    },

    methods: {
        login: function(){
            Axios.post('/api/auth/login', {
                email: this.email,
                password: this.password
            }).then(({data}) => {
                // On sauvegarde le token et les infos utilisateur
                localStorage.setItem('token', data.token.original.access_token)
                localStorage.setItem('user', JSON.stringify(data.user))
                location.href = '/'
            }).catch(error => {
                this.alert = !this.alert
                this.alert_msg = "Email ou mot de passe incorrect"
            })
        }
    },
}