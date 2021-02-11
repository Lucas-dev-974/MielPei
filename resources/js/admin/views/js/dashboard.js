import Axios from "axios";
import DeleteUser from '../../components/delete-user-modal.vue'
import UpdateUser from '../../components/update-user-modal.vue'
import Alert from '../../../services/alert.vue'
export default{
    components:{
        DeleteUser,
        UpdateUser,
        Alert,
    },

    data() {
        return {
            admin: [],
            users: [],
            role: 'user',
            isConnect: false,
            alert: {
                state: false,
                msg: '',
                type: {}
            }
        }
    },

    watch: {
        role: function() {
            this.getUsersList()
        }
    },

    created() {
       this.isConnected();
    },

    methods: {
        isConnected: function(){
            Axios.get('/api/auth/validToken').then(({data}) => {
                if(!data.success || data.user.role !== 'admin'){
                    location.href = "/"
                }else{
                    this.admin = data.user
                }
            })
            this.getUsersList()
        },

        getUsersList: function(){
            Axios.post('/api/admin/get-users-by-role', {role: this.role}).then(({data}) => {
                if(data.success){
                    this.users = data.users
                }else{
                    this.alert.open = true
                    this.alert.msg  = data.error.map(({data}) => {
                        return data
                    })
                }

            })
        },

        updateActiveAccount: function(user_id, state){
            Axios.post('/api/admin/disable-users-account', {state: state, user_id: user_id})
        }

        
    },
}