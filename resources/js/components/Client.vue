<template>
    <div class="wrapper">
        <Navbar />
        <router-view></router-view>
        <Footer />
    </div>
</template>
<style>
    .bg-content {
        background: url('/images/bg-1.jpg');
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
    }
    @media (min-width: 768px) {
        body:not(.sidebar-mini-md) .bg-content {
         transition: none;
         margin-left: 0;
        }
    }
    .content-wrapper .main-home{
        padding: 0 250px;
    }
</style>
<script>
import Navbar from '../components/NavbarClient'
import Footer from '../components/FooterClient'

export default {
    components: { Navbar, Footer },
    mounted () {
        window.$('body').Layout();
    }    
}
</script>