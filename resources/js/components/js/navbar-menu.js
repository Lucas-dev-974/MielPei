import { unset } from "lodash"

export default{
    props:{
        isConnect: Boolean,
        user_role: String
    },
    
    data() {
        return {
            
        }
    },

    methods: {
        logout: function(){
            this.$emit('logout')
        }
    },
}