<template>
  <v-container>
    <v-row>
      <v-col>
        <v-menu
          v-model="menu"
          :close-on-content-click="false"
          transition="scale-transition"
          offset-y
          max-width="290px"
          min-width="290px"
        >
          <template v-slot:activator="{ on, attrs }">
            <v-text-field
              v-model="date"
              label="Choisir une date"
              v-bind="attrs"
              v-on="on"
            >
            </v-text-field>
          </template>
          <v-date-picker
            v-model="date"
            no-title
            @change="init"
            @input="menu = false"
          ></v-date-picker>
        </v-menu>
      </v-col>
      <br>
      <v-col>
        <ModalAddOrdi @addview="updateViewOrdi" />
      </v-col>
    </v-row>
    <v-container>
      <v-row class="my-2">
        <div
          class="mx-5 mb-4"
          v-for="(ordinateur, key) in ordinateurs"
          :key="key"
        >
          <Ordinateurs
            :ordinateur="ordinateur"
            :date="date"
            @delOrdi="delOrdi"
          />
          <!-- :ordinateur->défini le props lors du montage du composent !-->
        </div>
      </v-row>
    </v-container>
  </v-container>
</template>

<script src='./home.js'></script>