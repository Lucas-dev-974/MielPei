<template>
    <div class="text-center">
    <v-dialog v-model="modal" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn  outlined x-small v-bind="attrs" v-on="on">
          <small>détails</small>
        </v-btn>
      </template>

      <v-card class="">
        <v-card-title class="headline grey lighten-2">
          Détails du produit {{ reservation.product_id.name }}
        </v-card-title>
        <div class="d-flex">
          <div class="col-4">
            <v-img :src="reservation.product_id.img_url" ></v-img>
            
          </div>
          <div class="col p-0 pt-2 pl-2">
            <div>
              <p class="fs-6">
                {{ reservation.product_id.details }}
              </p>

              <div style="bottom: 0; position: absolute;" class="d-flex">
                <small>
                  <p class="m-0 "> Producteurs : {{ reservation.vendor_id.name + " " + reservation.vendor_id.last_name}} </p>
                </small> 
                <v-btn x-small color="success">Payer le produit</v-btn>
                
              </div>
            </div>

          </div>
        </div>
      </v-card>
    </v-dialog>
  </div>
</template>

<script src="./js/product-details.js"></script>