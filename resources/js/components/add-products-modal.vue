<template>
    <div class="text-center">
    <v-dialog v-model="modal" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn style="margin-top: -2em" outlined x-small v-bind="attrs" v-on="on">
          <v-icon small icon>mdi-plus</v-icon> <small>ajouter un produit</small>
        </v-btn>
      </template>

      <v-card class="">
        <v-card-title class="headline grey lighten-2">
          Ajouter un produit
        </v-card-title>

        <v-text-field v-model="name" label="Nom du produit" class="px-3"  hide-details="auto"></v-text-field>
        <v-text-field v-model="details" label="Detailles du produit" class="px-3"  hide-details="auto"></v-text-field>
        <div class="d-flex justify-content-around">
             <v-text-field v-model="price" type="number"  label="Prix" class="px-3"  hide-details="auto"></v-text-field>
            <v-text-field v-model="quantity" type="number" label="Quantité" class="px-3"  hide-details="auto"></v-text-field>
        </div>
        
    
        <v-divider></v-divider>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="primary" text @click="addProduct">
            Ajouter
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script src="./js/add-products-modal.js"></script>