<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="#" class="brand-link">
            <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="Logo" 
                class="brand-image elevation-3" style="opacity: 0.8">
                <span class="brand-text font-weight-light">
                    AdminLTE3
                </span>
        </a>
        <div class="brand-name" v-if="user">
            <ul class="flex-column mt-2">
                <li class="nav-item">
                    <h3 style="color:#ffff">{{ user.username }}</h3>
                </li>
                <li class="nav-item">
                    <p style="color:#ffff">Hello, {{ user.name }}</p>
                </li>
            </ul>
        </div>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <router-link :to="{ name: 'dashboard'}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Dashboard</p>
                        </router-link>
                        <router-link :to="{ name: 'indexOrder'}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Order</p>
                        </router-link>
                        <router-link :to="{ name: 'indexCategory'}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Category</p>
                        </router-link>
                        <router-link :to="{ name: 'indexStatuse'}" class="nav-link">
                            <i class="nav-icon fas fa-home"></i>
                            <p>Status</p>
                        </router-link>                        
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>
<script>
import {mapGetters} from 'vuex' 
export default {
    computed: {
        ...mapGetters({
            isLoggedIn: 'isLoggedIn',
            user: 'user'
        })
    }
}
</script>