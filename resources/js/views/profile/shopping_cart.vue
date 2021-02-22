<template>
    <div class="d-flex">
        
         <v-simple-table>
                <template v-slot:default>
                    <tbody>
                        <tr v-for="reservation in panier" :key="reservation.id">
                            <td>{{ reservation.product_id.name }}</td>
                            <td>{{ reservation.product_id.price}} €</td>    
                            <td> <v-btn x-small elevation="" color="">Details du panier</v-btn>  </td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
        <div></div>
    </div>
</template>

<script src='../js/shopping_cart.js'></script>