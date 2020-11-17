<template>
    <v-dialog v-model="dialog" max-width="500" class="ma-1" >
        <template v-slot:activator="{ on, attrs }">
            <v-btn icon color="green" v-bind="attrs" v-on="on" class="ml-5 mt-5">
                <v-icon>mdi-card-plus</v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-title>
                <v-row justify="center">Ajouter un ordinateur</v-row>
            </v-card-title>

            <v-container>
                <v-row class="pa-2">
                    <v-col cols="8">
                        <v-text-field v-model="ordiNameInput" label="Entrer le nom de l'ordinateur "></v-text-field>
                    </v-col>
                </v-row>

                <v-row>
                    <v-col cols="4">
                        <v-btn color='green' dark v-if="ordiNameInput.length > 1" @click="addOrdi">
                            Ajouter
                        </v-btn>
                        <v-btn disabled dark v-else> </v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </v-dialog>
</template>

<script src='./addOrdi.js'></script>