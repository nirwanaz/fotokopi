<template>
    <div class="content-wrapper">
        <div class="d-flex flex-column">
            <div class="p-2">
                <h3>Halaman Tambah Kategori</h3>
            </div>
            <div class="p-4">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="alert alert-danger" v-if="errors.length">
                                <b>Terdapat kesalahan dalam input data</b>
                                <ul>
                                    <li v-for="error in errors" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                            <form @submit.prevent="createCategory">
                                <div class="form-group">
                                    <label htmlFor="CategoryName">Nama Kategori </label>
                                    <input type="text" class="form-control" id="CategoryName" v-model="categories.name">
                                </div>
                                <div class="form-group">
                                    <label htmlFor="CategoryNote">Catatan </label>
                                    <input type="text" class="form-control" id="CategoryNote" v-model="categories.note">
                                </div>
                                <div class="form-group text-center">
                                    <div class="btn-group">
                                        <router-link :to="{ name: 'indexCategory'}" class="btn btn-primary">Balik</router-link>
                                        &nbsp; &nbsp;
                                        <button class="btn btn-success">Simpan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</template>
<script>
export default {
    data () {
        return {
            errors: [],
            categories: {},
            name: null
        }
    },
    methods: {
        createCategory (e) {
            if (this.$data.categories.name != null) {
                this.$swal.fire({
                    title: 'Success',
                    text: "Kategori berhasil ditambahkan",
                    icon: 'success',
                    timer: 1000
                })

                let uri = '/api/categories/store'
                this.axios.post(uri, this.categories).then((response) => {
                    this.$router.push({ name: 'indexCategory'})
                })
                return true
            }

            this.errors = []
            if (!this.name) {
                this.errors.push('Nama Kategori wajib diiisi')
            }

            if (!this.note) {
                this.errors.push('Catatan Kategori wajib diisi')
            } 

            e.preventDefault()
        }
    }
}
</script>