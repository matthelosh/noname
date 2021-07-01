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
                            <v-alert v-if="items.length < 1" color="info">
                                <h3 class="text-center">Anda belum membuat pembelajaran.</h3>
                            </v-alert>
                            <v-container v-else>
                                <v-row>
                                    <v-col cols="12" sm="4" v-for="tema in items" :key="tema.kode_tema">
                                        <v-card elevation="5">
                                            <v-card-text>
                                                <v-list>
                                                    <v-list-item color="warning">
                                                        <v-list-item-content>
                                                            <v-list-item-title class="text-h6">Tema {{ tema.kode_tema.substr(-1) }}. {{ tema.teks }}</v-list-item-title>
                                                        </v-list-item-content>
                                                    </v-list-item>
                                                    <v-divider></v-divider>
                                                    <!-- <v-list-item-group color="info"> -->
                                                        <v-list-item v-for="st in tema.subtemas" :key="st.kode_subtema">
                                                            <v-list-item-content>
                                                                <v-list-item-title>{{ st.kode_subtema.substr(-1) }}. {{ st.teks }}</v-list-item-title>
                                                                <v-list dense>
                                                                    <!-- <v-list-item-group color="info"> -->
                                                                        <v-list-item v-for="pembelajaran in st.pembelajaran" :key="pembelajaran.kode_pembelajaran">
                                                                            <v-list-item-content>
                                                                                <v-list-item-subtitle>

                                                                                    Pembelajaran Ke {{ pembelajaran.ke }}
                                                                                    <v-tooltip top>
                                                                                        <template v-slot:activator="{ on, attrs }" >     
                                                                                            <v-icon @click="jurnal(pembelajaran)" color="info" v-bind="attrs" v-on="on">mdi-teach</v-icon>
                                                                                        </template>
                                                                                         <span>Pelaksanaan</span>
                                                                                    </v-tooltip>
                                                                                    <v-tooltip top>
                                                                                        <template v-slot:activator="{ on, attrs }" >     
                                                                                            <v-icon @click="editRpp(pembelajaran)" color="warning" v-bind="attrs" v-on="on">mdi-file-edit-outline</v-icon>
                                                                                        </template>
                                                                                         <span>Edit Pembelajaran</span>
                                                                                    </v-tooltip>
                                                                                    
                                                                                    <v-tooltip top>
                                                                                        <template v-slot:activator="{ on, attrs }" > 
                                                                                            <v-icon @click="showRpp(pembelajaran, tema.teks, st.teks)" color="primary" v-bind="attrs" v-on="on">mdi-printer</v-icon>
                                                                                        </template>
                                                                                        <span>Cetak RPP</span>
                                                                                    </v-tooltip>
                                                                                </v-list-item-subtitle>
                                                                            </v-list-item-content>
                                                                        </v-list-item>
                                                                    <!-- </v-list-item-group> -->
                                                                </v-list>
                                                            </v-list-item-content>
                                                        </v-list-item>
                                                    <!-- </v-list-item-group> -->
                                                </v-list>
                                            </v-card-text>
                                        </v-card>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <modal-pembelajaran v-if="dialog.show" :dialog="dialog" @hide="hideModalPembelajaran"></modal-pembelajaran>
        <rpp v-if="rpp.show" :dialog="rpp" @hide="hideRpp"></rpp>
    </Layout>
</template>
 
<script>
import Layout from '../Layout/Dashboard'
import ModalPembelajaran from '../Components/Modals/ModalPembelajaran'
import Rpp from '../Components/Modals/Rpp'

export default {
    name: 'Pembelajaran',
    components: { Layout, ModalPembelajaran, Rpp},
    props: {
        page_title: String,
        page: String
    },
    data: () => ({
        items: [],
        dialog: {show: false},
        rpp: { show: false },
    }),
    methods: {
        jurnal(item) {

        },
        editRpp(item) {
             this.dialog = {show: true , pembelajaran: item }
        },
        showRpp(item, tema, subtema ) {
            this.rpp = { show: true, rpp: item, tema: tema, subtema: subtema }
        },
        hideRpp(){
            this.rpp = { show: false }
        },
        hideModalPembelajaran(){
            this.dialog = { show: false}
            this.getPembelajaran()
        },
        getPembelajaran() {
            axios({
                method: 'post',
                url: '/dashboard/pembelajaran',
                data: {
                    periode: this.$page.props.periode,
                    rombel: this.$page.props.rombel
                }
            }).then( res => {
                var items = []
                res.data.pembelajarans.forEach((item, index) => {
                    item.no = index+1
                    items.push(item)
                })
                this.items = items
            })
        },
        showModalPembelajaran(){
            this.dialog = {show: true}
        },
        mupels(text) {
            // let data =  JSON.parse(text)
            let list = ''
            // data.forEach(item => {
                
            //     var sublist = ''
            //     item.kds.forEach(kd => {
            //         sublist += '<li>'+kd.kode_kd+'</li>'
            //     })

            //     list += '<li>'+item.label+' <ul>'+sublist+'</ul></li>'
            // })
            // var mupel = `<ol>${list}</ol>`

            // return mupel
        }
    },
    computed: {
        
    },
    mounted() {
        this.getPembelajaran()
    }
}
</script>
