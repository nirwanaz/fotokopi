<template>
    <nav  class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link btn" @click="logout">Logout</a>
            </li>
            
        </ul>
    </nav>
</template>
<script>
export default {
    methods: {
        logout () {
            this.$store.dispatch('logout').then(() => {
                this.$router.push({name: 'indexSignIn'})
            })
        }
    }
}
</script>