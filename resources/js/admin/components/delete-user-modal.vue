<template>
    <v-dialog v-model="modal"  class="m-0 p-0 " >
        <template v-slot:activator="{ on, attrs }">
            <v-btn style='top: -1em; margin:0; padding:0;'  icon color="red" v-bind="attrs" v-on="on" class="ml-5 mt-5">
                <v-icon>mdi-account-minus</v-icon>
            </v-btn>
        </template>

        <v-card>
            <v-card-title>
               Suprimer l'utilisateur {{ user.name + " " + user.last_name}}
            </v-card-title>

            <div class="d-flex justify-content-around py-5">
                <v-btn x-small class="" color="red"> Abandonné la supression</v-btn>
                <v-btn x-small elevation="" @click="deleteUser()" color="success">Confirmé la supression</v-btn>
            </div>
        </v-card>
    </v-dialog>
</template>

<script src='./js/delete-user-modal.js'></script>