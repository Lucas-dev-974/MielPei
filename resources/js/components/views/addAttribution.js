import Axios from 'axios'
import { isArray, isEmpty } from 'lodash'

export default{
    props: {
        ordinateur: {
           required: true
       },

       horraire: {
           required: true
       },

       date: {
           required: true
       }

    },

    data(){
        return{
            modal:     false,
            input:     null,
            model:     {},

            clients: [],
            validClient: true
            
        }
    },

    watch:{
        input(val){
            if(val && val.length > 2){
                Axios.get('/api/clients/search', { params: {inputName: val}})
                .then(({data}) => {
                    data.forEach(element => {
                        this.clients.push(this.makeClient(element))
                    })
                })
            }  
            this.validClient = (!isEmpty(this.model.name) && !isEmpty(this.model.ls_name) ? false : true)
        }
    },

    methods:{  
        attribute() {
            Axios.post('/api/attributions?date=' + this.date + "&heure=" + this.horraire.index + "&id_ordi=" + this.ordinateur + "&id_client=" + this.model.id)
            .then(response => {
                console.log(response.data)
                this.$emit('AddAttribution', this.AttrClient(response.data.id))
                this.modal = false
            }).catch(error => {
                console.log(error.response.data)
            })
        },

        makeClient(client){
            return {
                id:       client.id,
                name:     client.nom,
                ls_name:  client.prenom,
                all_name: client.nom + ' ' + client.prenom,
            }
        },

        AttrClient(attr_id){
            return{
                id:            attr_id,
                id_client:     this.model.id,
                id_ordinateur: this.ordinateur,
                horraire:      this.horraire.index,
                date:          this.date,
                client_name:     this.model.name,
                client_lst_name: this.model.ls_name,
            }
        },

        AddClient(){
            console.log(this.input)
            let name = this.input
            name = name.split(' ')
            console.log(name)
        }
    }
}