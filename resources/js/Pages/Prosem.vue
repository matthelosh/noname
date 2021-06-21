<template>
    <Layout :page_title="page_title">
        <v-container>
            <v-row>
                <v-col cols="12">
                    <v-card>
                        <v-toolbar dense>
                            Program Semester
                        </v-toolbar>
                        <v-card-text>
                            <h3> Sem 1:</h3>
                            <table class="table" border="1" width="100%" style="border-collapse:collapse;padding: 5px 10px;">
                                <thead>
                                    <tr>
                                        <th style="padding: 5px 10px;">Kode mapel</th>
                                        <th style="padding: 5px 10px;">KD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(prosem,i) in prosems.ganjil" :key="i"
                                    >
                                        <td style="padding: 5px 10px;">{{i}}: </td>
                                        <td style="padding: 5px 10px;">{{prosem}}</td>
                                    </tr>
                                </tbody>
                                
                            </table>

                            <h3>Sem 2</h3>
                            <table class="table" border="1" width="100%" style="border-collapse:collapse;padding: 5px 10px;">
                                <thead>
                                    <tr>
                                        <th style="padding: 5px 10px;">Kode mapel</th>
                                        <th style="padding: 5px 10px;">KD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="(prosem,i) in prosems.genap" :key="i"
                                    >
                                        <td style="padding: 5px 10px;">{{i}}: </td>
                                        <td style="padding: 5px 10px;">{{prosem}}</td>
                                    </tr>
                                </tbody>
                                
                            </table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </Layout>
</template>

<script>
    import Layout from '../Layout/Dashboard'
    export default {
        name: 'Prosem',
        props: {
            page: String, page_title: String
        },
        components: {Layout},
        data: () =>({
            prosems: [],
        }),
        methods: {
            init() {
                this.getProsems()
            },
            getProsems(){
                var query = (this.$page.props.user.role == 'wali') ? 'kelas='+this.$page.props.rombel.kelas_id : 'mapel='+this.$page.props.mapel
                axios.post('/dashboard/prosem?'+query)
                    .then( res => {
                        this.prosems = res.data.prosems
                    }).catch( err => {
                        console.log(err.response)
                    })
            }
        },
        computed: {

        },
        created() {
            this.init()
        }
    }

</script>

<style scoped>
    table {
        border-collapse: collapse;
    }

    th,td {
        padding: 3px 10px;
    }
</style>