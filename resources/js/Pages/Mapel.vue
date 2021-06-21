<template>
	<div>
		<Layout :title="page_title">
			<v-container>
				<v-row>
					<v-col cols="12">
						<v-card>
							<v-toolbar dense>
								<v-toolbar-title>{{ page_title }}</v-toolbar-title>
								<v-spacer></v-spacer>
	                            <v-btn ripple   text @click.stop="newMapel">
	                                <v-icon>mdi-plus</v-icon>
	                                <span class="hidden-sm-and-down">Tambah</span>
	                            </v-btn>
	                            <v-btn ripple text @click.stop="importmapel = true">
	                                <v-icon>mdi-import</v-icon>
	                                <span class="hidden-sm-and-down">Impor</span>
	                            </v-btn>
	                            <span class="hidden-sm-and-down">
	                            <v-btn   ripple  text @click.stop="print">
	                                <v-icon>mdi-printer</v-icon>
	                                    Cetak
	                            </v-btn>
	                            </span>
	                            <v-btn   ripple text @click.stop="exportMapel">
	                                <v-icon>mdi-file-excel-outline</v-icon>
	                                <span class="hidden-sm-and-down">
	                                    Unduh
	                                </span>
	                            </v-btn>
							</v-toolbar>
							<v-card-text>
								<v-data-table :items="mapels" :headers="headers" class="elevation-3" dense>
									<template v-slot:top > 
										<v-container>
											<v-row>
												<v-col cols="12" sm="4">
													<v-card-title>Data Mapel</v-card-title>
												</v-col>
												<v-col cols="12" sm="4"></v-col>
												<v-col cols="12" sm="4">
													<v-text-field outlined dense append-icon="mdi-magnify" clearable hide-details v-model="search" label="Cari ..."></v-text-field>
												</v-col>
											</v-row>
										</v-container>
									</template>
									<template v-slot:item.options="{item}">
										<span>
											<v-btn icon dense @click.stop="deleteMapel(item)">
												<v-icon color="error">mdi-delete</v-icon>
											</v-btn>
											<v-btn icon dense @click.stop="editMapel(item)">
												<v-icon color="warning">mdi-pencil</v-icon>
											</v-btn>
										</span>
									</template>
								</v-data-table>
							</v-card-text>
						</v-card>
					</v-col>
				</v-row>
			</v-container>
		</Layout>
		<div v-if="snackbar.show = true">
			<v-snackbar v-model ="snackbar.show" :color="snackbar.color">
				{{ snackbar.text }}
			</v-snackbar>
		</div>
		<div v-if="dialog.show ==true">
			<modal-mapel :dialog="dialog" @refresh="refresh" @err="onerr"></modal-mapel>
		</div>
	</div>
</template>

<script>
import Layout from '../Layout/Dashboard.vue'
import ModalMapel from '../Components/Modals/ModalMapel'
export default {
	name: 'Mapel',
	props: { page: String, page_title: String},
	components: {Layout, ModalMapel},
	data: () => ({
		search: '',
		importmapel: false,
		mapels: [
			// {'index':1,kode_mapel:'mtk',nama_mapel: 'Matematika', label: 'MTK', deskripsi: 'Mapel MTK'}
		],
		headers: [
			{ value: 'index', text: 'No', sortable: false },
			{ value: 'kode_mapel', text: 'Kode Mapel' },
			{ value: 'nama_mapel', text: 'Nama Mapel' },
			{ value: 'label', text: 'Label' },
			{ value: 'deskripsi', text: 'Deskripsi' },
			{ value: 'options', text: 'Opsi' },
		],
		snackbar: { show: false },
		dialog: {show: false},
	}),
	methods: {
		refresh(){
			this.snackbar = { show: true, color: 'success', }
		},
		init() {
			axios({
				method: 'post',
				url: '/dashboard/mapel',
			}).then( response => {
				let mapels = []
				response.data.mapels.forEach((mapel,index) => {
					mapel.index = index+1
					mapels.push(mapel)
					this.mapels = mapels
				})
				this.snackbar = { show: true, color: 'success', text: response.data.msg }
			}).catch( err => {
				this.snackbar = { show: true, color: 'error', text: err.response.data.msg }
			})
		},
		onerr(val) {
			this.snackbar = new Object.assign(this.snackbar, val)
		},
		newMapel() {
			this.dialog = { show: true, mode: 'create' }
		},
		print() {},
		exportMapel() {},
		deleteMapel(mapel) {
			alert(mapel.label)
		},
		editmapel(mapel) {

		}
	},
	computed: {

	},
	created() {
		this.init()
	}
}
</script>