<template>
     <v-container>
         <v-row v-if="alert_state">
            <Alert :state="alert_state" :msg="alert_msg"  :type="alert_type"  />
         </v-row>
         
         <v-row>
            <h2 class="text-center" style="margin-top: 10%">Enregistrez-vous sur MielPeï</h2>
            <v-card class="col-5 mx-auto" style='margin-top: 5%;' min-width="400"  outlined >
                <v-form class="col-10 mx-auto mt-5">
                    <v-text-field v-model="name" label="Nom"> </v-text-field>
                    <v-text-field v-model="last_name" label="Prénom"> </v-text-field>
                    <v-text-field v-model="phone" label="Téléphone"> </v-text-field>
                    <v-text-field v-model="email" label="Email"> </v-text-field>
                    <v-text-field type="password" v-model="password" label="Password"> </v-text-field>
                    <v-text-field type="password" v-model="password_confirm" label="Confirmer le mot de passe"> </v-text-field>

                    <div class="d-flex justify-content-around ">
                        <v-btn small color="success"  href="/login">Se connecter</v-btn>
                        <v-btn small color="warning" @click='register'>S'enregistrer</v-btn>
                    </div>
                </v-form> 
            </v-card>
         </v-row>
       
    </v-container>

</template>

<script src='./js/register.js'></script>