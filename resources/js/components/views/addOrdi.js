import Axios from 'axios';

export default{
    props: {
        ModalAddOrdi: {
            default: function(){
                return {};
            }
        }
    },
    data(){
        return{
            dialog: false,
            ordiNameInput: '',
        }
    },
    methods: {
        addOrdi: function(){
            name = this.ordiNameInput
            Axios.post('/api/ordinateurs/', {nom : name}).then(({ data }) => {
                this.dialog = false
                this.ordiNameInput = ''
                this.$emit('addview', data.data)
            });
        }
    }
}