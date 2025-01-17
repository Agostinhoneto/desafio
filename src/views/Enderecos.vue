<template>
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Cadastrar Endereços</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <router-link :to="{ name: 'home' }">
                            <button type="button" class="btn btn-primary">
                                <i class="fas fa-arrow-left"></i> Voltar
                            </button>
                        </router-link>
                    </div>

                    <div class="card-body">
                        <form @submit.stop.prevent="submit">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="logradouro">Logradouro*</label>
                                    <input type="text" v-model="logradouro" class="form-control" id="logradouro" placeholder="Nome" required />
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="cep">CEP*</label>
                                    <input type="text" v-model="cep" class="form-control" id="cep" placeholder="CEP" required />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-plus"></i> Adicionar Endereço
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="card-title">Lista de Endereços</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Logradouro</th>
                                    <th>CEP</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="endereco in enderecos" :key="endereco.id">
                                    <td>{{ endereco.id }}</td>
                                    <td>{{ endereco.logradouro }}</td>
                                    <td>{{ endereco.cep }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-sm" @click="remover(endereco.id)">
                                            <i class="fas fa-trash"></i> Excluir
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    name: "UsuariosCadVue",

    props: {
        enderecoId: {
            type: [String, Number],
            default: null,
        },
    },

    data() {
        return {
            users: [],
            id: "",
            logradouro: "",
            cep: "",
            enderecos: [],
        };
    },

    methods: {
        submit() {
            const payload = {
                id: this.id,
                logradouro: this.logradouro,
                cep: this.cep,
            };

            if (this.id) {
                this.update(payload);
            } else {
                this.storeTodo(payload);
            }
        },

        async storeTodo(payload) {
            await fetch("http://localhost:8000/api/storeEndereco/", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
                body: JSON.stringify(payload),
            })
                .then((response) => response.json())
                .then((res) => {
                    this.$emit("save", res.data);
                    this.resetForm();
                });

            await this.loadEndereco();
            alert("Dados Salvos com Sucesso");
        },

        async loadEndereco() {
            await fetch("http://127.0.0.1:8000/api/enderecoIndex")
                .then((response) => response.json())
                .then((res) => {
                    this.enderecos = res.data;
                });
        },

        async remover(enderecoId) {
            await fetch(`http://127.0.0.1:8000/api/enderecoDestroy/${enderecoId}`, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                },
            });

            await this.loadEndereco();
            alert("Dados excluídos com Sucesso");
        },

        resetForm() {
            this.cep = "";
            this.logradouro = "";
        },
    },

    async mounted() {
        await this.loadEndereco();
    },
};
</script>

<style>
.table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
    border-collapse: collapse;
}
.table th,
.table td {
    padding: 0.75rem;
    text-align: left;
}
.table-bordered {
    border: 1px solid #dee2e6;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0, 0, 0, 0.05);
}
</style>
