<template>
     <v-container class="mt-5">
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