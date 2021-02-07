<template>
    <v-card color="grey lighten-4" flat height="auto" tile>
    <v-toolbar dense>
      <v-toolbar-title class="mr-4 fs-4">MielPeï</v-toolbar-title>
      <a href="#" class="fs-6 text-decoration-none mt-1">Acceuil</a>

      <v-spacer></v-spacer>

      <div v-if='!isConnect'>
        <a href="" class="fs-6 text-decoration-none mt-1">Se connecter</a> 
    </div>
      <v-menu offset-y v-else>
        <template v-slot:activator="{ on, attrs }">
            <a color="white" style="border-bottom: 1px solid red" v-bind="attrs" v-on="on">
             Mon compte
            </a>
        </template>
        <v-list >
            <v-list-item-content>
                <v-list-item-title class="text-center" v-if="user_role === 'vendor'"> <a href="#" class=" text-decoration-none mt-1">Ma boutique</a> </v-list-item-title>
                <v-list-item-title class="text-center my-2" >                         <a href="#" class=" text-decoration-none mt-1">Mes commandes</a> </v-list-item-title>
                <v-list-item-title class="text-center">                               <a href="#" class="text-danger text-decoration-none mt-1">Déconnexion</a> </v-list-item-title>
            </v-list-item-content>
        </v-list>
    </v-menu>
       
    </v-toolbar>
  </v-card>
</template>

<script src='./js/navbar-menu.js'></script>