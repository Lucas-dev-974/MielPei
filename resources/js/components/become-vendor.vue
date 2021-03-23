<template>
    <v-dialog v-model="modal"  class="m-0 p-0" max-width="450">
        <template v-slot:activator="{ on, attrs }">
            <v-btn class="ml-3" x-small  color="success" v-bind="attrs" v-on="on">
                Je souhaite passer au status de producteur
            </v-btn>
        </template>

        <v-card>
            <v-card-title>
                Devenir producteur
            </v-card-title>
            <v-container class="">
                <p>Veuillez nous renseigner quelques informations pour devenir producteur</p> 
                <v-text-field label="Le nom de votre boutique" v-model="shop_name"></v-text-field>
                <v-text-field label="Localisation de votre production" v-model="cultur_coordinate"></v-text-field>
                <v-btn small block elevation="3" color="success" @click="add_Vendor">Valider</v-btn>
            </v-container>
            
        </v-card>
    </v-dialog>
</template>

<script src="./js/become-vendor.js"></script>