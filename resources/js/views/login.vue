<template>
     <v-container class="">
         <div class="d-flex justify-content-center">
            <v-alert class="my-5" v-model="alert" close-text="Close Alert" small type="warning" outlined dismissible>
                {{ alert_msg }}
            </v-alert>
         </div>

         <v-row>
             <v-card class="col-5 mx-auto" style='margin-top: 10%;' min-width="400" outlined >
                <p class="text-center fs-4 mt-2">Connectez-vous sur MielPeï</p>
                <v-form class="col-10 mx-auto mb-5">
                    <v-text-field v-model="email" label="Email" class="bg-transparent">
                    </v-text-field>

                    <v-text-field type="password" v-model="password" label="Password">
                    </v-text-field>
                    <div class="d-flex justify-content-around w-100">
                        <v-btn small color="warning"  href="/register">S'enregistrer</v-btn>
                        <v-btn small color="success" @click='login'>Se connecter</v-btn>
                    </div>
                    
                </v-form> 
             </v-card>

         </v-row>
       
    </v-container>

</template>

<script src='./js/login.js'></script>