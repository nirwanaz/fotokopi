<template>
    <div class="content-wrapper">
        <div class="d-flex flex-column">
            <div class="p-2">
                <h3>Halaman Kategori</h3>
            </div>
            <div class="p-2 align-self-center">
                <router-link :to="{ name: 'createStatuse' }" class="btn btn-primary">Tambah Status</router-link>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Status</th>
                                <th>Catatan Status</th>
                                <th>Tanggal buat</th>
                                <th>Tanggal update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(statuse,index) in statuses" :key="statuse.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ statuse.name }}</td>
                                <td>{{ statuse.note }}</td>
                                <td>{{ statuse.created_at }}</td>
                                <td>{{ statuse.updated_at }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <router-link :to="{ name:'show', params: { id: statuse.id }}" class="btn btn-primary">Tampil</router-link>
                                        <router-link :to="{ name:'edit', params: { id: statuse.id }}" class="btn btn-success">Ubah</router-link>
                                        <button class="btn btn-danger" @click="deleteStatuse(statuse.id)">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data () {
        return {
            statuses: []
        }
    },
    created () {
        let uri = '/api/statuses'
        this.axios.get(uri).then((response) => {
            this.statuses = response.data
        })
    },
    methods: {
        deleteStatuse(id){
            this.$swal.fire({
                title: 'Apakah kamu yakin ?',
                text: 'Jika kamu hapus data tidak akan kembali lagi',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#11111',
                confirmButtonText: 'Hapus deh',
                cancelButtonText: 'Gajadi aja'
            }).then((result) => {
                if (result.value) {
                    let uri = '/api/statuses/delete/${id}'
                    this.axios.delete(uri).then((response) => {
                        this.statuses.splice(this.statuses.indexOf(id), 1)
                        console.log(response.data)
                    })

                    this.$swal.fire({
                        title: 'Success',
                        text: 'Status berhasil dihapus',
                        icon: 'success',
                        timer: 1000
                    })

                    console.log("Status terhapus dengan id ..." + id)
                }
            })
        }
    }
}
</script>