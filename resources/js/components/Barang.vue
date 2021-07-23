<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Barang</h3>
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
                                <table class="table" v-if="products.length > 0">
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Aksi</th>
                                    </tr>
                                    <tr
                                        v-for="product in products"
                                        :key="product.id"
                                    >
                                        <td>{{ product.name }}</td>
                                        <td>{{ product.type }}</td>
                                        <td>{{ product.description }}</td>
                                        <td>{{ product.price | currency }}</td>
                                        <td>{{ product.quantity }}</td>
                                        <td>
                                            <router-link
                                                :to="{
                                                    name: '',
                                                    params: { id: product.id }
                                                }"
                                                class="btn btn-sm btn-info"
                                            >
                                                <i class="fas fa-images"></i>
                                                View
                                            </router-link>

                                            <button
                                                data-toggle="modal"
                                                data-target="#modal"
                                                @click="showModalEdit(product)"
                                                type="button"
                                                class="btn btn-sm btn-warning"
                                            >
                                                <i class="fas fa-edit"></i> Edit
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-danger"
                                                @click="
                                                    deleteProducts(
                                                        product.id,
                                                        product.name
                                                    )
                                                "
                                            >
                                                <i class="fas fa-trash-alt"></i>
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                </table>

                                <table v-else class="table">
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
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
                            isModalEdit ? updateProducts() : createProducts()
                        "
                    >
                        <div class="modal-body">
                            <div class="form-group">
                                <input
                                    id="name"
                                    name="name"
                                    type="text"
                                    class="form-control"
                                    placeholder="Name"
                                    v-model="form.name"
                                    :class="{ 'is-invalid': form.errors.name }"
                                />
                                <HasError :form="form" field="name" />
                            </div>
                            <div class="form-group">
                                <input
                                    id="type"
                                    name="type"
                                    type="text"
                                    class="form-control"
                                    placeholder="Type"
                                    v-model="form.type"
                                    :class="{ 'is-invalid': form.errors.type }"
                                />
                                <HasError :form="form" field="type" />
                            </div>
                            <div class="form-group">
                                <textarea
                                    id="description"
                                    name="description"
                                    type="text"
                                    class="form-control"
                                    placeholder="Description"
                                    v-model="form.description"
                                    :class="{
                                        'is-invalid': form.errors.description
                                    }"
                                ></textarea>
                                <HasError :form="form" field="description" />
                            </div>
                            <div class="form-group">
                                <input
                                    id="price"
                                    name="price"
                                    type="number"
                                    class="form-control"
                                    placeholder="Price"
                                    min="0"
                                    v-model="form.price"
                                    :class="{ 'is-invalid': form.errors.price }"
                                />
                                <HasError :form="form" field="price" />
                            </div>
                            <div class="form-group">
                                <input
                                    id="quantity"
                                    name="quantity"
                                    type="number"
                                    class="form-control"
                                    placeholder="Quantity"
                                    min="1"
                                    v-model="form.quantity"
                                    :class="{
                                        'is-invalid': form.errors.quantity
                                    }"
                                />
                                <HasError :form="form" field="quantity" />
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
    name: "Barang",
    data() {
        return {
            products: [],
            form: new Form({
                id: "",
                name: "",
                type: "",
                description: "",
                price: "",
                quantity: ""
            }),
            loading: false,
            disabled: false,
            isModalEdit: false
        };
    },
    methods: {
        readProducts(data) {
            this.products = data;
        },
        createProducts() {
            this.$Progress.start();
            this.loading = true;
            this.disabled = true;

            let formData = {
                name: this.form.name,
                type: this.form.type,
                description: this.form.description,
                price: this.form.price,
                quantity: this.form.quantity
            };

            this.form
                .post("http://crud-laravel-vue.test/api/products", formData)
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
        updateProducts() {
            this.$Progress.start();
            this.loading = true;
            this.disabled = true;

            let formData = {
                name: this.form.name,
                type: this.form.type,
                description: this.form.description,
                price: this.form.price,
                quantity: this.form.quantity
            };

            this.form
                .put(
                    "http://crud-laravel-vue.test/api/products/" + this.form.id,
                    formData
                )
                .then(() => {
                    newVue.$emit("refreshPage");
                    $("#modal").modal("hide");
                    Toast.fire({
                        icon: "success",
                        title: "Data has been updated."
                    });
                    this.$Progress.finish();
                    this.loading = false;
                    this.disabled = false;
                })
                .catch(() => {
                    Toast.fire({
                        icon: "error",
                        title: "Uupss, something wrong."
                    });
                    this.$Progress.fail();
                    this.loading = false;
                    this.disabled = false;
                });
        },
        deleteProducts(id, name) {
            const popUp = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-danger ml-2",
                    cancelButton: "btn btn-secondary"
                },
                buttonsStyling: false
            });

            popUp
                .fire({
                    title: "Delete " + name,
                    text: "Are you sure delete this data?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes, do it!",
                    cancelButtonText: "No, do not!",
                    reverseButtons: true
                })
                .then(result => {
                    if (result.isConfirmed) {
                        this.$Progress.start();

                        axios
                            .delete(
                                "http://crud-laravel-vue.test/api/products/" +
                                    id
                            )
                            .then(() => {
                                Toast.fire({
                                    icon: "success",
                                    title: name + " has been deleted."
                                });
                                this.$Progress.finish();
                                newVue.$emit("refreshPage");
                            })
                            .catch(() => {
                                Toast.fire({
                                    icon: "error",
                                    title: "Uupss, something wrong."
                                });
                                this.$Progress.fail();
                            });
                    } else {
                        Toast.fire({
                            icon: "success",
                            title: name + " will not be deleted."
                        });
                    }
                });
        },
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
            .get("http://crud-laravel-vue.test/api/products")
            .then(result => this.readProducts(result.data.data))
            .catch(err => console.log(err));

        newVue.$on("refreshPage", () => {
            axios
                .get("http://crud-laravel-vue.test/api/products")
                .then(result => this.readProducts(result.data.data))
                .catch(err => console.log(err));
        });
        this.$Progress.finish();
    }
};
</script>
