<template>
        <v-card  dark flat height="auto" id="navbar" tile>
        <v-toolbar dense>
            <v-toolbar-title class="fp-nunito col" ><a>Miel-pei</a></v-toolbar-title>

            <div class="col-sm-8 col-md-10 col-xl-12 normal-navigation" id="navigation-bar">
                <ul>
                    <li><a class="text-#fff" @click="$store.commit('change_page', 'home')">Acceuil</a></li>
                    <li><a @click="$store.commit('change_page', 'producer_product')">Tout les produits</a></li>
                    <div v-if='$store.state.is_logged == true'>
                        <li><a @click="$store.commit('change_page', 'account')">Mon compte</a></li>
                    </div>
                </ul>
            </div>

            <div id="dsp-page-name" class="col mt-2">
                <h5>{{ $store.state.page}}</h5>
            </div>

            <div class="logged-informations col">
                <div v-if='$store.state.is_logged == true'>
                    <v-menu  offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn  id="connected-btn" color="success" icon v-bind="attrs" v-on="on">
                                <v-icon >mdi-arrow-down-drop-circle-outline</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item><a @click="logout">Se déconnecter</a></v-list-item>
                        </v-list>
                    </v-menu>
                </div>

                <div v-else >
                    <v-menu offset-y>
                        <template v-slot:activator="{ on, attrs }">
                            <v-btn id="deconnected-btn" color="error" icon v-bind="attrs" v-on="on">
                                <v-icon  color="error">mdi-arrow-down-drop-circle-outline</v-icon>
                            </v-btn>
                        </template>
                        <v-list>
                            <v-list-item><a href="/login">Se connecter</a></v-list-item>
                            <v-list-item>S'enregistrer</v-list-item>
                        </v-list>
                    </v-menu>
                </div>



                <v-btn id="menuburger-btn" icon @click="show_submenu">
                    <v-icon>mdi-dots-vertical-circle-outline</v-icon>
                </v-btn>
            </div>
        </v-toolbar>

        <div id="submenuburger" >
            <div class="close-div-btn">
                <v-btn color="error" icon @click="show_submenu">
                    <v-icon>mdi-close</v-icon>
                </v-btn>
            </div>
            <ul>
                <li><a href="#" @click="$store.commit('change_page', 'home')">Acceuil</a></li>
                <li><a href="#" @click="$store.commit('change_page', 'producer_product')">Tout les produits</a></li>
                <div v-if='$store.state.is_logged == true'>
                    <li><a href="#" @click="$store.commit('change_page', 'producer_product')">Mon compte</a></li>
                </div>
            </ul>
        </div>
  </v-card>
</template>

<script src='./js/navbar-menu.js'></script>