import Axios from 'axios'

export default{
    data() {
        return {
            email: '',
            password: ''
        }
    },


    methods: {
        login: function(){
            Axios.post('/api/auth/login', {
                email: this.email,
                password: this.password
            }).then(({data}) => {
                console.log(data);
                localStorage.setItem('token', data.token.original.access_token)
                localStorage.setItem('user', JSON.stringify(data.user))
                location.href = '/'
            }).catch(error => {
                console.log(error);
            })
        }
    },
}