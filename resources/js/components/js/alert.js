export default{
    data() {
        return {
            alert: false,
            alert_msg: ''
        }
    },

    mounted() {
        this.AlertHandle()
    },

    methods: {
        AlertHandle: function(){
            this.alert = !this.alert;
        },
    },
}