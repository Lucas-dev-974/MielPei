<template>
    <v-card class="mx-auto p-0 my-10" max-width="200" >
        <div class="bg-success text-white text-center" v-if="loading" >
            <small>Produit ajouter au panier</small>
        </div>
        <v-img height="135" width="100%" :src="product.url_img" ></v-img>

        <p class="fs-5 ml-4 mb-0"> {{ product.name }} - {{product.price}} €</p>
        <small><p class="ml-4">Detailles du produit</p></small>
        <v-card-text class="m-0 ml-4 p-0">
            
            {{product.details}}
        </v-card-text>

        <v-card-actions>
            <v-btn text @click="addToShoppingCard">
                Ajouter au panier
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script src="./js/products-view.js"></script>