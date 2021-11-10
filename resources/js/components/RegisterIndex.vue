<template>
    <div class="content">
        <div class="d-flex flex-column justify-content-center">
            <div class="p-2">
                <div class="col-md-12">
                    <div class="row justify-content-center">
                        <div class="col-md-4" style="margin-top: 5%; background-color: lightblue; padding: 20px 40px 20px 40px">
                            <h3>Register User</h3>
                             <div class="alert alert-danger" v-if="errors.length">
                                <b>Terdapat kesalahan dalam input data</b>
                                <ul>
                                    <li v-for="error in errors" :key="error">{{ error }}</li>
                                </ul>
                            </div>                       
                            <form @submit.prevent="createAccount">
                                <div class="form-group">
                                    <label htmlFor="Fullname">Nama Lengkap </label>
                                    <input type="text" class="form-control" id="Fullname" v-model="user.name" placeholder="joni adventura">
                                </div>
                                <div class="form-group">
                                    <label htmlFor="Username">Username </label>
                                    <input type="text" class="form-control" id="Username" v-model="user.username" placeholder="joni adventura">
                                </div>
                                <div class="form-group">
                                    <label htmlFor="Password">Kata sandi </label>
                                    <input type="password" class="form-control" v-model="user.passwd" id="Password">
                                </div>
                                <div class="form-group">
                                    <label htmlFor="confirmPassword">Konfirmasi Kata Sandi </label>
                                    <input type="password" class="form-control" v-model="user.confirmpasswd" id="confirmPassword">
                                </div>
                                <div class="form-group text-center">
                                    <button class="btn btn-primary">Buat Akun</button>
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
            user: {},
            errors: [],
        }
    },
    methods: {
        createAccount (e) {
            this.errors = [];
            if (this.$data.user.passwd != null 
                    && this.$data.user.name != null 
                        && this.$data.user.username != null
                            && this.$data.user.confirmpasswd != null) {
                if (this.$data.user.passwd == this.$data.user.confirmpasswd) {
                    this.$store
                    .dispatch('register', this.user )
                    .then(response => {
                        console.log(response)
                        this.$router.push({ name: 'indexSignIn' })
                    })
                    .catch(error => {
                        this.errors = error.response.data.errors
                    }) 
                    
                } else {
                    this.errors.push('kata sandi tidak cocok') 
                }
            } 

            if (!this.user.name) {
                this.errors.push('nama wajib diisi')
            }

            if (!this.user.username) {
                this.errors.push('username wajib diisi')
            }

            if (!this.user.passwd) {
                this.errors.push('kata sandi wajib diisi')
            }

            if (!this.user.confirmpasswd) {
                this.errors.push('konfirmasi kata sandi wajib diisi')
            }

            e.preventDefault()
        }
    }
}
</script>