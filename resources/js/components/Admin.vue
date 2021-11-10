<template>
    <div class="wrapper">
        <Navbar />
        <Sidebar />
        <router-view></router-view>
        <Footer />
    </div>
</template>
<script>
import Navbar from '../components/Navbar'
import Sidebar from '../components/Sidebar'
import Footer from '../components/Footer'

export default {
    components: { Navbar, Sidebar, Footer },
    mounted () {
        window.$('body').Layout();
        window.$('[data-widget="pushmenu"]').PushMenu();
        window.$('[data-widget="control-sidebar"]').ControlSidebar();
        window.$('ul[data-widget="treeview]').Treeview('init');
        window.$('.dropdown').Dropdown();
        window.$('ul[data-widget="treeview"]').overlayScrollbars();
    }    
}
</script>