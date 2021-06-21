<template lang="html">
    <Layout :title="page_title">
        <v-container>
            <v-row>
                <v-col cols="12">
                    <v-card class="mt-5">
                        <v-toolbar dense>
                            <v-toolbar-title>
                                <v-icon>
                                    mdi-dots-vertical
                                </v-icon>
                                <span class="hidden-sm-and-down">Data</span> Pengguna
                            </v-toolbar-title>
                            <v-spacer></v-spacer>
                                <v-btn ripple   text @click.stop="newUser">
                                    <v-icon>mdi-account-plus</v-icon>
                                    <span class="hidden-sm-and-down">Tambah</span>
                                </v-btn>
                                <v-btn ripple text @click.stop="importDialog">
                                    <v-icon>mdi-account-multiple-plus</v-icon>
                                    <span class="hidden-sm-and-down">Impor</span>
                                </v-btn>
                                
                                <v-btn   ripple  text @click.stop="print">
                                    <v-icon>mdi-printer</v-icon>
                                    <span class="hidden-sm-and-down">
                                        Cetak
                                    </span>
                                </v-btn>
                                <v-btn   ripple text @click.stop="unduhData">
                                    <v-icon>mdi-file-excel-outline</v-icon>
                                    <span class="hidden-sm-and-down">
                                        Unduh
                                    </span>
                                </v-btn>
                        </v-toolbar>
                        <v-card-text>
                            <v-data-table
                                dense
                                :headers="headers"
                                :items="itemsWithIndex"
                                :search="cari"
                                show-select
                                v-model="selectedusers"
                            >
                            <template v-slot:top>
                                <v-row>
                                    <v-col cols="12" sm="4">
                                        
                                    </v-col>
                                    <v-col cols="12" sm="4">
                                        <v-badge
                                            :content="selectedusers.length"
                                            :value="selectedusers.length"
                                            color="success"
                                            overlap
                                          >
                                            <v-btn @click.stop="deleteMany" dense color="error" :disabled="(selectedusers.length < 1)" rounded>
                                                <v-icon>mdi-close-circle</v-icon> 
                                                Cabut Akses
                                            </v-btn>
                                        </v-badge>
                                    </v-col>
                                    <v-col cols="12" sm="4">
                                        <v-text-field v-model="cari" label="Cari ... " prepend-inner-icon="mdi-magnify" outlined rounded dense hide-details></v-text-field>
                                    </v-col>
                                </v-row>
                            </template>
                            <template v-slot:item.nama="{item}">
                                <span>
                                    {{ item.userable.name ? item.userable.name : item.userable.nama }}
                                </span>
                            </template>
                            <template v-slot:item.options="{item}">
                                <v-icon small class="mr-2 warning--text" @click.stop="editItem(item)">mdi-pencil</v-icon>
                                <v-icon small class="mr-2 error--text" @click.stop="deleteItem(item)">mdi-eraser</v-icon>
                            </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-card class="mt-5">
                        <v-toolbar dense >
                            <v-toolbar-title>
                            <v-icon>mdi-dots-vertical</v-icon>
                            Grafik Pengguna</v-toolbar-title>
                        </v-toolbar>
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="4">
                                    <v-card>
                                        <v-card-title>
                                            <v-icon>mdi-gender-male-female</v-icon>
                                            Gender Pengguna
                                        </v-card-title>
                                        <v-card-text>
                                            <div id="chart">
                                                
                                            </div>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <v-card>
                                        <v-card-title>
                                            <v-icon>mdi-account-hard-hat</v-icon>
                                            Role Pengguna
                                        </v-card-title>
                                        <v-card-text>
                                            <div id="chart-role">
                                            </div>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                                <v-col cols="12" sm="4">
                                    <v-card>
                                        <v-card-title>
                                            <v-icon>mdi-account-tie</v-icon>
                                            Status Pengguna
                                        </v-card-title>
                                        <v-card-text>
                                            <div id="chart-status">
                                            </div>
                                        </v-card-text>
                                    </v-card>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-col>
                
            </v-row>
        </v-container>
        <v-dialog 
            v-model="dialog" 
            transition="dialog-bottom-transition" 
            max-width="700">
            <v-card light>
                <v-toolbar
                    color="secondary"
                    light
                    dense
                >
                {{ dialogTitle }}
                <v-spacer></v-spacer>
                <v-btn fab small @click="dialog = false" color="error"><v-icon>mdi-close</v-icon></v-btn>
                </v-toolbar>
                <v-card-text>
                    <v-form @submit="simpan">
                        <v-container fluid>
                        <v-row>
                            <v-col cols="12" sm="6">
                                <v-text-field v-model="newuser.userid" :label="(newuser.level == 'siswa') ? 'NISN' :'NIP'" outlined dense hide-details clearable append-icon="mdi-barcode"></v-text-field>
                            </v-col>
                            <!-- <v-col cols="12" sm="6">
                                <v-text-field v-model="newuser.name" label="Nama Lengkap" outlined dense hide-details append-icon="mdi-card-text"></v-text-field>
                            </v-col> -->
                            <v-col cols="12" sm="4">
                                <v-text-field v-model="newuser.username" :label="(newuser.level == 'siswa') ? 'NISN' : 'Username'" outlined dense hide-details append-icon="mdi-qrcode"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="8">
                                <v-text-field v-model="newuser.email" label="Email" type="email" outlined dense hide-details append-icon="mdi-email"></v-text-field>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <v-text-field v-model="newuser.password" label="Password / Sandi" outlined dense hide-details append-icon="mdi-fingerprint"></v-text-field>
                            </v-col>
                            <!-- <v-col cols="12" sm="4">
                                <v-select v-model="newuser.jk" :items="jks" item-value="id" item-text="text" label="Jenis Kelamin" outlined dense hide-details append-icon="mdi-gender-male-female"></v-select>
                            </v-col> -->
                            <!-- <v-col cols="12" sm="4">
                                <v-text-field v-model="newuser.hp"  label="No. HP" outlined dense hide-details append-icon="mdi-whatsapp"></v-text-field>
                            </v-col> -->
                           <!--  <v-col cols="12">
                                <v-textarea auto-grow v-model="newuser.alamat" label="Alamat" outlined dense hide-details append-icon="mdi-map-marker" rows="2" row-height="15"></v-textarea>
                            </v-col> -->
                            <v-col cols="12" sm="4">
                                <v-select v-model="newuser.level" :items="levels" item-value="value" item-text="text" outlined dense hide-details append-icon="mdi-account-tie" label="Level"></v-select>
                            </v-col>
                            <v-col cols="12" sm="4">
                                <v-select v-model="newuser.role" :items="roles" item-value="value" item-text="text" outlined dense hide-details append-icon="mdi-account-hard-hat" label="Role"></v-select>
                            </v-col>
                            <!-- <v-col cols="12" sm="4">
                                <v-select v-model="newuser.status" :items="status" item-value="value" item-text="text" outlined dense hide-details append-icon="mdi-seal" label="Status Pegawai"></v-select>
                            </v-col> -->
                            <v-col cols="12" class="d-flex justify-center">
                                <v-btn class="flat" type="submit" light color="primary">Simpan</v-btn>
                            </v-col>
                            
                        </v-row>
                    </v-container>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-dialog>

        <v-dialog
            v-model="dialogImport"
            transition="dialog-bottom-transition"
            fullscreen
            hide-overlay
        >
            <v-toolbar 
                dense
                color="secondary"
                dark
            >
                <v-toolbar-title>
                    <v-icon>mdi-account-multiple-plus</v-icon>
                    Impor User
                </v-toolbar-title>
                <v-spacer></v-spacer>
                <v-toolbar-items>
                    <v-btn icon @click="dialogImport = false">
                        <v-icon>mdi-close</v-icon>
                    </v-btn>
                </v-toolbar-items>
            </v-toolbar>
            <v-card>
                <v-card-text>
                    <v-container fluid>
                        <v-row>
                            <v-col cols="12" sm="9">
                                <v-card>
                                    <v-toolbar dense>
                                        <v-card-title>Daftar Calon User</v-card-title>
                                        <v-divider vertical></v-divider>
                                        <v-spacer></v-spacer>
                                            <v-text-field
                                                label="Cari Data"
                                                v-model="search"
                                                single-line
                                                hide-details
                                                flat
                                                dense
                                                append-icon="mdi-magnify"
                                                clearable
                                                :disabled="(newusers.length < 1)"
                                            >
                                            </v-text-field>
                                    </v-toolbar>
                                    <v-data-table
                                        :items="newusers"
                                        :headers="newheaders"
                                        dense
                                        :search="search"
                                        no-data-text="Data Tidak Ditemukan"
                                    >

                                    </v-data-table>
                                </v-card>
                            </v-col>
                            <v-col cols="12" sm="3">
                                <v-card>
                                    <v-toolbar>
                                        Pilih File Excel
                                    </v-toolbar>
                                    <v-card-text>
                                        <label>Pilih file yang berisi data pengguna yang akan disimpan yang berupa xls, xlsx, csv.</label>
                                        <v-file-input 
                                            dense 
                                            outlined 
                                            prepend-icon="" 
                                            append-icon="mdi-file-excel" 
                                            label="Pilih File" 
                                            accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
                                            @change="onFilePicked"
                                        ></v-file-input>
                                        <v-divider></v-divider>
                                        <v-checkbox v-model="checknewusers" label="Data Pengguna Baru Sudah Benar" @change="checkNewUsers" :disabled="(newusers.length < 1 ) ? true:false"></v-checkbox>
                                        <v-btn :disabled="!checknewusers" color="secondary" :dark="checknewusers" class="ma-auto" @click.stop="importUsers">Simpan</v-btn>

                                    </v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog
            v-model="errorDialog"
            max-width="400"
        >
            <v-card 
                
                color="error"
                dark
            >
                <v-card-title>Format Kolom Salah.</v-card-title>
                <v-card-text>
                    <v-container fluid>
                        <v-row>
                            <v-col cols="12">
                                <a href="/img/format-xls-user.png" target="__blank">
                                <v-img
                                    src="/img/format-xls-user.png" alt="Gambar"
                                    title="Klik untuk melihat contoh format"
                                />
                                </a>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <div class="d-flex justify-center">
                                    <v-btn color="secondary" @click.stop="genTemplate">Download Contoh Format</v-btn>
                                </div>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
            </v-card>
        </v-dialog>
        <v-dialog v-model="hapus.open" max-width="500">
            <v-card color="warning" dark>
                <v-container>
                <v-card-title class="center--text">Yakin Mengapus Data: </v-card-title>
                <v-card-text>
                    <h2>{{hapus.user.name}}</h2>
                </v-card-text>
                <v-card-actions>
                    <v-btn light @click.stop="hapus.open=false; hapus.user = {};"><v-icon>mdi-cancel</v-icon>Batal</v-btn>
                    <v-btn light @click.stop="confirmDelete"> <v-icon>mdi-eraser</v-icon>Iya, Lanjutkan</v-btn>
                </v-card-actions>
                </v-container>
            </v-card>
        </v-dialog>
        <v-snackbar v-model="snackbar.show" top right multi-line :color="snackbar.color">
            {{ snackbar.text }}
        </v-snackbar>
    </Layout>
