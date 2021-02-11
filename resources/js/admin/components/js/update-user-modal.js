import Axios from "axios";

export default{
    props: {
        user: {
            required: true
        },
        alert: {
            required: true
        },
    },

    data() {
        return {
            modal: false,
            selectRole: '',
            email: '',
            role: ['user', 'vendor', 'admin']
        }
    },

    mounted() {
        this.selectRole = this.user.role
    },
    methods: {
        updateUserEmail: function(){
            console.log(this.email);
            Axios.post('/api/admin/update-users-email', {user_id: this.user.id, user_new_mail: this.email})
            .then(({data}) => {
                if(!data.success){  
                    Object.values(data.error).map(error => {
                        console.log(error);
                        this.alert.msg += error + '\n'
                    })
                    this.alert.type = 'warning'
                    this.alert.state = true
                }else{
                    this.$emit("updateList")
                    this.modal = false
                }
            })
        },

        updateUserRole: function(){
            console.log(this.email);
            Axios.post('/api/admin/update-users-role', {user_id: this.user.id, user_new_role: this.selectRole})
            .then(({data}) => {
                if(!data.success){  
                    Object.values(data.error).map(error => {
                        console.log(error);
                        this.alert.msg += error + '\n'
                    })
                    this.alert.type = 'warning'
                    this.alert.state = true
                }else{
                    this.$emit("updateList")
                    this.modal = false
                }
            })
        }
    },
}