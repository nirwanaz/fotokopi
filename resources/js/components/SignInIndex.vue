<template>
    <div class="content">
        <div class="d-flex justify-content-center">
            <div class="p-2 d-flex flex-column" style="margin-top:10%; border: 1px solid">
                <div class="p-2 heading">
                    <h3>Halaman Login</h3>
                </div>
                <div class="p-4">
                    <div class="alert alert-danger" v-if="errors.length">
                        <b>Terdapat kesalahan dalam input data</b>
                        <ul>
                            <li v-for="error in errors" :key="error">{{ error }}</li>
                        </ul>
                    </div>  
                    <form @submit.prevent="authenticate">
                        <div class="form-group">
                            <label htmlFor="Username">Username</label>
                            <input type="text" class="form-control" id="Username" v-model="user.username" placeholder="joni123">
                        </div>
                        <div class="form-group">
                            <label htmlFor="Password">Password</label>
                            <input type="password" class="form-control" v-model="user.passwd" id="Password">
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary">Sign In</button>
                            &nbsp;
                            &nbsp;
                            <router-link :to="{ name:'indexForgotPassword' }" class="text-center">Lupa password</router-link>                            
                        </div>
                        <div class="form-group">
                            <router-link :to="{ name:'indexRegister' }" class="text-center">Belum punya akun? Daftar disini </router-link>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data () {
        return {
            user: {
                username: null,
                passwd: null
            },
            errors: []
        }
    },
    methods: {
        authenticate () {
            this.errors = []

            if (this.$data.user.username != null && this.$data.user.passwd != null){
                this.$store.dispatch('login', this.user).then(response => {
                    console.log(response)
                    this.$swal.fire({
                        title:'success',
                        text: 'Tunggu Sebentar',
                        icon: 'success',
                        timer: 5000
                    })
                    //this.$router.push({name: 'admin'})
                }).catch(error => {
                   console.log(error)
                })
            }

            if (!this.user.username) {
                this.errors.push('username wajib diisi')
            }

            if(!this.user.passwd) {
                this.errors.push('password wajib diisi')
            }
            
        }
    }
}
</script>