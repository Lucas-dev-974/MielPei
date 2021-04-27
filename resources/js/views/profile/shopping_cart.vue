<template>
    <div class="d-flex">
        <v-simple-table  fixed-header dense class="w-100 border" height="300" >
            <template v-slot:default>
                <thead>
                    <tr>
                        <th class="text-left">
                            Produit
                        </th>
                        <th>
                            Quantité
                        </th> 
                        <th class="text-left">
                            Prix
                        </th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody class="w-100">
                    <tr v-for="reservation in panier" :key="reservation.id" class="">
                        <td>{{ reservation.product.name }}</td>
                        <td>  
                            <v-icon x-small @click="update_Quantity(reservation.id, '-')">mdi-minus</v-icon>
                            {{ reservation.quantity }} 
                            <v-icon x-small @click="update_Quantity(reservation.id, '+')">mdi-plus</v-icon>
                        </td>
                        <td>{{ reservation.final_price}} €</td>    
                        <td> <DetailsProduct :reservation="reservation" /> </td>
                        <td>     
                            <v-btn small icon color="">
                                 <v-icon color="red" @click="remove_Product(reservation.id)">mdi-minus</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </template>
        </v-simple-table>
    </div>
</template>

<script src='../js/shopping_cart.js'>

</script>