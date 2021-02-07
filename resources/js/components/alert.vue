<template>
    <v-alert v-model="alert" close-text="Close Alert" color="deep-purple accent-4" dark dismissible>
        {{ alert_msg }}
    </v-alert>
</template>

<script src='./js/alert.js'></script>