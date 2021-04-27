<template>
    <v-card color="grey lighten-4" flat height="auto" tile>
    <v-toolbar dense>
        <v-toolbar-title class=" col-1 fs-4">Miel-Pay</v-toolbar-title>

        <v-tabs class="" center-active>
            <v-tab @click="$emit('setDefaultPages', 'home')">Acceuil</v-tab>
            <v-tab @click="$emit('setDefaultPages', 'producer_product')">Produits producteurs</v-tab>
            <v-tab v-if="Connected" @click="$emit('setDefaultPages', 'account')">Mon compte</v-tab>
        </v-tabs>
        
        <div v-if='!Connected' class="col-2 text-end">
            <a href="/login" class="fs-6 text-decoration-none mt-1">Se connecter</a> 
        </div>
        <div v-else>
            <a href="#" class="text-danger text-decoration-none mt-1" @click="logout">Déconnexion</a> 
        </div>
       
    </v-toolbar>
  </v-card>
</template>

<script src='./js/navbar-menu.js'></script>