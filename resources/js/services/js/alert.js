export default{
    props: {
        state:{
            required: true
        }, 
        msg:{
            required: true
        },
        type:{
            required:true
        }
    },

    data(){
        return {
            message: [],
            alert: false
        }
    },  

    watch: {
        msg: function(newval){
            console.log(newval);
            this.reset_message()
            this.alert = true
        }
    },

    mounted(){
        this.reset_message()
    },

    methods:{
        reset_message: function(){
            if(this.msg[0]){
                this.message = []
                for(const key in this.msg[0]){
                    console.log(`${key} : ${this.msg[0][key]}`);
                    this.message.push(`${this.msg[0][key]}`)
                }
                console.log(this.message);
            }
        }
    }
}