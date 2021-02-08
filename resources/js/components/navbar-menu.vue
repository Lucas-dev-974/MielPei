<template>
    <v-card color="grey lighten-4" flat height="auto" tile>
    <v-toolbar dense>
      <v-toolbar-title class="mr-4 fs-4">MielPeï</v-toolbar-title>
      <a href="/" class="fs-6 text-decoration-none mt-1">Acceuil</a>

      <v-spacer></v-spacer>

      <div v-if='!isConnected'>
        <a href="/login" class="fs-6 text-decoration-none mt-1">Se connecter</a> 
    </div>
      <v-menu offset-y v-else>
        <template v-slot:activator="{ on, attrs }">
            <v-btn  icon v-bind="attrs" v-on="on">
                <v-icon dark icon>mdi-account-settings</v-icon>
            </v-btn>    
        </template>
        <v-list width="150px" >
            <v-list-item-content>
                <v-list-item-title class="text-center " >                         
                    <a href="#" class=" text-decoration-none mt-1">Mes commandes</a> 
                </v-list-item-title>
                <v-list-item-title class="text-center my-2" v-if="user_roles === 'vendor'">
                    <a href="/ma-boutique" class=" text-decoration-none mt-1">Ma boutique</a> 
                </v-list-item-title>
                <v-divider inset></v-divider>
                <v-list-item-title class="text-center">                               
                    <a href="#" class="text-danger text-decoration-none mt-1" @click="logout">Déconnexion</a> 
                </v-list-item-title>
            </v-list-item-content>
        </v-list>
    </v-menu>
       
    </v-toolbar>
  </v-card>
</template>

<script src='./js/navbar-menu.js'></script>