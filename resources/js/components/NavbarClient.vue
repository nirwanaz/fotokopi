<template>
    <nav  class="main-header navbar navbar-expand navbar-white navbar-light" style="margin-left: 0">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-bars"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                 <router-link :to="{ name: 'createOrder'}" class="nav-link" style="background:  #449cc5; color: white"><i class="fas fa-inbox"></i>
                    Pemesanan
                </router-link>
            </li>
            <li class="nav-item">
                <router-link :to="{ name: 'indexTracking'}" class="nav-link" style="background:  #449cc5; color: white"><i class="fas fa-truck"></i>
                    Tracking
                </router-link>
            </li>
        </ul>
    </nav>
</template>
<style>
    .main-header .navbar-nav .nav-item{
        margin: 0 20px 0 0;
    }
</style>