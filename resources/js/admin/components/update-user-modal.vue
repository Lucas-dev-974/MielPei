<template>
    <v-dialog v-model="modal" max-width="500px">
        <template v-slot:activator="{ on, attrs }">
            <v-btn style='top: -1em; margin:0; padding:0;'  icon color="red" v-bind="attrs" v-on="on" class="ml-5 mt-5">
                <v-icon icon color="orange">mdi-pencil-circle-outline</v-icon>
            </v-btn>
        </template>

        <v-card >
            <v-card-title>
               Modification de l'utilisateur {{ user.name + " " + user.last_name}}
            </v-card-title>

            <div class="mx-auto justify-content-around py-5">
                <div class="col-sm-10 mx-auto">
                    <v-text-field v-on:keyup.enter="updateUserEmail" type="email"  
                    placeholder="email" 
                    label="Modifier l'email"   v-model="email" ></v-text-field>
                </div>

                <div class="col-sm-10 mx-auto">
                    <v-select
                    v-model="selectRole"
                    :items="role"
                    menu-props="auto"
                    hide-details
                    label="Role"
                    single-line
                    @change="updateUserRole"
                    ></v-select>
                </div>

                
            </div>
        </v-card>
    </v-dialog>
</template>

<script src='./js/update-user-modal.js'></script>