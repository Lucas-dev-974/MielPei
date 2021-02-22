<template>
    <v-dialog v-model="modal" max-width="500px">
        <template v-slot:activator="{ on, attrs }">
            <v-btn style='top: -1em; margin:0; padding:0;'  icon color="red" v-bind="attrs" v-on="on" class="ml-5 mt-5">
                <v-icon icon color="orange">mdi-pencil-circle-outline</v-icon>
            </v-btn>
        </template>

        <v-card >
            <v-card-title>
               Modification de lu produit {{ product.name }}
            </v-card-title>

            <div class="mx-auto justify-content-around py-5">
                <div class="col-sm-10 mx-auto">
                    <v-text-field v-on:keyup.enter="updateName" type="text" label="Modifier le nom du produit" v-model="newName" ></v-text-field>
                    <v-text-field v-on:keyup.enter="updateDetails" type="text" label="Modifier les detailles du produit"  v-model="newDetails" ></v-text-field>
                    <div class="d-flex justify-content-around">
                        <v-text-field v-on:keyup.enter="updatePrice" type="number" label="Modifier le prix" v-model="newPrice" ></v-text-field>
                        <v-text-field v-on:keyup.enter="updateQuantity" type="number" label="Modifier la quantité"  v-model="newQuantity" ></v-text-field>
                    </div>
                </div>
            </div>
        </v-card>
    </v-dialog>
</template>

<script src='./js/update-product-name.js'></script>