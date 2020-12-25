import Axios from "axios"

export default{
    props: {
        pagination: {
            default: function(){
                return {}
            }
        },

        date: {
            default: function(){  
                return {}
            }
        }
    
    },

    methods: {
        previousPage(){
            Axios.get(this.pagination.first, {
                params: {date: this.date},
            })
            .then(({data}) => {
                this.$emit("newPage", data)
            })
        },

        nextPage(){
            console.log(this.pagination.next);
            Axios.get(this.pagination.next, {
                params: {date: this.date},
            })
            .then(({data}) => { 
                this.$emit('newPage', data)            
            })
        }
    },

}