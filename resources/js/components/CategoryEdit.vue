<template>
    <div class="content-wrapper">
        <div class="d-flex">
            <div class="p-2">
                <div class="alert alert-danger" v-if="errors.length">
                   <b>Terdapat kesalahan dalam input data</b>
                   <ul>
                       <li v-for="error in errors" :key="error">{{ error }}</li>
                   </ul>
                </div>
                <form @submit.prevent="updateCategory">
                    <div class="form-group">
                        <label htmlFor="CategoryId">Id Kategori</label>
                        <input type="text" class="form-control" id="CategoryId" v-model="categories.id">
                    </div>
                    <div class="form-group">
                        <label htmlFor="CategoryName">Nama Kategori </label>
                        <input type="text" class="form-control" id="CategoryName" v-model="categories.name">
                    </div>
                     <div class="form-group">
                        <label htmlFor="CategoryNote">Catatan Kategori </label>
                        <input type="text" class="form-control" id="CategoryNote" v-model="categories.note">
                    </div>
                    <div class="form-group">
                         <div class="btn-group">
                            <router-link :to="{ name: 'indexCategory'}" class="btn btn-primary">Balik</router-link>
                            <button class="btn btn-success">Simpan</button>
                        </div>
                    </div>
                </form>
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
    created () {
        let uri = '/api/categories/edit' + this.$route.params.id
        this.axios.get(uri).then((response) => {
            this.categories = response.data
        })
    },
    methods: {
        updateCategory (e) {
            if (this.$data.categories.name != null && this.$data.categories.id != null) {
                this.$swal.fire({
                    title: 'Success',
                    text: "Kategori berhasil diperbarui",
                    icon: 'success',
                    timer: 1000
                })

                let uri = '/api/categories/update' + this.$route.params.id
                this.axios.put(uri, this.categories).then((response) => {
                    this.$router.push({ name: 'indexCategory'})
                })
                return true
            }

            this.errors = []
            if (!this.name) {
                this.errors.push('Nama Kategori wajib diiisi')
            }

            if (!this.note) {
                this.errors.push('Catatan Kategori wajib diiisi')
            }

            e.preventDefault()
        }
    }
}
</script>