</template>

<script>
import Layout from '../Layout/Dashboard'
// import ModalUser from '../Components/Modals/ModalUser.vue'
import ApexCharts from 'apexcharts'
import XLSX from 'xlsx'
import saveAs from 'file-saver'
import Download from '../Plugins/Download'
export default {
    components: {
        Layout,
        // ModalUser
    },
    props: {
        user: Object,
        page_title: String
    },
    data: () => ({
        selectedusers: [],
        cari: '',
        status: [
            {value: 'pns', text: 'PNS'},
            {value: 'gtt', text: 'GTT'},
            {value: 'ptt', text: 'PTT'},
        ],
        hapus: {
            open: false,
            user: {}
        },
        search:'',
        newusers: [],
        newheaders:[
            {
                text: 'nip',
                value: 'nip'
            },
            {
                text: 'Nama',
                value: 'nama_siswa'
            }
        ],
        checknewusers: false,
        snackbar: {
            show: false,
            text: 'Halo'
        },
        errorDialog: false,
        dialogImport: false,
        levels: [
            {value:'admin',
            text: 'Admin'},
            {value: 'guru',text: 'Guru'},
            {value: 'siswa',text: 'Siswa'},
            ],
        roles: [
            {value:'admin',text: 'Admin'},
            {value: 'ks',text: 'Kepala Sekolah'},
            {value: 'wali',text: 'Wali Kelas'},
            {value:'gpai',text:'Guru PAI'}, 
            {value:'gor', text: 'Guru Olah Raga'}, 
            {value:'gbig', text: 'Guru Bahasa Inggris'},
            {value:'siswa', text: 'Siswa'}
            ],
        dialog: false,
        dialogTitle: 'Tambah Pengguna Baru',
        headers: [
            {
                text: 'No',
                value: 'index',
                align: 'start',
                sortable: false,
            },
            {
                text: 'NIP',
                value: 'userid'
            },
            {
                text: 'Nama',
                value: 'nama'
            },
            {
                text: 'Username',
                value: 'username'
            },
            {
                text: 'Jk',
                value: 'userable.jk'
            },
            {
                text: 'Level',
                value: 'level'
            },
            
            {
                text: 'Opsi',
                value: 'options'
            }
        ],
        items: [],
        newuser: {

        },
        jks: [
            {id: 'l', text: 'Laki-laki'},
            {id: 'p', text: 'Perempuan'},
        ],
    }),
    methods: {
        deleteMany() {

        },
        newUser(){
            this.newuser = Object.assign({},{})
            this.dialog = true
            this.dialogTitle = 'Tambah Pengguna Baru'
        },
        importUsers() {
            let users = this.newusers
            axios({
                method: 'post',
                url: '/dashboard/user/import',
                data: {users: users}
            }).then(response => {
                // console.log(response)
                this.dialogImport = false
                this.newusers = []
                this.getUsers()
                this.snackbar = {
                    show: true,
                    color: 'success',
                    text: response.data.msg
                }

            }).catch(err => {
                console.log(err.response)
            })
        },
        importDialog() {
            this.dialogImport = true
        },
        onFilePicked(e) {
            // console.log(e)
            if (e == null) {
                this.newusers = []
                this.newheaders = []
                return false
            }
            var files = e.files;
            var reader = new FileReader
            reader.onload = ev => {
                var data = ev.target.result
                var workbook = XLSX.read(data,{type: 'binary'})

                var wsname = workbook.SheetNames[0]
                const ws = XLSX.utils.sheet_to_json(workbook.Sheets[wsname])
                const lists = []

                for ( var i = 0; i < ws.length; i++ ) {
                    lists.push(ws[i])
                }
                this.newusers = lists
                // console.log(lists)
                // GetHeaders
                const a = workbook.Sheets[workbook.SheetNames[0]]
                const headers = this.getHeaders(a)
                
                this.newheaders = headers
                // console.log(valid)
            }
            reader.readAsBinaryString(e)
        },
        getHeaders(sheet) {
            const headers = []
            const check = []
            const range = XLSX.utils.decode_range(sheet["!ref"])
            let C;

            const R = range.s.r
            let i = 0
            for (C = range.s.c; C <= range.e.c; ++C) {
                var cell = sheet[XLSX.utils.encode_cell({c:C, r:R})]

                var hdr = "UNKNOWN"+C
                if ( cell && cell.t) hdr = XLSX.utils.format_cell(cell)
                if( hdr.indexOf('UNKNOWN') > -1 ) {
                    if(!i) {
                        hdr = '__EMPTY'
                    } else {
                        hdr = '__EMPTY'+i
                    }
                    i++
                }
                check.push(hdr)
                headers.push({text:hdr, value:hdr})
            }
            var valid = this.checkHeaders(check)
            if (valid == true) {
                return headers
            } else {
                this.errorDialog = true
            }
        },
        genTemplate() {
            var wb = XLSX.utils.book_new()
            wb.Props = {
                Title: "Template Import User",
                Author: "noname"
            }

            wb.SheetNames.push("Sheet 1")

            var ws_data =[['nip', 'nama', 'username', 'email', 'password', 'jk', 'alamat', 'hp', 'level', 'role']]

            var ws = XLSX.utils.aoa_to_sheet(ws_data)
            wb.Sheets["Sheet 1"] = ws

            var wbout = XLSX.write(wb, {bookType: 'xlsx', type: 'binary'})

            var buf = new ArrayBuffer(wbout.length)
            var view = new Uint8Array(buf)
            for (var i=0;i< wbout.length;i++) view[i] = wbout.charCodeAt(i) & 0xFF;

            saveAs(new Blob([buf], {type: "application/octet-stream"}), "Format User.xlsx")
        },

        checkHeaders(headers) {
            var v = 0
            const valids = ['nip', 'nama', 'username', 'email', 'password', 'jk', 'alamat', 'hp', 'level', 'role']
            if ( headers.length < valids.length) {
                return false
            } else {
                
                // for (const v of new Set([...valids, ...headers]))
                //     if (valids.filter(e => e === v).length !== headers.filter(e => e === v).length)
                //     return false;
                // return true;
                for ( var i=0;i < valids.length; i++) {
                    if(headers.includes(valids[i])) v++
                }
            }
            if (v < valids.length) {
                return false
            } else {
                return true
            }
        },
        unduhData() { 
            Download.UnduhExcel(this.items, 'Data Pengguna')
        },
        print() {
            var datas = this.items
            var win = window.open('', '_blank', 'width=900,height=800,left=100')
            var tr = ''
                datas.forEach((user,index) => {
                    tr += `<tr>
                            <td>${index+1}</td><td>${user.nip}</td><td>${user.name}</td><td>${user.username}</td><td>${user.email}</td><td>${user.jk}</td><td>${user.alamat}</td><td>${user.hp}</td>
                        </tr>`
                })

            var html = `
                    <!doctype html>
                    <html>
                        <head>
                            <title>Cetak Data Pengguna</title>
                            <style>
                                * {
                                    font-family: 'sans-serif';
                                }
                                h1 {
                                    text-align: center;
                                    text-transform: uppercase;
                                }
                                table {
                                    border-collapse: collapse;
                                    font-family: 'sans-serif';
                                }
                                table tbody tr:nth-child(odd) {
                                    background: #efefef;
                                }
                                th {
                                    text-align: center;
                                }
                                td {
                                    padding: 5px 20px;
                                }
                            </style>
                        </head>
                        <body>
                            <div class="wrapper">
                                <h1>Data Pengguna</h1>
                                <table border="1">
                                    <thead>
                                        <tr>
                                            <th>No</th><th>NIP</th><th>Nama</th><th>Username</th><th>Email</th><th>JK</th><th>Alamat</th><th>HP</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        ${tr}
                                    </tbody>
                                </table>
                            </div>
                        </body>
                    </html>
            
            `
            win.document.write(html)

            setTimeout(function(){
                win.print()
                win.close()
            },500)

            
        },
        checkNewUsers(e) {
            this.checknewusers = e
        },
        editItem(item) {
            this.newuser = item,
            this.dialogTitle = 'Perbarui Data '+item.username
            this.dialog = true
        },
        deleteItem(item) {
            this.hapus = {open: true, user: item}
        },
        confirmDelete() {
            let user = this.hapus.user
            axios({
                method: 'post',
                url: '/dashboard/user/'+user.id,
                data: {_method: 'delete'}
            }).then(response => {
                
                this.snackbar = {
                    show: true,
                    color: 'success',
                    text: 'Data ' + user.name + ' Berhasil dihapus'
                    }
                this.hapus = {open: false, user: {}}
                this.getUsers()
            }).catch(err => {
                this.hapus = {open: false, user: {}}
                this.snackbar = {
                    show: true,
                    color: 'error',
                    text: err.response.data.msg
                }
                this.getUsers()
            })
        },
        getUsers() {
            axios({
                method: 'post',
                url: '/dashboard/user'
            }).then(response => {
                this.items = response.data.users
                this.grafik(response.data.users)
            })
        }, 
        simpan(e) {
            e.preventDefault()
            let user = this.newuser
            // console.log(user)
            axios({
                method: 'post',
                url: '/dashboard/user/store',
                data: user
            }).then(response => {
                this.snackbar = {
                    show: true,
                    text: response.data.msg,
                    color: 'success'
                }
                this.getUsers()
                this.dialog = false
            }).catch(err => {
                this.snackbar = {
                    show: true,
                    text: err.response.data,
                    color: 'error'
                }
                // conso+le.log(err.response)
            })
        },
        grafik(users){
            // var users = this.items
            
            let byjks = [0,0];
            let byroles = [0,0,0,0,0];
            let bystatus = [0,0]
            let labelstatus = ['PNS', 'GTT'];
            let labelsjk = ['Laki-laki', 'Perempuan'];
            let labelsrole = ['Kepala Sekolah','Wali Kelas', 'Guru PAI','Guru Olahraga','Guru Bhs. Inggris']

            // console.log(users)
            users.forEach(user => {
                // By JK
                if (user.jk == 'l') {
                    byjks[0] += 1
                } else {
                    byjks[1] += 1
                }
                // By Role
                if (user.role == 'ks' ) {
                    byroles[0] += 1
                } else if (user.role == 'wali' ) {
                    byroles[1] += 1
                } else if ( user.role == 'gpai' ) {
                    byroles[2] += 1
                } else if (user.role == 'gor') {
                    byroles[3] += 1
                } else {
                    byroles[4] += 1
                }
                // By Status
                if (user.status == 'pns') {
                    bystatus[0] += 1
                } else {
                    bystatus[1] += 1
                }

                    

            })
            // console.log(byroles)
            var chartjk = new ApexCharts(document.querySelector("#chart"), {chart: {
                    type: 'pie'
                },
                series: byjks,
                labels: labelsjk})

            var chartrole = new ApexCharts(document.querySelector('#chart-role'), { 
                chart: { type: 'pie'}, series: byroles, labels: labelsrole
                })

            var chartstatus = new ApexCharts(document.querySelector("#chart-status"), {
                chart: { type: 'pie'}, series: bystatus, labels: labelstatus
            })
            chartjk.render();
            chartrole.render()
            chartstatus.render()
        }
    },
    computed: {
        itemsWithIndex() {
            var nitems = []
            this.items.map((items, index) => {
                items.index = index+1,
                nitems.push(items)
            })

            return nitems
        }
    },
    created() {
        this.getUsers()
        
    }, mounted() {
        // this.grafik()
    }
}
</script>