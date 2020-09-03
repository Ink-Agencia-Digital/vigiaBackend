<template>
    <div>
        <!-- begin page-header -->
        <h1 class="page-header">
            Validacion <small>Validacion de codigos</small>
        </h1>
        <!-- end page-header -->
        <panel>
            <b-row>
                <b-form-group
                    description="Digite el codigo del invitado."
                    label="Codigo"
                    label-for="input-code"
                    label-cols-md="3"
                    class="col-md-10"
                >
                    <b-form-input
                        id="input-code"
                        v-model="code"
                        trim
                    ></b-form-input>
                </b-form-group>
                <b-col>
                    <b-button variant="primary" @click="validCode"
                        >Validar</b-button
                    ></b-col
                >
            </b-row>
            <b-card v-if="user" :title="user.name" :sub-title="user.lastname">
                <b-card-text> Visitante: {{ visitor }} </b-card-text>

                <b-card-text
                    >{{ apartment.name }} - {{ apartment.tower.name }}
                </b-card-text>
            </b-card>
        </panel>
    </div>
</template>
<script>
export default {
    data() {
        return {
            code: null,
            user: null,
            apartment: null,
            visitor: null
        };
    },
    methods: {
        validCode() {
            if (this.code) {
                let loader = this.$loading.show();
                this.$http({
                    method: "GET",
                    url: "/api/codes",
                    params: {
                        code: this.code
                    }
                })
                    .then(response => {
                        this.user = response.data.data.user;
                        this.apartment = response.data.data.apartment;
                        this.visitor = response.data.data.visitor;
                        this.$swal.fire("Valido!", "Codigo valido", "success");
                        loader.hide();
                    })
                    .catch(() => {
                        this.$swal.fire("Error", "Codigo invalido", "error");
                        loader.hide();
                    });
            } else {
                this.$swal.fire("Error", "No codigo digitado", "error");
            }
        }
    }
};
</script>
