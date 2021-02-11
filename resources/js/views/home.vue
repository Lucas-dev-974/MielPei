<template>
  <div class="">
    <NavBar />
    <v-tabs  centered>
        <v-tab @click="pages='home'">Acceuil</v-tab>
        <v-tab @click="pages='Nos vendeur'">Nos vendeur</v-tab>
        <v-tab @click="pages='Mon compte'">Mon compte</v-tab>
    </v-tabs>
    <v-container v-if="pages === 'home'" class="">
      <v-row style="height: 500px">
          <h3 class="text-center my-2">Découvrez les points de vente de nos agriculteurs</h3>  
          <Map />
      </v-row>

      <v-row>
        <ProductView />
      </v-row>
    </v-container>    
  </div>

</template>

<script src='./js/home.js'></script>