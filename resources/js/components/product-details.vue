<template>
  <v-dialog v-model="modal" min-width="200" max-width="350">
    <template v-slot:activator="{ on, attrs }">
      <v-btn  outlined x-small v-bind="attrs" v-on="on">
        <small>détails</small>
      </v-btn>
    </template>

    <v-card class="">
      <v-img :src="reservation.product.url_img" ></v-img>
      <v-container grid-list-xs>
        <p class="fs-6 mb-0">{{ reservation.product.name}} - {{ reservation.final_price}} €</p>
        <small ><p>Prix du produit: {{reservation.product.price}} </p> </small>
        <small><p>Producteur: {{reservation.vendor.userz.name}}</p></small>
      </v-container>
    </v-card>
  </v-dialog>
</template>

<script src="./js/product-details.js"></script>