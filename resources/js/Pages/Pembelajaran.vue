<template>
    <Layout :title="page_title">
        <v-container>
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <v-toolbar dense>
                            <v-toolbar-title>{{page_title}}</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn icon @click="showModalPembelajaran"><v-icon>mdi-plus</v-icon></v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <div v-if="pembelajarans.length < 1">
                            <h3 class="text-center" >Anda belum membuat pembelajaran.</h3>
                            </div>
                            <v-container v-else>
                                <v-row>
                                    <v-col cols="12" sm="6">List Pembelajaran</v-col>
                                    <v-col cols="12" sm="6">Chart Pembelajaran</v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <modal-pembelajaran :dialog="dialog" @hide="dialog={}"></modal-pembelajaran>
    </Layout>
</template>
 
<script>
import Layout from '../Layout/Dashboard'
import ModalPembelajaran from '../Components/Modals/ModalPembelajaran'

export default {
    name: 'Pembelajaran',
    components: { Layout, ModalPembelajaran, },
    props: {
        page_title: String,
        page: String
    },
    data: () => ({
        pembelajarans: [],
        dialog: {}
    }),
    methods: {
        showModalPembelajaran(){
            this.dialog = {show: true}
        }
    },
    computed: {

    },
    mounted() {

    }
}
</script>
