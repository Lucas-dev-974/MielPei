<template>
    <v-card class="mx-auto p-0 my-10" width="auto" max-width="400" >
        <div class="bg-success text-white text-center" v-if="added" >
            <small>Produit ajouter au panier</small>
        </div>

        <v-img height="auto" width="100%" :src="product.url_img" ></v-img>

        <v-container grid-list-xs>
            <p class="fs-6 mb-0"> {{ product.name }} - {{product.price}} €</p>
            <small><p> {{ product.vendor.shop_name }} - {{ product.vendor.user.name + ' ' + product.vendor.user.last_name}} </p></small>
            
            {{product.details}}

            <div class="d-flex mt-4">
                <v-text-field class="mr-3 col-3"  v-model="quantity_to_add" type="number" label="Quantité"   hide-details="auto"></v-text-field>
                <v-btn class="mt-5 col-8" text @click="addToShoppingCard"> Ajouter au panier </v-btn>
            </div>

        </v-container>    
    </v-card>
</template>

<script src="./js/products-view.js"></script>