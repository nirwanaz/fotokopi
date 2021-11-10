<template>
    <div class="content-wrapper bg-content">
        <div class="d-flex justify-content-center">
            <div class="p-4 flex-column">
                <div class="p-2 align-self-center">
                    <div class="heading">
                        <h2 style="color: #449cc5; font-family: initial"><b>Selamat Datang di Aplikasi Pemesanan Prastya Copier</b></h2>
                    </div>
                    <div class="about-us">
                        <img :src="logo" width="200" height="200" style="margin-bottom: 40px">
                        <p>Prastya Copier adalah perusahaan di bidang jasa percetakan dengan pemesanan
                            berbasis online order &amp; One day service. Kami juga melayani jasa desain grafis
                            sesuai dengan permintaan konsumen.
                        </p>
                        <div v-if="vision">
                            <h4>{{ vision.title }}</h4>
                            <p>{{ vision.content }}</p>
                        </div>
                        <div v-if="missions">
                            <h4>{{ missions.title }}</h4>
                            <ul>
                                <li v-for="mission in missions.content" :key="mission">{{ mission }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 flex-column">
                <div class="p-2 contact-us">
                    <div class="heading">
                        <h4 style="border-bottom: 2px solid">Kontak Kami</h4>
                    </div>
                    <h5><span><i class="fas fa-building"></i>Cabang I: Gg. Anggrek II No. 26 Wedoro-Sidoarjo</span></h5>
                    <h5><i class="fas fa-building"></i>Cabang II: Jl. Panglima Sudirman 167A Gresik</h5>
                    <h5><i class="fas fa-phone"></i>+62 812 4986 0684</h5>
                    <h5><i class="fas fa-envelope"></i>prastyacopier@gmail.com</h5>
                    <h5><i class="fas fa-instagram"></i>prastyacopier</h5>
                </div>
                <div class="p-2 flex-column">
                    <div class="p-2">
                        <img :src="icon" height="250" width="200">
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
            logo: '/images/logo.png',
            icon: '/images/icon-2.png',
            vision: {
                title: 'Visi',
                content: 'Menjadi bisnis jasa percetakan yang bisa meningkatkan efektivitas waktu di seluruh kota besar di Indonesia'
            },
            missions: {
                title: 'Misi',
                content: [
                        'Menciptakan pemesanan percetakan online yang berbasis pengiriman',
                        'Mengusahakan segmentasi tepat sasaran kepada mahasiswa dengan penentuan harga yang lebih terjangkau',
                        'Menyediakan pelayanan yang ramah dan tepat waktu'
                ]
            }
        }
    }
}
</script>