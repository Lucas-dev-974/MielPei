<template>
    <div class="">
        <div class="d-flex justify-content-around bg-dark">
            <h3 class="text-white py-4">Admin {{ admin.last_name}} </h3>
        </div>

        <div class="d-flex justify-content-center">
            <div class="col-11">
                <Alert :state='alert.state' :msg='alert.msg' :type='alert.type' /> 
            </div>
        </div>

        <v-container class="">
            <v-tabs>
                <v-tab @click="role='user'">Utilisateur</v-tab>
                <v-tab @click="role='vendor'">Vendeur</v-tab>
                <v-tab @click="role='admin'">Admin</v-tab>
            </v-tabs>
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                        <tr>
                            <th class="text-left"> Nom </th>
                            <th class="text-left"> Prenom  </th>
                            <th class="text-left"> Email  </th>
                            <th class="text-left"> Phone  </th>
                            <th class="text-left"> Role  </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="user in users" :key="user.id">
                            <td>{{ user.name }}</td>
                            <td>{{ user.last_name }}</td>
                            <td>{{ user.email }}</td>
                            <td>{{ user.phone }}</td>
                            <td>{{ user.role }}</td>
                            <td class="d-flex justify-content-around">
                                <updateUser :user='user' :alert='alert' @updateList='getUsersList' />
                                <deleteUser :user='user' @updateList='getUsersList' />
                                <v-switch style="top: -5;" color="success" @change="updateActiveAccount(user.id, user.active_account)" v-model="user.active_account" :label="`compte activé: ${user.active_account.toString()}`" ></v-switch>
                            </td>
                        </tr>
                    </tbody>
                </template>
            </v-simple-table>

        </v-container>
    </div>
</template>

<script src='./js/dashboard.js'></script>