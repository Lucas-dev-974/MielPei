<template>
    <v-dialog v-model="modal" min-width="400px" max-width="600px">
        <template v-slot:activator="{on, attrs}">
            <v-btn  icon color="green" v-bind="attrs" v-on="on" class="mt-4" small>
                 <v-icon color="warning" >mdi-pencil</v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-title class="d-flex justify-content-center">Modifier {{computer.nom}} </v-card-title>
            <v-container >
                <v-text-field  type="text"  placeholder="Nom" label="Nom"   v-model="computerName" outlined color></v-text-field>
                <v-btn block elevation="3" color="success" @click="Update">Modifier</v-btn>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script src="./ComputerUpdate.js"></script>