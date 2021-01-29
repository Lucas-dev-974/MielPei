<template>
    <v-form class="col-5 mx-auto mt-5">
        <v-text-field v-model="email" label="Email">
        </v-text-field>

        <v-text-field type="password" v-model="password" label="Password">
        </v-text-field>

        <v-btn block @click='login'>Se connecter</v-btn>
    </v-form>
</template>

<script src='./login.js'></script>