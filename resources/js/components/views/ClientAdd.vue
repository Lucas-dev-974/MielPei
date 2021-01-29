<template>
    <v-dialog v-model="modal" min-width="400px" max-width="600px">
        <template v-slot:activator="{on, attrs}">
            <v-btn  color="green" v-bind="attrs" v-on="on" class="ml-5" :disabled='!IsClientValid'>
                 Ajouter le client 
            </v-btn>
        </template>

        <v-card>
            <v-card-title class="d-flex justify-content-center">Ajouter un client</v-card-title>
            <v-container >
                <v-text-field  type="text"  placeholder="Nom" label="Nom"   v-model="name" outlined color></v-text-field>
                <v-text-field  type="text"  placeholder="Prénom" label="Prénom"   v-model="lastName" outlined color></v-text-field>
                    <v-btn block elevation="3" color="success" @click="AddClient">Ajouter</v-btn>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script src="./ClientAdd.js"></script>