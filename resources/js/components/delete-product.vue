<template>
    <v-dialog v-model="modal"  class="m-0 p-0 " >
        <template v-slot:activator="{ on, attrs }">
            <v-btn style='top: -1em; margin:0; padding:0;'  icon color="red" v-bind="attrs" v-on="on" class="ml-5 mt-5">
                <v-icon small>mdi-minus</v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-title>
               Suprimer le produit {{ product.name }}
            </v-card-title>

            <div class="d-flex justify-content-around py-5">
                <v-btn small class="" color="red"> Abandonné</v-btn>
                <v-btn small elevation="" @click="deleteProduct()" color="success">Confirmé</v-btn>
            </div>
        </v-card>
    </v-dialog>
</template>

<script src='./js/delete-product.js'></script>