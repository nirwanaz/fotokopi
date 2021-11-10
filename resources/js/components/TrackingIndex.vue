<template>
    <div class="content-wrapper bg-content">
        <div class="d-flex flex-column main-home">
            <div class="p-2">
                <h3>Halaman Riwayat Pemesanan</h3>
            </div>
            <div class="p-2 align-self-center">
                <form @submit.prevent="trackingId">
                    <nav class="navbar">
                        <div class="input-group mb-3">
                            <input type="search" class="form-control" v-model="tracking.id" placeholder="Masukkan kode pesanan" aria-label="Search" />
                            <div class="input-group-append">
                                <button class="btn btn-outline-success my-2 my-sm-0">Cari</button>
                            </div>
                        </div>
                    </nav>
                </form>
                <div v-if="orders" class="table table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode pesanan</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Kategori</th>
                                <th>Total Biaya</th>
                                <th>Status</th>
                                <th>Tanggal Buat</th>
                                <th>tanggal Ubah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order, index) in orders" :key="order.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ order.trackid }}</td>
                                <td>{{ order.custname }}</td>
                                <td>{{ order.custaddress }}</td>
                                <td>{{ order.catgname }}</td>
                                <td>{{ order.odtotal }}</td>
                                <td>{{ order.statsname }}</td>
                                <td>{{ order.created_at }}</td>
                                <td>{{ order.updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data () {
        return {
            orders: null,
            tracking: {}
        }
    },
    methods: {
        trackingId (e) {
            e.preventDefault()

            let uri = '/api/tracking/' + this.tracking.id
            this.axios.get(uri).then(response => {
                this.orders = response.data
                console.log(this.orders)
            }).catch(error => {
                console.log(error)
            })
        }
    }
}
</script>