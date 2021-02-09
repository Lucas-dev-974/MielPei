<template>
  <div class="">
  <NavBar />
    <v-container class="">
      <v-row style="height: 500px">
          <h3 class="text-center my-2">Découvrez les points de vente de nos agriculteurs</h3>  
          <Map />
      </v-row>

      <v-row>
        
        <VendorsCard />
      </v-row>
    </v-container>    
  </div>

</template>

<script src='./js/home.js'></script>