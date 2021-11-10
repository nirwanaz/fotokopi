<template>
    <div class="content-wrapper bg-content">
        <div class="d-flex flex-column main-home">
            <div class="p-2 heading">
                <h3>Form pemesanan</h3>
            </div>
            <div class="p-4">
                <div class="alert alert-danger" v-if="errors.length">
                    <b>isikan data dengan benar</b>
                    <ul>
                        <li v-for="error in errors" :key="error">{{ error }}</li>
                    </ul>
                </div>
                <div class="form-group">
                    <label htmlFor="CategoriesName">Kategori</label>
                    <select v-model="order.categories_id" class="form-control" id="CategoriesName" @change="changeFormOrder">
                        <option v-for="option in categories" :key="option.id" v-bind:value="option.id">
                            {{ option.name }}
                        </option>
                    </select>
                </div>
            </div>
            <div class="p-4" v-if="formOrder">
                <form @submit.prevent="createOrder">                    
                    <!-- Identitas Penerima -->
                    <div class="form-group">
                        <label htmlFor="CustomerName">Nama Pemesan</label>
                        <input type="text" class="form-control" id="CustomerName" v-model="order.customer_name">
                    </div>
                    <div class="form-group">
                        <label htmlFor="CustomerAddress">Alamat Penerima</label>
                        <input type="text" class="form-control" id="CustomerAddress" v-model="order.customer_address">
                    </div>
                    <div class="form-group">
                        <label htmlFor="CustomerPhone">Nomor Telepon</label>
                        <input type="text" class="form-control" id="CustomerPhone" v-model="order.customer_phone">
                    </div>
                    <!-- ========================= -->
                    <div class="form-group">
                        <div v-if="!document">
                            <label htmlFor="ProductUpload">Dokumen</label>
                            <input type="file" class="form-control" accept="image/*|.doc|.docx|.pdf" id="ProductUpload" @change="onChangeFile">
                        </div>
                        <div v-else>
                            <!-- Preview Document >
                            <embed :src="document" :type="typeDoc" width="100%" height="600px"/>
                            <-- ------ -->
                            <div class="row">
                                <div class="col-md-4 col-sm-4">
                                    <div class="card">
                                        <span class="text-center" style="font-size: 5em"><i :class="this.order.iconDoc"></i></span>
                                        <div class="card-body">
                                            <p>{{ this.document.name }}</p>
                                            <p id="total"></p>
                                            <button class="btn btn-primary" @click="removeDocument">Hapus dokumen</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center">
                        <router-link :to="{ name:'indexHome'}" class="btn btn-secondary" >Balik</router-link>
                        &nbsp; &nbsp;
                        <button class="btn btn-primary">Order</button>
                    </div>
                </form>
            </div>        
        </div>  
    </div>
</template>
<script>
export default {
    data () {
        return {
            errors: [],
            order: {},
            document: null,
            categories: [],
            formOrder: null
        }
    },
    created () {
        let uri = '/api/categories'
        this.axios.get(uri).then((response) => {
            this.categories = response.data
        })
    },
    methods: {
        createOrder (e) {
            
            let uri = '/api/orders/store'
            let formdata = new FormData()
            
            formdata.append('categories_id', this.order.categories_id)
            formdata.append('customer_name', this.order.customer_name)
            formdata.append('customer_phone', this.order.customer_phone)
            formdata.append('customer_address', this.order.customer_address)
            formdata.append('customer_document', this.document)

            this.axios.post(uri, formdata, { headers: { 'Content-Type': 'multipart/form-data'} }).then((response) => {
                this.$swal.fire({
                    title: 'success',
                    text: 'Pesanan sedang diproses',
                    icon: 'success',
                    timer: 1000
                })
                console.log(response.data)
               // this.$router.push({ name: 'indexHome'})
            }).catch(error => {
                console.log(error.response)
            })

            this.errors = []
            if (!this.order.categories_id){
                this.errors.push('Kategori wajib diisi')
            }
            if (!this.order.customer_name){
                this.errors.push('Nama wajib diiisi')
            }
            if (!this.order.customer_phone){
                this.errors.push('Nomor telepon wajib diisi')
            }
            if (!this.order.customer_address){
                this.errors.push('Alamat penerima wajib diisi')
            }
            
            e.preventDefault()
        },
        changeFormOrder (e) {
            this.formOrder = true
            /*
            let uri = '/api/categories_sub/findbycategoriesid/' + this.order.categories_id
            this.axios.get(uri).then((response) => {
                this.categories_sub = response.data
            })
            console.log(this.categories_sub)
            */
        },
        onChangeFile (e) {
            const file = e.target.files || e.dataTransfer.files
            if (!file.length){
                return
            }
            this.document = file[0]
            
            //this.createDocument(file[0])
            
            if (this.document.type.match('pdf')){
                this.order.iconDoc = 'fas fa-file-pdf'
                //this.getPageDocument(this.document)
            } else if (this.document.type.match('image')){
                this.order.iconDoc = 'fas fa-file-image'
            } else {
                this.order.iconDoc = 'fas fa-file-word'
            }
            
        },
        createDocument (file) {
            const reader = new FileReader()
            const vm = this

            reader.onload = (e) => {
                vm.document = e.target.result
            }
            
            reader.readAsDataURL(file)
        },
        getPageDocument (file) {
            const reader = new FileReader()
            const vm = this
            
            reader.readAsBinaryString(file)
            reader.onloadend = (e) => {
                vm.order.pageDoc = e.target.result.match(/\/Type[\s]*\/Page[^s]/g).length
                let price = vm.order.pageDoc * 500
                $('#total').html(price)
            }

        },
        removeDocument: function (e) {
            this.document = null
        }
    }
}
</script>