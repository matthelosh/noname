<template>
    <Layout :title="page_title">
        <v-container>
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <v-toolbar dense>
                            <v-toolbar-title>{{page_title}}</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn rounded  color="info" @click="cetakJurnal"><v-icon>mdi-printer</v-icon> Cetak Jurnal</v-btn>
                            <v-btn icon @click="showModalPembelajaran"><v-icon>mdi-plus</v-icon></v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <v-alert v-if="items.length < 1" color="info">
                                <h3 class="text-center">Anda belum membuat pembelajaran.</h3>
                            </v-alert>
                            <div v-else>
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
                                                                <v-list-item-title class="d-flex justify-bettween">
                                                                     <v-btn small icon color="error"><v-icon>mdi-chevron-down</v-icon></v-btn>
                                                                    {{ st.kode_subtema.substr(-1) }}. {{ st.teks }}
                                                                    <v-spacer></v-spacer>
                                                                   
                                                                </v-list-item-title>
                                                                <v-list dense>
                                                                    <!-- <v-list-item-group color="info"> -->
                                                                        <v-list-item v-for="pembelajaran in st.pembelajaran" :key="pembelajaran.kode_pembelajaran">
                                                                            <v-list-item-content>
                                                                                <v-list-item-subtitle>

                                                                                    Pembelajaran Ke {{ pembelajaran.ke }}
                                                                                    
                                                                                    <v-tooltip top>
                                                                                        <template v-slot:activator="{ on, attrs }" >     
                                                                                            <v-icon @click="editRpp(pembelajaran)" color="warning" v-bind="attrs" v-on="on">mdi-file-edit-outline</v-icon>
                                                                                        </template>
                                                                                         <span>Edit Pembelajaran</span>
                                                                                    </v-tooltip>
                                                                                    <v-tooltip top>
                                                                                        <template v-slot:activator="{ on, attrs }" >     
                                                                                            <v-icon @click="showJurnal(item = { pembelajaran: pembelajaran, tema : {kode: tema.kode_tema, label: tema.teks} ,subtema : {kode: st.kode_subtema, label: st.teks}})" color="info" v-bind="attrs" v-on="on">mdi-teach</v-icon>
                                                                                        </template>
                                                                                         <span>Pelaksanaan</span>
                                                                                    </v-tooltip>
                                                                                    
                                                                                    <v-tooltip top>
                                                                                        <template v-slot:activator="{ on, attrs }" > 
                                                                                            <v-icon @click="penilaian(pembelajaran, tema.teks, st.teks)" color="error" v-bind="attrs" v-on="on">mdi-progress-question</v-icon>
                                                                                        </template>
                                                                                        <span>Penilaian</span>
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
                            </div>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <modal-pembelajaran v-if="dialog.show" :dialog="dialog" @hide="hideModalPembelajaran"></modal-pembelajaran>
        <rpp v-if="rpp.show" :dialog="rpp" @hide="hideRpp"></rpp>
        <jurnal v-if="jurnal.show" :dialog="jurnal" @hide="hideJurnal"></jurnal>
        <cetak-jurnal v-if="cetakjurnal.show" :dialog="cetakjurnal" @hide="cetakjurnal.show = false"></cetak-jurnal>
    </Layout>
</template>
 
<script>
import Layout from '../Layout/Dashboard'
import ModalPembelajaran from '../Components/Modals/ModalPembelajaran'
import Rpp from '../Components/Modals/Rpp'
import Jurnal from '../Components/Modals/Jurnal'
import CetakJurnal from '../Components/Modals/CetakJurnal'
export default {
    name: 'Pembelajaran',
    components: { Layout, ModalPembelajaran, Rpp, Jurnal, CetakJurnal },
    props: {
        page_title: String,
        page: String
    },
    data: () => ({
        items: [],
        dialog: {show: false},
        rpp: { show: false },
        jurnal: { show: false },
        cetakjurnal: { show: false },
    }),
    methods: {
        cetakJurnal() {
            this.cetakjurnal = { show: true }
        },
        showJurnal(item) {
            this.jurnal = { show: true, jurnal: item }
        },
        hideJurnal() {
            this.jurnal = { show: false }
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
                if( res.data.pembelajarans.length > 0) {
                    res.data.pembelajarans.forEach((item, index) => {
                        item.no = index+1
                        items.push(item)
                    })
                }
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
