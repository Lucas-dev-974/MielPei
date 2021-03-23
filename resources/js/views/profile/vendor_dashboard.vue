<template>
    <div class="border">
        <div style="position: absolute; top: 20px;">
            <Alert id='test' :state='alert.state' :msg='alert.msg' :type='alert.type' /> 
        </div>
        <div class="d-flex justify-content-center" >
            <p class="fs-6 border-bottom  text-center "> {{user.vendor.shop_name}} </p>
        </div>

        <div class="d-flex justify-content-center">
           <AddProdcust :alert='alert' @getVendorProducts='get_Products'/> 
        </div>

         <v-simple-table>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-left col"> Nom </th>
                            <th class="text-left col"> Prix  </th>
                            <th class="text-left col"> Quantité  </th>
                            <th></th>
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
                                <UpdateProduct :product="product"  @getVendorProducts='get_Products'/> 
                                <DeleteProduct :product='product' @getVendorProducts="get_Products" />
                            </td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>
    </div>
</template>

<script src='../js/vendor_dashboard.js'></script>