<template>
  <div class="text-center">
    <v-dialog v-model="dialog" width="500">
      <template v-slot:activator="{ on, attrs }">
        <v-btn icon color="red lighten-" class="mt-4" dark v-bind="attrs" v-on="on">
           <v-icon color="error" >mdi-minus</v-icon>
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="headline grey lighten-2 d-flex justify-content-center">
          Supprimer {{ this.ordi.nom }}
        </v-card-title>

        <v-card-text>
            <v-container>
                <v-row class="d-flex justify-content-center my-4">
                    <v-col cols="6">
                        <v-row class="d-flex justify-content-center">
                            <v-btn color="error" @click="dialog = false">Non</v-btn>
                        </v-row>
                    </v-col>
                    <v-col cols="6">
                        <v-row class="d-flex justify-content-center">
                            <v-btn color="success" @click="deleteOrdinateur">Oui</v-btn>
                        </v-row>
                    </v-col>
                </v-row>    
            </v-container>
          
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>

<script src="./deleteOrdi.js"> </script>