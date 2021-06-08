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
                console.log(data);
                this.$store.commit('set_islogged', true)
                this.$store.commit('set_user',     data.user)
                this.$store.commit('set_token',    data.token.original.access_token)
                location.href = '/'
            }).catch(error => {
                this.alert_msg = "Email ou mot de passe incorrect"
                this.alert = !this.alert
            })
        }
    },
}