import Axios from "axios"
import { unset } from "lodash";
import addAttribution from "./addAttribution.vue"
import deleteOrdinateur from "./deleteOrdi.vue"

export default{
    components: {
         addAttribution, deleteOrdinateur
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
            this.horraire = []
            this.displayHorraire();
        },

        displayHorraire(){
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

        deleteAttr(horraire){
            unset(this.horraire, horraire)
            this.initialize()
        },

        AddAttribution(attr){
            this.attributions[attr.horraire] = {
                id:  attr.id_client,
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
                this.initialize()
            })
            .catch(error => {
                console.log(error)
            })
        }
    }
}
