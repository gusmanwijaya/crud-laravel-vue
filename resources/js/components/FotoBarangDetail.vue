<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Foto Barang</h3>
                        <div class="card-tools">
                            <button
                                class="btn btn-sm btn-primary"
                                type="button"
                                data-toggle="modal"
                                data-target="#modal"
                                @click="showModalCreate()"
                            >
                                <i class="fas fa-plus"></i> Add
                            </button>
                        </div>
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
                                        <th>Aksi</th>
                                    </tr>
                                    <tr
                                        v-for="fotoBarang in fotoBarangs"
                                        :key="fotoBarang.id"
                                    >
                                        <td>#</td>
                                        <td>#</td>
                                        <td>#</td>
                                        <td>
                                            <button
                                                data-toggle="modal"
                                                data-target="#modal"
                                                @click="
                                                    showModalEdit(fotoBarang)
                                                "
                                                type="button"
                                                class="btn btn-sm btn-warning"
                                            >
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-danger"
                                            >
                                                <i class="fas fa-trash-alt"></i>
                                                Delete
                                            </button>
                                        </td>
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

        <!-- Modal -->
        <div
            class="modal fade"
            id="modal"
            tabindex="-1"
            role="dialog"
            aria-labelledby="modalTitle"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">
                            {{ isModalEdit ? "Edit" : "Add" }} Data
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form
                        @submit.prevent="
                            isModalEdit
                                ? updateProductGalleries()
                                : createProductGalleries()
                        "
                        enctype="multipart/form-data"
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <select
                                    name="products_id"
                                    id="products_id"
                                    class="form-control select2"
                                    v-model="form.products_id"
                                    :class="{
                                        'is-invalid': form.errors.products_id
                                    }"
                                >
                                    <option value=""></option>
                                    <option
                                        v-for="product in products"
                                        :key="product.id"
                                        :value="product.id"
                                        >{{ product.name }}</option
                                    >
                                </select>
                                <HasError :form="form" field="products_id" />
                            </div>
                            <div class="form-group">
                                <input
                                    type="file"
                                    name="photo"
                                    id="photo"
                                    class="form-control select2"
                                    accept="image/*"
                                    @change="onImageChange()"
                                />
                            </div>
                            <div class="form-group">
                                <div class="form-check">
                                    <input
                                        type="radio"
                                        name="is_default"
                                        id="is_default"
                                        value="1"
                                        class="form-check-input"
                                        v-model="form.is_default"
                                        :class="{
                                            'is-invalid': form.errors.is_default
                                        }"
                                    />
                                    <label class="form-check-label">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input
                                        type="radio"
                                        name="is_default"
                                        id="is_default"
                                        value="0"
                                        class="form-check-input"
                                        v-model="form.is_default"
                                        :class="{
                                            'is-invalid': form.errors.is_default
                                        }"
                                    />
                                    <label class="form-check-label"
                                        >Tidak</label
                                    >
                                </div>
                                <HasError :form="form" field="is_default" />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-secondary"
                                data-dismiss="modal"
                            >
                                Close
                            </button>
                            <button
                                type="submit"
                                class="btn"
                                :disabled="disabled"
                                :class="
                                    isModalEdit ? 'btn-warning' : 'btn-primary'
                                "
                            >
                                <i
                                    v-show="loading"
                                    class="fa fa-spinner fa-spin"
                                ></i>
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "FotoBarang",
    data() {
        return {
            fotoBarangs: [],
            products: [],
            isModalEdit: false,
            loading: false,
            disabled: false,
            isModalEdit: false,
            form: new Form({
                products_id: "",
                is_default: ""
            }),
            photo: ""
        };
    },
    methods: {
        readProducts(data) {
            this.products = data;
        },
        readProductGalleries(data) {
            this.fotoBarangs = data;
        },
        onImageChange(e) {
            this.photo = e.target.files[0];
        },
        uploadImage() {
            const formData = new FormData();
            formData.set("img", this.photo);
            axios.post(
                "http://crud-laravel-vue.test/api/product_galleries",
                formData
            );
        },
        createProductGalleries() {
            this.$Progress.start();
            this.loading = true;
            this.disabled = true;

            let formData = {
                products_id: this.form.products_id,
                is_default: this.form.is_default
            };

            this.uploadImage();

            this.form
                .post(
                    "http://crud-laravel-vue.test/api/product_galleries",
                    formData
                )
                .then(() => {
                    newVue.$emit("refreshPage");
                    $("#modal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Data has been created!"
                    });
                    this.$Progress.finish();
                    this.loading = false;
                    this.disabled = false;
                })
                .catch(() => {
                    Toast.fire({
                        icon: "error",
                        title: "Uupss, something wrong!"
                    });
                    this.$Progress.fail();
                    this.loading = false;
                    this.disabled = false;
                });
        },
        updateProductGalleries() {},
        showModalCreate() {
            this.isModalEdit = false;
            this.form.reset();
            $("#modal").modal("show");
        },
        showModalEdit(data) {
            this.isModalEdit = true;
            this.form.reset();
            $("#modal").modal("show");
            this.form.fill(data);
        }
    },
    mounted() {
        this.$Progress.start();
        axios
            .get("http://crud-laravel-vue.test/api/product_galleries")
            .then(result => this.readProductGalleries(result.data.data))
            .catch(err => console.log(err));

        newVue.$on("refreshPage", () => {
            axios
                .get("http://crud-laravel-vue.test/api/product_galleries")
                .then(result => this.readProductGalleries(result.data.data))
                .catch(err => console.log(err));
        });
        this.$Progress.finish();

        axios
            .get("http://crud-laravel-vue.test/api/products")
            .then(result => this.readProducts(result.data.data))
            .catch(err => console.log(err));
    }
};
</script>
