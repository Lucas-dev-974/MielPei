<template>
     <v-container class="mt-10">
        <div class="d-flex justify-center">
            <h3>Les derniers produits</h3>
        </div>
        <v-row>
            <template v-for="product in products">
                <v-col :key="product.id"> 
                    <ProductView :product='product' :user='user'/>
                </v-col>
            </template>
      </v-row>
    </v-container>
</template>

<script src="./js/producer_product.js"></script>