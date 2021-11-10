<template>
    <div class="content-wrapper">
        <div class="d-flex flex-column">
            <div class="p-2">
                <h3>Halaman Pemesanan</h3>
            </div>
            <div class="p-2 align-self-center">
                <ul class="nav nav-tabs">
                    <li class="nav-link active">
                        <a class="btn" @click="activated">Semua</a>
                    </li>
                    <li class="nav-link" v-for="status in  statuse" :key="status.id">
                        <a class="btn" @click="activated">{{ status.name }}</a>
                    </li>
                </ul>
                <div class="table table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pelanggan</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal Buat</th>
                                <th>tanggal Ubah</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(order, index) in orders" :key="order.id">
                                <td>{{ index + 1 }}</td>
                                <td>{{ order.custname }}</td>
                                <td>{{ order.catname }}</td>
                                <td>{{ order.statsname }}</td>
                                <td>{{ order.created_at }}</td>
                                <td>{{ order.updated_at }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary" @click="showOrdersDetail(order)" data-toggle="modal" data-target="#ordersDetailModalCenter">Tampil</button>
                                        <button class="btn btn-success" @click="updateOrderStatus(order.id)">Proses</button>
                                        <button class="btn btn-danger" @click="deleteOrder(order.id)">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- this Modal -->
                <div class="modal fade" id="ordersDetailModalCenter" tabindex="-1" role="dialog" aria-labelledby="ordersDetailModalCenter" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 800px; min-heigth: 600px">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="OrdersDetailModalLongTitle">{{ ordered.id }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row justify-content-center">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-6 col-sm-6">
                                                    <p>nama pemesan: {{ ordered.custname }}</p>
                                                    <p>alamat: {{ ordered.custaddr }}</p>
                                                    <p>telepon: {{ ordered.custphone }}</p>
                                                </div>
                                                <div class="col-6 col-sm-6">
                                                    <p>tanggal buat: {{ ordered.created_at }}</p>
                                                    <p>status: {{ ordered.statsname }}</p>
                                                    <p>kategori: {{ ordered.catname }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table class="table table-responsive">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>nama</th>
                                                        <th>file</th>
                                                        <th>qty</th>
                                                        <th>total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>{{ ordered.prodname }}</td>
                                                        <td>
                                                            <span class="btn btn-primary" @click="readFile(ordered.filename)">
                                                                <i :class="icon"></i>
                                                            </span>
                                                        </td>
                                                        <td v-if="ordered.qty == null"><input type="number" v-model="input.qty" size="3"></td>
                                                        <td v-else>{{ ordered.qty }}</td>                                                        
                                                        <td v-if="ordered.total == null"><input type="number" v-model="input.total"> </td>
                                                        <td v-else>{{ ordered.total }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>    
                                        </div>
                                    </div>
                                </div>                       
                            </div>
                            <div class="modal-footer" v-if="ordered.qty != null && ordered.total != null">
                                <p>form pemesanan telah diverifikasi pada tanggal {{ ordered.od_verify }}</p>
                            </div>
                            <div class="modal-footer" v-else>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button class="btn btn-primary" @click="updateOrderDetails(ordered.od_id)">Save Changes</button>
                            </div>
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
            orders: [],
            ordered: {},
            statuse: [],
            input: {},
            active: null,
        }
    },
    created () {
        let uri1 = '/api/statuses'
        this.axios.get(uri1).then((response) => {
            this.statuse = response.data
        }).catch(error => {
            console.log(error)
        })

        let uri = '/api/orders'
        this.axios.get(uri).then((response) => {
            this.orders = response.data
            console.log(response.data)
        }).catch(error => {
            console.log(error)
        })
        
    },
    computed: {
        icon () {
            if (this.ordered.file_ext === 'pdf') return 'fas fa-file-pdf'
        }
    },
    methods: {
        activated(e) {
            if (this.active) {
                this.active.classList.remove('active')
            }
            e.target.parentElement.classList.add('active')
            this.active = e.target.parentElement
        },
        showOrdersDetail(order) {
            this.ordered = order
        },
        updateOrderDetails (id) {

            let uri = '/api/order_details/update/' + id
            this.axios.put(uri, this.input).then(() => {
                location.reload()
            }).catch(error => {
                console.log(error)
            })
        },
        deleteOrder (id) {
            this.$swal.fire({
                title: 'Apakah kamu yakin ?',
                text: 'Jika kamu hapus data tidak akan kembali lagi',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#11111',
                confirmButtonText: 'Hapus deh',
                cancelButtonText: 'Gajadi aja'
            }).then((result) => {
                if (result.value) {
                    let uri = '/api/orders/delete/${id}'
                    this.axios.delete(uri).then((response) => {
                        this.orders.splice(this.orders.indexOf(id), 1)
                    })

                    this.$swal.fire({
                        title: 'Success',
                        text: 'Pesanan berhasil dihapus',
                        icon: 'success',
                        timer: 1000
                    })

                    console.log("Pesanan telah terhapus dengan id ..." + id)
                }
            })   
        },
        readFile (src) {
            window.open('/storage/upload_doc/' + src, '_blank')
        }
    }
}
</script>