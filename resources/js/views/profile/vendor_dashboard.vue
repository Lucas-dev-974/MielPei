<template>
    <div class="border">
        <div style="position: absolute; top: 20px;">
            <Alert id='test' :state='alert.state' :msg='alert.msg' :type='alert.type' /> 
        </div>
        <div class="d-flex justify-content-center" >
            <p class="fs-6 border-bottom  text-center "> {{vendor.shop_name}} </p>
        </div>

        <div class="d-flex justify-content-center">
           <AddProdcust :alert='alert' @getVendorProducts='getVendorProducts'/> 
        </div>

         <v-simple-table>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-left"> Nom </th>
                            <th class="text-left"> Prix  </th>
                            <th class="text-left"> Quantité  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in products" :key="product.id">
                            <td>{{ product.name }}</td>
                            <td>{{ product.price }}</td>
                            <td>  
                                <v-icon x-small @click="increaseQuantity('-:1', product.id)">mdi-minus</v-icon>
                                {{ product.quantity }} 
                                <v-icon x-small @click="increaseQuantity('+:1', product.id)">mdi-plus</v-icon>
                            </td>
                            <td class="d-flex pr-4">
                                <UpdateProduct :product="product"  @getVendorProducts='getVendorProducts'/> 
                                <DeleteProduct :product='product' @getVendorProducts="getVendorProducts" />
                            </td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
    </div>
</template>

<script src='../js/vendor_dashboard.js'></script>