export default{
    props:{
        ordi: { required: true}
    },

    data(){
        return {
            dialog: false,
        }
    },


    methods: {
        deleteOrdinateur(){
            this.$emit('deleteOrdi', this.ordi.id)
        }
    }
}