<template>
<div class="d-flex justify-content-center">
    <v-alert v-if="type=='warning'" v-model="state" type='warning' close-text="Close Alert" dismissible>
    {{msg}}
    </v-alert>

    <v-alert v-if="type=='success'" v-model="state" type='warning' close-text="Close Alert" dismissible>
    {{msg}}
    </v-alert>

    <v-alert v-if="type=='error'" v-model="state" type='warning' close-text="Close Alert" dismissible>
      {{msg}}
    </v-alert>
</div>

</template>

<script src='./js/alert.js'></script>