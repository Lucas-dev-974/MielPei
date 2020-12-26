import Axios        from 'axios';
import Ordinateurs  from './ordinateur.vue';
import ModalAddOrdi from './addOrdi.vue';
import Pagination   from './paginations.vue';

import { reduceRight, unset } from 'lodash';

export default{
    components:{
        Ordinateurs, 
        ModalAddOrdi,
        Pagination
    },
    data() {
        return {
            ordinateurs: [],
            date: new Date().toISOString().substr(0, 10),
            menu: false,
            pagination: [],
        }
    },

    mounted() { this.init(); },

    methods: {
        
        init(){
            console.log('--init--');
            this.ordinateurs = []  // important pour réactualiser le tableau a chaque changement de date
            Axios.get('/api/ordinateurs', { params: {date: this.date}})
            .then(({data}) => {
                data.data.forEach(element => {
                    this.ordinateurs.push(element);
                })
                this.pagination = data.links
            })
        },

        updateViewOrdi(nomOrdi){
            return this.ordinateurs.push(nomOrdi)
        },

        delOrdi(id_ordi){
            Axios.post('/api/ordinateurs/delOrdi?id=' + id_ordi).then(({data}) => {
                unset(this.ordinateurs, id_ordi)
                this.init()
            }).catch(error => {
                console.log(error);
            })
        },

        newPage(page){
            console.log(  page.links  );
            this.ordinateurs = []
            page.data.forEach(element => {
                this.ordinateurs.push(element.data)
            });
            this.pagination = page.links
        }
    }
}