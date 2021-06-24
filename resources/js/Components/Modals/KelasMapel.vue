<template>
	<div>
		<v-dialog 
			v-model="modal" 
			transition="dialog-bottom-transition"
	        fullscreen
	        hide-overlay>
			<v-card>
				<v-toolbar dense>
					<v-toolbar-title>Data Mapel Kelas {{ kelas }}</v-toolbar-title>
					<v-spacer></v-spacer>
	                <v-btn icon @click="$emit('hide')">
	                    <v-icon>mdi-close</v-icon>
	                </v-btn>
				</v-toolbar>
				<v-card-text >
					<v-container>
						<v-row class="mt-2">
							<v-col cols="12" sm="6">
								<v-card>
									<v-toolbar dense>
										Sudah Masuk
										<v-spacer></v-spacer>
										<v-btn dense color="warning" @click.stop="keluarkan" :disabled="selected.length <1">Keluarkan</Keluarkan></v-btn>
									</v-toolbar>
									<v-card-text>
										<v-list >
											<v-list-item-group v-model="selected" multiple>
												<template v-for="item in includes" >
													<v-list-item
														dense
														:key="item.id"
														:value="item.id"
														active-class="deep-purple--text text--accent-4"
													>
														<template v-slot:default="{ active }">
															<v-list-item-content dense>
																<v-list-item-title v-text="item.label"></v-list-item-title>
															</v-list-item-content>
															<v-list-item-action>
																<v-checkbox
																	:input-value="active"
																	color="deep-purple accent-4"
																></v-checkbox>
															</v-list-item-action>
															<v-list-item-action>
																<v-btn text color="info" @click="kd(item)">KD</v-btn>
															</v-list-item-action>
														</template>
													</v-list-item>
												</template>
											</v-list-item-group>
										</v-list>
									</v-card-text>
								</v-card>
							</v-col>
							<v-col cols="12" sm="6">
								<v-card>
									<v-toolbar dense>
										Belum ada di Kelas {{ kelas }}
										<v-spacer></v-spacer>
										<v-btn dense color="primary" @click.stop="masukkan" :disabled="selectedX.length <1">Masukkan</v-btn>
									</v-toolbar>
									<v-card-text>
										<v-list>
											<v-list-item-group v-model="selectedX" multiple>
												<template v-for="item in excludes">
													<v-list-item
														:key="item.id"
														:value="item.id"
														active-class="deep-purple--text text--accent-4"
													>
														<template v-slot:default="{ active }">
															<v-list-item-content>
																<v-list-item-title v-text="item.label"></v-list-item-title>
															</v-list-item-content>
															<v-list-item-action>
																<v-checkbox
																	:input-value="active"
																	color="deep-purple accent-4"
																></v-checkbox>
															</v-list-item-action>
														</template>
													</v-list-item>
												</template>
											</v-list-item-group>
										</v-list>
									</v-card-text>
								</v-card>
							</v-col>
						</v-row>
					</v-container>
				</v-card-text>
			</v-card>
		</v-dialog>
		<v-dialog v-model="dialogkd">
			<v-card>
				<v-toolbar dense>
					Kompetensi Dasar kelas {{dialog.kelas.label}}, Mapel {{ selectedmapel }} 
					<v-spacer></v-spacer>
					<v-btn icon @click="dialogkd = false"><v-icon>mdi-close</v-icon></v-btn>
				</v-toolbar>
				<v-card-text>
					<v-data-table :items="kds" :headers="kdheaders" :search="searchkd" outlined >
						<template v-slot:top >
							<v-row class="mt-3">
								<v-col cols="12" sm="4"></v-col>
								<v-col cols="12" sm="4"></v-col>
								<v-col cols="12" sm="4">
									<v-text-field v-model="searchkd" prepend-inner-icon="mdi-magnify" label="Cari ..." clearable outlined dense></v-text-field>
								</v-col>
							</v-row>
							
						</template>
					</v-data-table>
				</v-card-text>
			</v-card>
		</v-dialog>
		<v-snackbar v-model="snackbar.show" :color="snackbar.color" bottom right>{{ snackbar.text }}</v-snackbar>
	</div>
</template>

<script>
	export default {
		name: 'KelasMapel',
		props: { dialog:Object },
		data: ()=>({
			searchkd: '',
			dialogkd: false,
			selectedmapel: '',
			kds: [],
			kdheaders: [
				{ value: 'index', text: 'No.'},
				{ value: 'kode_kd', text: 'Kode KD'},
				{ value: 'teks', text: 'Teks KD' }
			],
			header: [

			],
			mapels: [],
			includes:[
				
			],
			excludes:[],
			selected:[],
			selectedX:[],
			snackbar: { show: false },
		}),
		methods: {
			kd(mapel){
				// alert(this.dialog.kelas.kode_kelas+', '+ mapel.kode_mapel)
				this.selectedmapel = mapel.label
				this.dialogkd = true
				var kelas = this.dialog.kelas.kode_kelas, mapel = mapel.kode_mapel
				axios({
					method: 'post',
					url: '/dashboard/kd?kelas='+kelas+'&mapel='+mapel
				}).then( response => {
					let kds = response.data.kds
					let datas = []
					kds.forEach((kd,index) => {
						kd.index = index+1
						datas.push(kd)
					})
					this.kds = datas
				}).catch( err => {
					console.log( err )
				})
			},
			init(kelas) {
				// Ambil data mapel kelas
				axios({
					method: 'post',
					url: '/dashboard/kelas/'+kelas.id
				}).then( response => {
					let mapels = response.data.mapels
					// let ins = []
					// if (mapels.length >  0 ) {
					// 	mapels.forEach(mapel => {
					// 		ins.push(mapel)
					// 	})
					// }
					this.includes = mapels
				}).catch( err => {
					this.snackbar = { show: true, color: 'error', text: err.response.data.msg }
				})

				// Ambil data semua mapel
				axios({
					method: 'post',
					url: '/dashboard/mapel/tanpakelas?kelas_id='+kelas.id
				}).then( response => {
					let mapels = response.data.mapels
					// mapels.forEach( mapel => {
					// 	this.excludes.push(mapel)
					// })
					this.excludes = mapels
				}).catch( err => {
					this.snackbar = { show: true, color: 'error', text: err.response.data.msg }
				})
			},
			masukkan() {
				let mapels = this.selectedX
				// console.log(mapels)
				axios({
					method: 'post',
					url: '/dashboard/kelas/'+this.dialog.kelas.id+'/attach',
					data: {mapels: this.selectedX}
				}).then( response => {
					this.init(this.dialog.kelas)
					this.snackbar = { show: true, color: 'info', text: response.data.msg }
				}).catch( err => {
					this.snackbar = { show: true, color: 'error', text: err.response.data.msg }
					// console.log(err)
				})
			}
		},
		computed: {
			modal: {
				get() {
					return this.dialog.show
				},
				set(val) {
					this.$emit('hide', val)
				}
			},
			kelas() {
				return this.dialog.kelas ? this.dialog.kelas.tingkat: ''
			}
		},
		// watch: {
		// 	dialog(modal){
		// 		if (modal.show) {
		// 			this.init(modal.kelas)
		// 		}
		// 	}
		// }
		mounted() {
			this.init(this.dialog.kelas)
			// console.log(this.dialog)
		}
	}
</script>