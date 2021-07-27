<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Foto Barang</h3>
                        <div class="card-tools"></div>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <div class="table-responsive">
                                <table
                                    class="table"
                                    v-if="fotoBarangs.length > 0"
                                >
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Photo</th>
                                        <th>Default</th>
                                    </tr>
                                    <tr
                                        v-for="fotoBarang in fotoBarangs"
                                        :key="fotoBarang.id"
                                    >
                                        <td>{{ fotoBarang.products.name }}</td>
                                        <td>
                                            <img
                                                :src="
                                                    'img/products/' +
                                                        fotoBarang.photo
                                                "
                                                alt="Foto Barang"
                                                width="80px"
                                            />
                                        </td>
                                        <td>{{ fotoBarang.is_default }}</td>
                                    </tr>
                                </table>

                                <table v-else class="table">
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Photo</th>
                                        <th>Default</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            404 - Data not found
                                        </td>
                                    </tr>
                                </table>
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
    name: "FotoBarangDetail",
    data() {
        return {
            fotoBarangs: []
        };
    },
    methods: {
        readProductGalleries(data) {
            this.fotoBarangs = data;
        }
    },
    mounted() {
        this.$Progress.start();
        axios
            .get(
                "http://crud-laravel-vue.test/api/product_galleries/details/" +
                    this.$route.params.id
            )
            .then(result => this.readProductGalleries(result.data.data))
            .catch(err => console.log(err));

        newVue.$on("refreshPage", () => {
            axios
                .get(
                    "http://crud-laravel-vue.test/api/product_galleries/details/" +
                        this.$route.params.id
                )
                .then(result => this.readProductGalleries(result.data.data))
                .catch(err => console.log(err));
        });
        this.$Progress.finish();
    }
};
</script>
