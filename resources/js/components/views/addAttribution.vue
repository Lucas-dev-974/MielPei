<template>
    <v-dialog v-model="modal"  min-width="400px" max-width="600px">
        <template v-slot:activator="{on, attrs}">
            <v-btn icon color="green" v-bind="attrs" v-on="on" class="ml-5">
                <v-icon>mdi-plus</v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-title class="d-flex justify-content-center">Ajouter une attribution</v-card-title>
            <v-container>
                <v-card-text class="d-flex justify-content-around ">
                    <v-autocomplete  v-model="model" :items="clients" return-object  :search-input.sync="input" item-text="all_name">
                    </v-autocomplete>
                    <v-btn icon color="red" @click="deleteClientModel" class="mt-4" >
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-card-text>
                <v-row class="d-flex justify-space-around my-5">
                    <v-btn color="green" class="col-5" :disabled="validClient" @click="attribute"  > Attribuer </v-btn>
                    <AddClient  :IsClientValid="validClient" />
                </v-row>
            </v-container>
            
        </v-card>
    </v-dialog>
</template>

<script src="./addAttribution.js"></script>