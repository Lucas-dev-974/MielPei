<template>
    <v-dialog v-model="modal" width="500">
        <template v-slot:activator="{on, attrs}">
            <v-btn icon color="green" v-bind="attrs" v-on="on" class="ml-5">
                <v-icon>mdi-card-plus</v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-title>Attribution</v-card-title>
            <v-container>
                <v-card-text>
                    <v-autocomplete v-model="model" :items="clients" return-object  :search-input.sync="input" item-text="all_name">
                    </v-autocomplete>
                </v-card-text>
                <v-row justify="space-around" class="mt-5">
                    <v-btn :disabled="validClient" @click="attribute"  > Attribuer </v-btn>
                    <v-btn  :disabled="!validClient"  @click="AddClient"> Ajouter le client </v-btn>
                </v-row>
            </v-container>
            
        </v-card>
    </v-dialog>
</template>

<script src="./addAttribution.js"></script>