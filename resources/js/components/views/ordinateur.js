import Axios from "axios"
import { unset } from "lodash";
import addAttribution from "./addAttribution.vue"
import deleteOrdinateur from "./deleteOrdi.vue"
import ComputerUpdate from './ComputerUpdate.vue'

export default{
    components: {
         addAttribution, deleteOrdinateur, ComputerUpdate
    },

    props: {
        ordinateur: {
            required: true
        },
        date: {
            required: true
        }
    },
    created(){
        this.initialize();
    },

    data(){
        return{
            attributions: [],
            horraire: [],
        }
    },

    methods: {
        initialize(){
            this.ordinateur.attribution.forEach(element => {
                this.attributions[element.horraire] ={
                    id:     element.id,
                    nom:    element.client.nom,
                    prenom: element.client.prenom,
                };
            });
            this.displayHorraire();
        },

        displayHorraire(){
            this.horraire = []
            let data = {} 
            for(let i = 8; i < 19; i++){
                if(this.attributions[i]){
                    data = {
                        index:       i,
                        attribution: this.attributions[i]
                    }
                }else{
                    data = {
                        index:  i,
                        attribution: ''
                    }
                }
                this.horraire.push(data);
            }   
        },

        AddAttribution(attr){
            this.attributions[attr.horraire] = {
                id:  attr.id,
                nom: attr.client_name,
                prenom: attr.client_lst_name,
            }
            this.initialize()
        },

        deleteOrdi(ordi){
            this.$emit("delOrdi", ordi)
        },

        delAttr(horraire){
            Axios.get('/api/attributions/' + this.attributions[horraire].id)
            .then(({data}) => {
                unset(this.attributions, horraire)
                this.displayHorraire()
            })
            .catch(error => {
                console.log(error)
            })
        },

        updateList: function(){
            this.$emit('init')
        }
    }
}
