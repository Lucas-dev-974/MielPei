<template>
    
    <div class="d-flex justify-content-start">
        <v-btn icon color="dark" @click="previousPage" class="ml-5">
            <v-icon>mdi-arrow-left-bold-circle-outline</v-icon>
        </v-btn>

        <v-btn icon color="dark" @click="nextPage" class="ml-5">
            <v-icon>mdi-arrow-right-bold-circle-outline</v-icon>
        </v-btn>
    </div>
</template>

<script src='./pagination.js'></script>