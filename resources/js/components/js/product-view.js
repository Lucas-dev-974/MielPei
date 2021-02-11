import Axios from "axios"

export default{

    data() {
        return {
            
        }
    },

    mounted() {
        this.init_product()
    },
    methods: {
        init_product(){
            Axios.get('/api/products/get-best-products-sold').then(({data}) => {
                console.log(data);
            })
        }
    },
}