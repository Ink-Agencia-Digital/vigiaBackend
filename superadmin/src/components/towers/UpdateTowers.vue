<template>
  <div>
    <Panel title="Actualizar torre">
      <b-container>
        <legend>Información de la torre</legend>
        <b-row class="m-t-10 m-b-10">
          <b-col md="10" offset-md="1">
            <b-form-group
              class="row"
              label="Nombre"
              label-cols-md="3"
              label-for="update-name"
            >
              <b-form-input
                id="update-name"
                v-model="tower.name"
                placeholder="Torre 13"
              ></b-form-input>
            </b-form-group>
            <div class="pull-right">
              <b-button variant="outline-primary" @click="resetUpdate"
                >Cancelar</b-button
              >
              <b-button variant="warning" class="m-l-10" @click="updateTower"
                >Modificar</b-button
              >
            </div>
          </b-col>
        </b-row>
      </b-container>
    </Panel>
  </div>
</template>

<script>
export default {
  props: {
    initialTower: {
      icon: Object,
      default: null,
    },
  },
  data() {
    return {
      tower: { ...this.initialTower },
    };
  },
  methods: {
    updateTower() {
      let loader = this.$loading.show();
      this.$http({
        method: "PUT",
        url: "/api/towers/" + this.tower.id,
        data: this.tower,
      })
        .then(() => {
          loader.hide();
          this.$swal({
            icon: "success",
            title: "Hecho!",
          }).then(() => {
            this.$emit("updateSuccess");
          });
        })
        .catch(() => {
          loader.hide();
          this.$swal({
            icon: "error",
            title: "Error!",
          });
        });
    },
    resetUpdate() {
      this.$emit("resetUpdate");
    },
  },
};
</script>

<style></style>
