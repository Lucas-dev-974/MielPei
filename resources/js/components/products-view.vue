<template class="p-0">
    <v-card class="mx-auto" width="auto" max-width="300" >
        <div :class="'bg-' + msg_color + ' text-white text-center'" v-if="added" >
            <small>{{notif_msg}}</small>
        </div>

        <v-img height="auto" width="100%" class="pt-1" :src="product.url_img" ></v-img>

        <v-container grid-list-xs>
            <p class="fs-6 mb-0"> {{ product.name }} - {{product.price}} €</p>
            <small><p> {{ product.vendor.shop_name }} - {{ product.vendor.user.name + ' ' + product.vendor.user.last_name}} </p></small>
            
            <div class="d-flex justify-space-between">
                {{product.details}}
                <v-text-field class="mr-3 col-3"  v-model="quantity_to_add" type="number" label="Quantité"   hide-details="auto"></v-text-field>
            </div>
            

            <div class="d-flex mt-4">
                
                <v-btn class="mt-5" block text @click="addToShoppingCard"> Ajouter au panier </v-btn>
            </div>

        </v-container>    
    </v-card>
</template>

<script src="./js/products-view.js"></script>