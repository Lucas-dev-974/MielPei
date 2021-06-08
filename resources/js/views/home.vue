<template>
  <div>
    <NavBar  />
    <v-container v-if="$store.state.page === 'home'" >
      <v-row style="height: 450px"  >
          <h3 class="text-left my-2 fp-nunito">Points de vente de nos agriculteurs</h3>  
          <Map />
      </v-row>

      <v-row>
        <p class="fs-3 mt-10 text-center fp-nunito">Retrouvez les meilleurs produits vendues</p>
        <template v-for="product in $store.state.best_products" >
            <v-col  :key="product.id"> 
              <ProductView :product='product' />
            </v-col>
        </template>
      </v-row>
    </v-container>    

    <div v-if="$store.state.page === 'account'">
       <Account   @getBestProduct="getBestProduct" /> 
    </div>

    <div v-if="$store.state.page === 'producer_product'">
      <ProducerProduct />
    </div>
  </div>

</template>

<script src='./js/home.js'></script>