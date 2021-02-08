import Axios from "axios"

export default{
    data() {
        return {
            cards: []
        }
    },

    mounted() {
        this.GetCards()
    },
    
    methods: {
        GetCards: function(){
            Axios.get('/api/vendors/get-cards').then(({data}) => {
                console.log(data);
            })
        }
    },
}