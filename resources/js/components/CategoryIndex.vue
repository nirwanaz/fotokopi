<template>
    <div class="content-wrapper">
        <div class="d-flex flex-column">
            <div class="p-2">
                <h3>Halaman Kategori</h3>
            </div>
            <div class="p-2 align-self-center">
                <router-link :to="{ name: 'createCategory' }" class="btn btn-primary">Tambah Kategori</router-link>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Catatan Kategori</th>
                                <th>Tanggal buat</th>
                                <th>Tanggal update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(category,index) in categories" :key="category.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ category.name }}</td>
                                <td>{{ category.note }}</td>
                                <td>{{ category.created_at }}</td>
                                <td>{{ category.updated_at }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <router-link :to="{ name:'show', params: { id: category.id }}" class="btn btn-primary">Tampil</router-link>
                                        <router-link :to="{ name:'edit', params: { id: category.id }}" class="btn btn-success">Ubah</router-link>
                                        <button class="btn btn-danger" @click="deleteCategory(category.id)">Hapus</button>
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
            categories: []
        }
    },
    created () {
        let uri = '/api/categories'
        this.axios.get(uri).then((response) => {
            this.categories = response.data
        })
    },
    methods: {
        deleteCategory(id){
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
                    let uri = '/api/categories/delete/${id}'
                    this.axios.delete(uri).then((response) => {
                        this.categories.splice(this.categories.indexOf(id), 1)
                        console.log(response.data)
                    })

                    this.$swal.fire({
                        title: 'Success',
                        text: 'Kategori berhasil dihapus',
                        icon: 'success',
                        timer: 1000
                    })

                    console.log("kategori telah terhapus dengan id ..." + id)
                }
            })
        }
    }
}
</script>