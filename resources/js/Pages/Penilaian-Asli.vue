<template>
    <Layout :title="page_title"> 
        <v-container> 
            <v-row> 
                <v-col cols="12"
                    sm="8"> 
                    <v-card style="border: 1px solid teal;"> 
                        <v-card-title> NILAI HARIAN <v-spacer></v-spacer> 
                            <span
                                style="color:#363636;padding:0
                                5px;box-sizing:border-box;background:#DBF4A7;">TS</span> 
                            <span
                                style="color:#363636;padding:0
                                5px;box-sizing:border-box;background:#8E9DCC;">AS</span> 
                        </v-card-title>
                        <v-card-text color=""> 
                            <v-list dense> 
                                <v-list-item-group > 
                                    <v-row> 
                                        <v-col cols="6">
                                            <v-list-item> 
                                                <v-list-item-content> 
                                                    <v-list-item-title> 
                                                        <h4>TENGAH
                                                            SEMESTER</h4> 
                                                    </v-list-item-title> 
                                                </v-list-item-content> 
                                            </v-list-item>
                                    <v-row> 
                                        <v-col cols="6"> 
                                            <v-list-item class="elevation-2 my-2"
                                                
                                                v-for="(item,i) in items" :key="i"
                                                @click="showModalNilai(item, 'uh', 'ts', 'k3')"

                                                :style="'background-image: linear-gradient(to right, #DBF4A7 '+item.nh3_ts.prosentase+'%, white '+(item.nh3_ts.jml_kd - item.nh3_ts.prosentase)+'%);'"
                                                >
                                                
                                                <v-list-item-content>
                                                    <v-list-item-title>{{ item.text }}</v-list-item-title>
                                                </v-list-item-content>
                                                <v-list-item-icon>
                                                    {{ Math.round(item.nh3_ts.prosentase)}} %
                                                </v-list-item-icon>
                                            </v-list-item>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-list-item
                                                class="elevation-2 my-2"
                                                
                                                v-for="(item,i) in items" :key="i"
                                                @click="showModalNilai(item, 'uh', 'ts', 'k4')"

                                                :style="'background-image: linear-gradient(to right, #DBF4A7 '+item.nh4_ts.prosentase+'%, white '+(item.nh4_ts.jml_kd - item.nh4_ts.prosentase)+'%);'"
                                                >
                                                
                                                <v-list-item-content>
                                                    <v-list-item-title>{{ item.text }}</v-list-item-title>
                                                </v-list-item-content>
                                                <v-list-item-icon>
                                                    {{ Math.round(item.nh4_ts.prosentase)}} %
                                                </v-list-item-icon>
                                            </v-list-item>
                                        </v-col>
                                    </v-row>
                                    
                                </v-col>
                                <v-col cols="6">
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title>
                                                <h4>AKHIR SEMESTER</h4>
                                            </v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-list-item
                                                class="elevation-2 my-2"
                                                
                                                v-for="(item,i) in items" :key="i"
                                                @click="showModalNilai(item, 'uh', 'as', 'k3')"

                                                :style="'background-image: linear-gradient(135deg, #8E9DCC '+item.nh3_as.prosentase+'%, white '+(item.nh3_as.jml_kd - item.nh3_as.prosentase)+'%);'"
                                                >
                                                
                                                <v-list-item-content>
                                                    <v-list-item-title>{{ item.text }}</v-list-item-title>
                                                </v-list-item-content>
                                                <v-list-item-icon>
                                                    {{ Math.round(item.nh3_as.prosentase)}} %
                                                </v-list-item-icon>
                                            </v-list-item>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-list-item
                                                class="elevation-2 my-2"
                                                
                                                v-for="(item,i) in items" :key="i"
                                                @click="showModalNilai(item, 'uh', 'as', 'k4')"

                                                :style="'background-image: linear-gradient(135deg, #8E9DCC '+item.nh4_as.prosentase+'%, white '+(item.nh4_as.jml_kd - item.nh4_as.prosentase)+'%);'"
                                                >
                                                
                                                <v-list-item-content>
                                                    <v-list-item-title>{{ item.text }}</v-list-item-title>
                                                </v-list-item-content>
                                                <v-list-item-icon>
                                                    {{ Math.round(item.nh4_as.prosentase)}} %
                                                </v-list-item-icon>
                                            </v-list-item>
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                            
                                </v-list-item-group>
                            </v-list>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="12" sm="2">
                    <v-card>
                        <v-card-title>NILAI PTS</v-card-title>
                        <v-card-text>
                            <v-list dense>
                                <v-list-item-group>
                                    <v-list-item
                                        class="elevation-2 my-2"
                                        
                                        v-for="(item,i) in items" :key="i"
                                        @click="showModalNilai(item, 'nts', 'ts', null)"

                                        :style="'background-image: linear-gradient(135deg, #DBF4A7 '+item.nts.prosentase+'%, white '+(item.nts.jml_kd - item.nts.prosentase)+'%);'"
                                        >
                                        
                                        <v-list-item-content>
                                            <v-list-item-title>{{ item.text }}</v-list-item-title>
                                        </v-list-item-content>
                                        <v-list-item-icon>
                                            {{ Math.round(item.nts.prosentase)}} %
                                        </v-list-item-icon>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-card-text>
                    </v-card>
                </v-col>

                <v-col cols="12" sm="2">
                    <v-card>
                        <v-card-title>NILAI PAS</v-card-title>
                        <v-card-text>
                            <v-list dense>
                                <v-list-item-group>
                                    <v-list-item
                                        class="elevation-2 my-2"
                                        
                                        v-for="(item,i) in items" :key="i"
                                        @click="showModalNilai(item, 'nas', 'as')"

                                        :style="'background-image: linear-gradient(135deg, #8E9DCC '+item.nas.prosentase+'%, white '+(item.nas.jml_kd - item.nas.prosentase)+'%);'"
                                        >
                                        
                                        <v-list-item-content>
                                            <v-list-item-title>{{ item.text }}</v-list-item-title>
                                        </v-list-item-content>
                                        <v-list-item-icon>
                                            {{ Math.round(item.nas.prosentase)}} %
                                        </v-list-item-icon>
                                    </v-list-item>
                                </v-list-item-group>
                            </v-list>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
        <v-snackbar v-model="snackbar.show" :color="snackbar.color" bottom right  :timeout="snackbar.timeout">
            <template v-slot:action="{ attrs }">
                <v-btn color="white" icon v-bind="attrs" @click="snackbar.show = false"><v-icon>mdi-close</v-icon></v-btn>
            </template>
            {{snackbar.text}}
            
        </v-snackbar>

        <modal-nilai :dialog="modalNilai" @hide="modalNilai.show = false" v-if="modalNilai.show == true"></modal-nilai>
    </Layout>
