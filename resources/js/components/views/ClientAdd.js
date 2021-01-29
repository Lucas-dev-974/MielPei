import Axios from "axios"

export default{
    props: {
        IsClientValid: {
            required: true
        }
    }, 


    data() {
        return {
            name: '',
            lastName: '',
            email: '',
            modal: false
        }
    },

    methods: {
        AddClient: function(){
            if(this.name.length > 0){
                if(this.lastName.length > 0){
                    Axios.post('/api/clients/add', {nom: this.name, prenom: this.lastName})
                    .then(({data})=> {
                        console.log(data);
                        if(data.success == true){
                            this.modal = false
                        }
                    })
                }
            }
        }
    },
}