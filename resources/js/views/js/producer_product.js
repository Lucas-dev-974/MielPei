import axios from "axios"
import ProductView from "../../components/products-view.vue"
export default{
    components: {
        ProductView
    },

    props: {
        user: { required: true }
    },

    data() {
        return {
            products: []
        }
    },

    mounted() {
        this.get_Products()
    },

    methods: {
        get_Products: function(){   
            this.products = []
            axios.get('/api/products/get?products_limit_per_page=10')
            .then(({data}) => {
                this.products = data
            })
        },

    },
}