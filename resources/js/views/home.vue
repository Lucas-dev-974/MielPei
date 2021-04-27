<template>
  <div class="">
    <NavBar @setDefaultPages="setDefaultPages" />
    <v-container v-if="pages === 'home'" >
      <v-row style="height: 450px"  >
          <h3 class="text-center my-2">Découvrez les points de vente de nos agriculteurs</h3>  
          <Map />
      </v-row>

      <v-row>
        <p class="fs-3 mt-5 text-center">Retrouvez les meilleurs produits vendue</p>
        <template v-for="product in products">
            <v-col :key="product.id"> 
              <ProductView :product='product' :user='user'/>
            </v-col>
        </template>
      </v-row>
    </v-container>    

    <div v-if="pages === 'account'">
       <Account :user='user'  @getBestProduct="getBestProduct" /> 
    </div>

    <div v-if="pages === 'producer_product'">
      <ProducerProduct :user="user"/>
    </div>
  </div>

</template>

<script src='./js/home.js'></script>