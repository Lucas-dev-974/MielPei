import Axios from "axios"

export default{
    props:{
        computer: {
            required: true
        }
    },  

    data() {
        return {
            computerName: '',
            modal: false
        }
    },

    methods: {
        Update: function(){
            if(this.computerName.length > 3){
                Axios.post('/api/ordinateurs/update', {computerID: this.computer.id, computerName: this.computerName})
                .then(({data}) => {
                    if(data.success == true){
                        this.modal = false
                        this.$emit('updateList')
                    }
                })
            }
        }   
    },
}