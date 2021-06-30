<template lang="html">
    <div>
        <v-dialog v-model="show" fullscreen>
            <v-card >
                <v-toolbar dense>
                    <v-icon>mdi-teach</v-icon>
                    Pembelajaran Baru / Edit
                    <v-spacer></v-spacer>
                    <v-btn icon @click.stop="$emit('hide')" color="error"><v-icon>mdi-close</v-icon></v-btn>
                </v-toolbar>
                <v-card-text>

                    <v-stepper
                        v-model="step"
                        vertical
                        class="mt-5"
                        non-linear
                        >
                        <v-stepper-step
                            :complete="step > 1"
                            step="1"
                            editable
                            >
                            Pilih Tematik
                            <small>Pilih Tema jika tematik</small>
                        </v-stepper-step>

                        <v-stepper-content step="1">
                            <v-card
                                color="secondary"
                                class="mb-12"
                                height="200px"
                            >
                                <v-card-text>
                                    <v-radio-group
                                      v-model="pembelajaran.tematik"
                                      row
                                      @change="onTematik"
                                    >
                                      <v-radio
                                        label="Tematik"
                                        value="1"
                                      ></v-radio>
                                      <v-radio
                                        label="Non Tematik"
                                        value="0"
                                      ></v-radio>
                                    </v-radio-group>
                                    <v-autocomplete
                                    v-if="pembelajaran.tematik == '1'"
                                        :items="temas"
                                        v-model="pembelajaran.tema"
                                        dense
                                        label="Tema"
                                        @change="onSelectTema"
                                        rounded
                                        outlined
                                    >
                                    </v-autocomplete>
                                    <v-autocomplete
                                        v-if="pembelajaran.tema"
                                        :items="subtemas"
                                        v-model="pembelajaran.subtema"
                                        dense
                                        label="Subtema"
                                        rounded
                                        outlined
                                        @change="onSelectSubtema"
                                        @input="tes"
                                    >
                                    </v-autocomplete>
                                    
                                </v-card-text>


                            </v-card>
                            <v-btn text color="warning">
                                Batal
                            </v-btn>
                            <v-btn @click="step = 2" color="primary" :disabled="!pembelajaran.subtema" rounded>
                                Lanjut
                            </v-btn>
                            
                        </v-stepper-content>
                        <v-stepper-step
                            :complete="step > 2"
                            step="2"
                            editable
                            >
                            Pilih Muatan Pelajaran
                            <small>Pilih Mapel</small>
                        </v-stepper-step>

                        <v-stepper-content step="2">
                            <v-card
                                color="secondary"
                                class="mb-5"
                                
                            >
                                <v-card-text>
                                    <v-item-group multiple v-model="pembelajaran.mupels">
                                        <v-container>
                                            <v-row class="d-flex justify-center">
                                                <v-col
                                                    v-for="mapel in mapels"
                                                    :key="mapel.kode_mapel"
                                                    cols="12"
                                                    md="2"

                                                >
                                                    <v-item v-slot="{ active, toggle }" :value="mapel">
                                                        <v-card
                                                        :color="active ? 'primary' : ''"
                                                        class="d-flex align-center py-5"
                                                        dark

                                                        max-height="200"
                                                        @click="toggle"

                                                      >
                                                      <div class="flex-grow-1 ">
                                                        <div
                                                            class=" text-center text-h5 "
                                                          >
                                                        <v-scroll-x-transition>
                                                            <v-icon v-if="active" color="success">mdi-check-circle</v-icon>
                                                        </v-scroll-x-transition>
                                                        
                                                            {{ mapel.label }}

                                                        </div>
                                                        <div v-if="active" class="text-center">
                                                            <p v-for="kd in mapel.kds">{{ kd.kode_kd }}</p>
                                                        </div>
                                                    </div>
                                                      </v-card>
                                                    </v-item>
                                                </v-col>
                                            </v-row>
                                        </v-container>
                                    </v-item-group>
                                </v-card-text>
                            </v-card>   
                            <v-btn @click="step = 3" color="primary" :disabled="pembelajaran.mupels.length < 1">
                                Lanjut
                            </v-btn>
                            <v-btn text color="warning">
                                Batal
                            </v-btn>
                        </v-stepper-content>
                        <v-stepper-step
                            :complete="step > 3"
                            step="3"
                            editable
                        >Tujuan Pembelajaran
                        <small>Tambahkan tujuan pembelajaran</small></v-stepper-step>
                        <v-stepper-content step="3">
                            <v-card color="secondary" class="mb-5">
                                <v-card-text>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-row>
                                                <v-col cols="12">
                                                    <tiptap-vuetify v-model="pembelajaran.tujuans" label="Tujuan Pembelajaran" :extensions="extensions">
                                                    </tiptap-vuetify>
                                                </v-col>
                                            </v-row>
                                        </v-col>
                                        <v-col cols="6" v-html="pembelajaran.tujuans">
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                            <v-btn @click="step = 4" color="primary" :disabled="pembelajaran.tujuans.length < 1">
                                Lanjut
                            </v-btn>
                            <v-btn text color="warning">
                                Batal
                            </v-btn>
                        </v-stepper-content>
                        <v-stepper-step
                            :complete="step > 4"
                            step="4"
                            :editable="pembelajaran.kegiatan != ''"
                        >
                            Kegiatan Pembelajaran
                            <small>Isi Kegiatan/Langkan Pembelajaran</small>
                        </v-stepper-step>
                        <v-stepper-content step="4">
                            <v-card color="secondary" class="mb-5">
                                <v-card-text>
                                    <v-row>
                                        <v-col cols="3">
                                            <tiptap-vuetify v-model="pembelajaran.kegiatan.pembukaan" label="Pembukaan" :extensions="extensions"></tiptap-vuetify>
                                        </v-col>
                                    </v-row>
                                </v-card-text>
                            </v-card>
                        </v-stepper-content>
                    </v-stepper>

                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    import { TiptapVuetify, Heading, Bold, Italic, Strike, Underline, Code, Paragraph, BulletList, OrderedList, ListItem, Link, Blockquote, HardBreak, HorizontalRule, History } from 'tiptap-vuetify'
