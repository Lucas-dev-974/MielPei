<template>
  <div class="d-flex justify-content-center" >
      <v-alert v-model="alert" :color='type' close-text="Close Alert" dismissible elevation="2">
        <p v-for="mesg in message" :key="mesg">
          {{ mesg }}
        </p>
      </v-alert>
  </div>
</template>

<script src='./js/alert.js'></script>