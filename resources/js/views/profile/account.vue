<template>
    <v-container>
        <div class="d-flex" v-if="profile">
            <div class="">
                <v-avatar size="128">
                    <img src="https://cdn.vuetifyjs.com/images/john.jpg" alt="John"  >
                </v-avatar> 
                <p class="fs-3 text-center" style="margin-bottom: 0"> {{ user.name + " " + user.last_name}}</p>
            </div>

            <div class="col ml-5 ">  
                <p style="margin-left: -18px;" class="font-weight-bold">Email : {{user.email}} </p>
                <p class="font-weight-bold">Adresse : {{user.address}}</p>
                <p style="margin-left: -18px;" class="font-weight-bold"> Phone  : {{user.phone}}</p>
            </div>

        </div>

        <div v-if="user.role === 'user'">
            <BecomeVendor />
        </div>
        
        <div class="d-flex">
            <!-- Navigation -->
            <div class="d-flex justify-content-around" style="position: absolute !important;">
                <a href="#" class="nav-link " style="font-size: 12px" >
                    <span @click="page='panier'" >Panier</span> -
                    <span @click="page='commands'" >Commandes</span> 
                    <span @click="page='boutique'" @getBestProduct="$emit('getBestProduct')" v-if="user.role !== 'user'" >- Boutique</span>
                </a>
            </div> <!-- Fin Navigation -->
        </div>

        <div class="" style="padding-top: 1.8em; padding-left: 1em" v-if="page == 'panier'">
                <ShoppingCart @updatePanier='updatePanier'/>
            </div>

            <div class="" style="padding-top: 1.8em; padding-left: 1em" v-if="page == 'commands'">
                <Commands />
            </div>

            <div class="" style="padding-top: 1.8em; padding-left: 1em" v-if="page == 'boutique'">
                <VendorDash :user="user"  />
            </div>
    </v-container>
</template>

<script src='../js/account.js'></script>