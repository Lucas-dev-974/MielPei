<template>
     <v-container class="">
         <v-row>
            <v-alert class="col-5 my-5" style="position: absolute; left: 30%;" v-model="alert" close-text="Close Alert" small type="warning" outlined dismissible>
                {{ alert_msg }}
            </v-alert>
         </v-row>

         <v-row>
            <v-card class="col-5 mx-auto" style='margin-top: 10%;' min-width="400"  outlined >
                <p class="text-center fs-4 mt-2">Enregistrez-vous sur MielPeï</p>
                <v-form class="col-10 mx-auto mt-5">
                    <v-text-field v-model="name" label="Nom"> </v-text-field>
                    <v-text-field v-model="last_name" label="Prénom"> </v-text-field>
                    <v-text-field v-model="phone" label="Téléphone"> </v-text-field>
                    <v-text-field v-model="email" label="Email"> </v-text-field>
                    <v-text-field type="password" v-model="password" label="Password"> </v-text-field>
                    <v-text-field type="password" v-model="password_confirm" label="Confirmer le mot de passe"> </v-text-field>

                <div class="d-flex justify-content-around ">
                            <v-btn color="success"  href="/login">Se connecté</v-btn>
                            <v-btn color="warning" @click='register'>S'enregistré</v-btn>
                        </div>
                </v-form> 

            </v-card>

         </v-row>
       
    </v-container>

</template>

<script src='./js/register.js'></script>