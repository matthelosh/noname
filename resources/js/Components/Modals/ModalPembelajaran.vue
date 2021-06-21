<template lang="html">
    <div>
        <v-dialog v-model="show" transition="dialog-bottom-transition" fullscreen hide-overlay>
            <v-card>
                <v-toolbar dense>
                    <v-icon>mdi-teach</v-icon>
                    Pembelajaran Baru / Edit
                    <v-spacer></v-spacer>
                    <v-btn icon @click.stop="$emit('hide')" color="error"><v-icon>mdi-close</v-icon></v-btn>
                </v-toolbar>
                <v-card-text>
                    <!-- <v-container> -->
                        <v-row class="mt-5">
                            <v-col cols="12" sm="8"> 
                                <!-- <v-card>
                                    <v-card-text> -->
                                        <v-form @submit="save">
                                            <v-row>
                                                <v-col cols="4" class="text-right">Kode Pembelajaran:</v-col>
                                                <v-col cols="8" >
                                                    <v-text-field v-model="pembelajaran.kode_pembelajaran" placeholder="Kode Pembelajaran" dense hide-details prepend-inner-icon="mdi-qrcode"></v-text-field>
                                                </v-col>
                                                <v-col cols="4" class="text-right">Label Pembelajaran:</v-col>
                                                <v-col cols="8">
                                                    <v-text-field v-model="pembelajaran.label" placeholder="Label" dense hide-details prepend-inner-icon="mdi-tag-outline"></v-text-field>
                                                </v-col>
                                                <v-col cols="4" class="text-right"> Periode:</v-col>
                                                <v-col cols="8">
                                                    <v-select v-model="pembelajaran.periode_id" label="Periode" :items="periodes" item-key="value" item-text="text" dense hide-details prepend-inner-icon="mdi-calendar-range"></v-select>
                                                </v-col>
                                                <v-col cols="4" class="text-right" v-if="$page.props.user.role != 'wali'">Rombel:</v-col>
                                                <v-col cols="8" v-if="$page.props.user.role != 'wali'">
                                                   <v-select v-model="pembelajaran.rombel_id" label="Rombel" dense hide-details prepend-inner-icon="mdi-google-classroom" :items="rombels" item-text="text" item.value="value"></v-select>
                                                </v-col>
                                                <v-col cols="4" class="text-right"> Tematik?:</v-col>
                                                <v-col cols="8">
                                                    <v-checkbox label="Tematik" v-model="pembelajaran.is_tematik" dense hide-details @change="onTematik">
                                                    </v-checkbox>
                                                </v-col>
                                                <v-col cols="4" class="text-right" v-if="pembelajaran.is_tematik">Tema:</v-col>
                                                <v-col cols="4" v-if="pembelajaran.is_tematik">
                                                    <v-select label="Tema" 
                                                    :items="temas" item-text="text" item-value="value"
                                                    v-model="pembelajaran.tema_id" dense hide-details  @change='onSelectTema'></v-select>
                                                </v-col>
                                                <v-col cols="4" v-if="pembelajaran.is_tematik">
                                                    <v-select label="Sub Tema" :items="subtemas" item-value="value" item-text="text" v-model="pembelajaran.subtema_id" dense hide-details></v-select>
                                                </v-col>
                                                <v-col cols="12" sm="4">
                                                    <v-file-input label="File RPP" outlined dense prepend-inner-icon="mdi-paperclip" prepend-icon="" @change="rppChange" accept="application/pdf"></v-file-input >
                                                </v-col>
                                                <v-col cols="12" sm="4">
                                                    <v-file-input label="File Materi" outlined dense prepend-inner-icon="mdi-paperclip" prepend-icon="" accept="application/pdf" @change="onChanged($event, 'materi')"></v-file-input >
                                                </v-col>
                                                <v-col cols="12" sm="4">
                                                    <v-file-input label="File Video" outlined dense prepend-inner-icon="mdi-video" prepend-icon="" accept="video/*"></v-file-input >
                                                </v-col>
                                                <!-- <v-col cols="12">Tanggal Pelaksanaan</v-col> -->
                                                <v-col cols="12" sm="4">
                                                    <v-date-picker label="Tanggal Pelaksanaan" v-model="pembelajaran.tanggal" :reactive="true" full-width class="elevation-3"></v-date-picker>
                                                </v-col>
                                                <v-col cols="12" sm="6">
                                                    <v-textarea label="Keterangan" outlined  multiline></v-textarea>
                                                </v-col>
                                                <v-col cols="12" class="d-flex justify-center">
                                                    <v-btn type="submit" color="primary">Simpan</v-btn>
                                                </v-col>
                                            </v-row>
                                        </v-form>
                                    <!-- </v-card-text>
                                </v-card> -->
                            </v-col>
                            <v-col cols="12" sm="4">
                                <v-card>
                                    <v-card-text>
                                        <h3>Kelengkapan</h3>

                                        <v-img>
                                            <p>File RPP</p>
                                            <object :data="fileRpp" width="100%"></object>
                                        </v-img>
                                    </v-card-text>
                                </v-card>
                            </v-col>
                         </v-row>
                    <!--</v-container> -->
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
export default {
    name: 'ModalPembelajaran',
    props: { dialog: Object },
    data: () => ({
        pembelajaran: {},
        periodes: [],
        rombels: [],
        fileRpp: null,
        temas: [],
        subtemas: [],
        rawtemas:[]
    }),
    methods: {
        onSelectTema(a){
            // console.log(a)
            let subtemas =[]
            this.rawtemas.forEach(item=>{
                if(item.tema_id == a){
                    subtemas.push({value: item.subtema.kode_subtema, text: item.subtema.kode_subtema.substr(2,1)+'. '+item.subtema.teks})
                }
            })
            console.log(subtemas)
            this.subtemas = subtemas
        },
        onTematik(e){
           if (e == true) {
               axios({
                   method: 'post',
                   url: '/dashboard/tema?kelas='+this.$page.props.rombel.kelas_id
               }).then(response => {
                   let temas = []
                   this.rawtemas = response.data.datas
                   response.data.datas.forEach(item => {
                       temas.push({value: item.tema_id, text: item.tema_id.substr(1,1)+'.'+item.tema.teks})
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