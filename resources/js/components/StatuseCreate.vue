<template>
    <div class="content-wrapper">
        <div class="d-flex flex-column">
            <div class="p-2">
                <h3>Halaman Tambah Status</h3>
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
                            <form @submit.prevent="createStatuse">
                                <div class="form-group">
                                    <label htmlFor="StatuseName">Nama Status</label>
                                    <input type="text" class="form-control" id="StatuseName" v-model="statuses.name">
                                </div>
                                <div class="form-group">
                                    <label htmlFor="StatuseNote">Catatan Status</label>
                                    <input type="text" class="form-control" id="StatuseNote" v-model="statuses.note">
                                </div>
                                <div class="form-group text-center">
                                    <div class="btn-group">
                                        <router-link :to="{ name: 'indexStatuse'}" class="btn btn-primary">Balik</router-link>
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
            statuses: {},
            name: null
        }
    },
    methods: {
        createStatuse (e) {
            if (this.$data.statuses.name != null && this.$data.statuses.note != null) {
                this.$swal.fire({
                    title: 'Success',
                    text: "Status berhasil ditambahkan",
                    icon: 'success',
                    timer: 1000
                })

                let uri = '/api/statuses/store'
                this.axios.post(uri, this.statuses).then(() => {
                    this.$router.push({ name: 'indexStatuse'})
                }).catch(error => {
                    console.log(error)
                })
                return true
            }

            this.errors = []
            if (!this.name) {
                this.errors.push('Nama Status wajib diiisi')
            }
            
            if (!this.note) {
                this.errors.push('Catatan Status wajib diiisi')
            }

            e.preventDefault()
        }
    }
}
</script>