</template>
<script>
import Layout from '../Layout/Dashboard'
import ModalNilai from '../Components/Modals/ModalNilai'
// import ModalNilai from '../Components/Modals/ModalNilai.vue';
export default {
    name: 'Penilaian',
    props: { page_title: String, page: String },
    components:{Layout, ModalNilai},
    data: ()=>({
        items:[],
        snackbar: {
            show: false,
            color: 'error',
            text: 'Halo',
            timeout: 500
        },
        modalNilai: {
            show: false
        }
    }),
    methods: {
        async init(){
            await this.getNilais(); 
            var role = this.$page.props.user.role
            // setTimeout(function(role){
                if ( role == 'wali') {
                    await this.getMapels()
                } else {
                    await this.getRombels()
                }
            // }, 500)
        
        },

      
        getNilais() {
            axios.post('/dashboard/nilai')
                .then( res => {
                    var datas = res.data.ikhtisar
                    var items = []
                    Object.values(datas).forEach(item => {
                        items.push({
                            text: item.label, 
                            value: item.kode, 
                            nh3_ts: item.nh3_ts, 
                            nh3_as:item.nh3_as, 
                            nh4_ts: item.nh4_ts, 
                            nh4_as:item.nh4_as, 
                            nts: item.nts, 
                            nas:item.nas
                            })
                    })
                    this.items = items
                    
                }).catch( err => {

                })
        },
        getRombels(){
            axios.post('/dashboard/rombel?periode='+this.$page.props.periode_aktif.kode_periode)
                .then( res => {
                    var rombels = []
                    res.data.rombels.forEach(rombel => {
                        rombels.push({text: rombel.label, value: rombel.kode_rombel})
                    })
                    this.items = rombels
                }).catch( err => {
                    console.log( err.response)
                })
        },
        getMapels(){
            axios.post('/dashboard/mapel?tingkat='+this.$page.props.rombel.kelas_id)
                .then(res => {
                    var mapels = []
                    res.data.mapels.forEach(mapel => {
                        mapels.push({ text: mapel.label, value: mapel.kode_mapel})
                    })

                    // this.items = mapels
                }).catch(err => {
                    console.log( err.response)
                })
        },
        
        showModalNilai(val, jenis, ppn, aspek) {
            // this.snackbar = {
            //     show: true,
            //     color: 'success',
            //     text: val,
            //     timeout: 2000
            // }
            // alert('halo')
            this.modalNilai = {
                show: true,
                mapel: val, 
                jenis: jenis,
                ppn: ppn,
                aspek: aspek
            }
        }
    },
    computed: {
        colorCheck(val){
            return val == '100' ? 'success' : 'error'
        }
    },
    created() {
        this.init()
    }
}
</script>