export default {
    name: 'ModalPembelajaran',
    props: { dialog: Object },
    components: { TiptapVuetify },
    data: () => ({
        pembelajaran: {
            tematik: false,
            tema: null,
            subtema: null,
            mupels: [
                // { mapel_id: 'bid', kds: '3.2' },
                // { mapel_id: 'sbdp', kds: '3.2' },
                // { mapel_id: 'mtk', kds: '3.6' },
            ],
            tujuans: '',
            kegiatan: {
                pendahuluan: { teks: '', durasi: ''},
                inti: { teks: '', durasi: ''},
                penutup: { teks: '', durasi: ''},
            },
            penilaian: '',
            tanggal: '',
        },
        periodes: [],
        rombels: [],
        fileRpp: null,
        temas: [],
        subtemas: [],
        rawtemas:[],
        mapels: [],
        step: 1,
        extensions: [
              History,
              Blockquote,
              Link,
              Underline,
              Strike,
              Italic,
              ListItem,
              BulletList,
              OrderedList,
              [Heading, {
                options: {
                  levels: [1, 2, 3]
                }
              }],
              Bold,
              
              
              Paragraph,
              HardBreak
            ],
    }),
    methods: {
        tes(e) {
            console.log(e)
        },
        onSelectSubtema(e) {
            axios({
                method: 'post',
                url: '/dashboard/pemetaan',
                data: {
                    kelas: this.$page.props.rombel.kelas_id,
                    tema: this.pembelajaran.tema,
                    subtema: this.pembelajaran.subtema
                }
            }).then( res => {
                var mapels = []
                res.data.pemetaans.forEach((item, index) => {
                    item.no = index+1
                    mapels.push({kode_mapel: item.mapel.kode_mapel, label: item.mapel.label, kds: item.kds})
                })
                this.mapels = mapels
                // console.log(res.data.pemetaans)
            }).catch( err => {

            })
        },
        onSelectTema(a){
            // console.log(a)
            // alert(a)
            let subtemas =[]
            this.rawtemas.forEach(item=>{
                if(item.tema_id == a){
                    // subtemas.push({value: item.tema.subtemas.kode_subtema, text: item.tema.subtemas.kode_subtema.substr(2,1)+'. '+item.tema.subtemas.teks})
                    item.tema.subtemas.forEach(subtema => {
                        subtemas.push({ value: subtema.kode_subtema, text: subtema.kode_subtema.substr(2,1) + '. '+subtema.teks})
                    })
                }
            })
            // console.log(subtemas)
            this.subtemas = subtemas
        },
        onTematik(e){
            // alert(e)
           if (e == '1') {
               axios({
                   method: 'post',
                   url: '/dashboard/tema?kelas='+this.$page.props.rombel.kelas_id
               }).then(response => {
                   let temas = []
                   this.rawtemas = response.data.datas
                   response.data.datas.forEach(item => {
                       temas.push({value: item.tema_id, text: item.tema_id.substr(1,1)+'. '+item.tema.teks})
                   })

                   this.temas = temas
               }).catch( err => {

               })
           } else {
               this.temas = []
               this.subtemas = []
           }
        },
        onChanged($event, namafile) {
            console.log($event)
        },
        rppChange(e){
            const mimes = [
                {
                    ext: 'pdf',
                    type: 'application/pdf'
                },
                {
                    ext: 'docx',
                    type: 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                }
            ]
            console.log(e.type)
            // const file = e.target.files[0]
            this.fileRpp = URL.createObjectURL(e)
        },
        save(e) {
            e.preventDefault()
        },
        init(){
            // Get Periodes
            this.pembelajaran.periode_id = this.$page.props.periode
            axios({
                url: '/dashboard/periode?mode=select',
                method: 'post'
            }).then(response => {
                response.data.periode.forEach((item,index) => {
                    item.index = index+1
                    var sem = (item.semester == '1') ? 'Ganjil' : 'Genap'
                    this.periodes.push({value: item.kode_periode, text: item.tapel+ ' '+sem})
                })
                // console.log(response.data)
            }).catch(err => {
                console.log(err)
            })

            if ( this.$page.props.user.role != 'wali') {
                // Get Rombels
                axios.post('/dashboard/rombel?mode=select')
                     .then(response => {
                        response.data.rombels.forEach((item, index) => {
                            item.index = index+1
                            this.rombels.push({value: item.kode_rombel, text: item.label})
                        })
                     })
                     .catch(err => {
                         console.log(err.response)
                     })
            } else {
                this.pembelajaran.rombel_id = this.$page.props.rombel.kode_rombel
            }
        }
    },
    computed: {
        show: {
            get() {
                return this.dialog.show
            },
            set(val) {
                this.$emit('hide', val)
            }
        }
    },
    mounted() {
        this.init()
    }
}
</script>

<style scoped>
    .align-top {
        vertical-align: 0%;
    }
</style>