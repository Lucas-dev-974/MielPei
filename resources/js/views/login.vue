<template>
     <v-container class="">
         <v-row>
            <v-alert class="col-5 my-5 mx-auto" v-model="alert" close-text="Close Alert" small type="warning" outlined dismissible>
                {{ alert_msg }}
            </v-alert>
         </v-row>

         <v-row>
            <v-form class="col-5 mx-auto mt-5">
                <v-text-field v-model="email" label="Email">
                </v-text-field>

                <v-text-field type="password" v-model="password" label="Password">
                </v-text-field>

                <v-btn block @click='login'>Se connecter</v-btn>
            </v-form> 
         </v-row>
       
    </v-container>

</template>

<script src='./js/login.js'></script>