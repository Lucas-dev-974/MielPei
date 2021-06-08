import Vuex from 'vuex'
import VuePersist from 'vuex-persist'
import Vue from 'vue'
import Axios from 'axios'
Vue.use(Vuex)

const vuexLocal = new VuePersist({
    storage: window.localStorage
})
export default new Vuex.Store({
    plugins: [vuexLocal.plugin],

    state: {
        token: null,
        is_logged: false,
        userinfos: null,

        page: "home",

        shopping_card: [],
        best_products: [],
        vendor_products: [],
    },

    mutations: {
        set_token(state, token){
            state.token = token
        },

        del_token(state){
            state.token = null
        },
        
        set_user(state, data){
            state.userinfos = data
        },

        update_test(state, new_data){
            state.test = new_data
        },

        change_page(state, page){
            state.page = page
        },

        set_islogged(state, value){
            state.is_logged = value
        },

        set_best_products(state, products){
            state.best_products = products
        },

        set_vendor_products(state, products){
            state.vendor_products = products
        },
        
        update_quantity_vp(state, products_options){
            console.log(products_options);
            Axios.post('/api/products/update', { row_name: 'quantity', value: products_options[0], product_id: products_options[1]})
            .then(({data}) => {
                if(data.success){
                    for(let i = 0; i < state.vendor_products.length; i++){
                        if(state.vendor_products[i].id === products_options[1]){
                            let options = products_options[0].split(':')
                            switch(options[0]){
                                case '+':
                                    state.vendor_products[i].quantity += 1
                                    break

                                case '-':
                                    state.vendor_products[i].quantity -= 1
                                    break
                            }
                            
                        }
                    }
                }else{
                    
                }
            })
        }
    },
    
})