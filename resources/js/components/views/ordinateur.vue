<template>
    <v-card width="150" max-width="300" min-width="250" >
        <v-row justify="around">
            <v-card-title class=""> {{ ordinateur.nom }} </v-card-title>
            <deleteOrdinateur @deleteOrdi="deleteOrdi" :ordi="this.ordinateur" />
        </v-row>
        <v-card-text>
            <div v-for="data in horraire" :key="data.id">
                <v-row >
                    <v-col cols="3"> {{ data.index }}H</v-col>
                    <v-col cols="5"> {{ data.attribution.nom }}</v-col>
                    <v-col cols="4" class="text-right" v-if="data.attribution">
                        <v-icon color="error" @click="delAttr(data.index)">mdi-minus</v-icon>
                    </v-col>
                    <addAttribution v-else @AddAttribution="AddAttribution" :ordinateur="ordinateur.id" :horraire="data" :date="date" />
                </v-row>
            </div>
        </v-card-text>
    </v-card>
</template>

<script src='./ordinateur.js'></script>