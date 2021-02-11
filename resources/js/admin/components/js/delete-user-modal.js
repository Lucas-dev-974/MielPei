import Axios from "axios";

export default{
    props: {
        user: {
            required: true
        }
    },
    data(){
        return{
            modal: false,
        }
    },
    methods: {
        deleteUser: function(){
            console.log(this.user);
            Axios.post('/api/admin/delete-users-account', {user_id: this.user.id})
            .then(({data}) => {
                console.log(data);
            })
        }
    }
}