import Axios from "axios"

export default{
    data() {
        return {
            modal: false,
            shop_name: "",
            cultur_coordinate: ""
        }
    },


    methods: {
        add_Vendor(){
            if(this.shop_name){
                Axios.post('/api/vendors/add', {cultur_coordinate: this.cultur_coordinate, shop_name: this.shop_name})
                .then(({data}) => {
                    console.log(data);
                    if(data.success){
                        this.modal = false
                        document.location.reload()
                    }
                })
            }
        }
    },
}