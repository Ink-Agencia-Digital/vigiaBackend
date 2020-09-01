<template>
  <div>
    <Panel title="Registrar conjunto">
      <b-container>
        <legend>Información del conjunto/edificio</legend>
        <b-row class="m-t-10 m-b-10">
          <b-col md="10" offset-md="1">
            <b-form-group
              class="row"
              label="Nombre"
              label-cols-md="3"
              label-for="register-name"
            >
              <b-form-input
                id="register-name"
                v-model="newComplex.name"
                placeholder="Conjunto/Edificio"
              ></b-form-input>
            </b-form-group>
            <b-form-group
              class="row"
              label="Dirección"
              label-cols-md="3"
              label-for="register-address"
            >
              <div class="input-group m-b-3">
                <gmap-autocomplete
                  class="form-control"
                  :value="newComplex.address"
                  :options="autocompleteOptions"
                  @place_changed="setPlace"
                  @input="newComplex.address = $event.target.value"
                ></gmap-autocomplete>
                <span class="input-group-btn">
                  <button class="btn btn-danger" @click="addMarker">
                    <i class="fas fa-search"></i>
                  </button>
                </span>
              </div>
              <gmap-map
                :center="center"
                :zoom="mapZoom"
                style="width:100%;  height: 400px;"
                refs="mapa"
              >
                <gmap-marker
                  :draggable="true"
                  :position="center"
                  @dragend="markerChanged"
                ></gmap-marker>
                <gmap-polygon
                  :paths="fence"
                  :draggable="true"
                  :editable="true"
                  @paths_changed="updateEdited($event)"
                ></gmap-polygon>
              </gmap-map>
            </b-form-group>
            <div class="pull-right">
              <b-button variant="outline-primary" @click="resetRegister"
                >Limpiar</b-button
              >
              <b-button variant="warning" class="m-l-10" @click="createComplex"
                >Crear</b-button
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
  data() {
    return {
      company: {},
      newComplex: {
        company_id: null,
        geofence: null,
      },
      center: {
        lat: 4.702208499999999,
        lng: -74.04198969999999,
      },
      mapZoom: 15,
      currentPlace: null,
      fence: [
        [
          { lat: 4.6970526999999995, lng: -74.13672910000001 },
          { lat: 4.6970526999999995, lng: -74.1347291 },
          { lat: 4.6990527, lng: -74.1347291 },
          { lat: 4.6990527, lng: -74.13672910000001 },
        ],
      ],
      autocompleteOptions: {
        componentRestrictions: { country: "co" },
        strictBounds: true,
        fields: ["formatted_address", "geometry", "address_components"],
      },
    };
  },
  mounted() {
    this.geolocate();
  },
  methods: {
    updateEdited(fence) {
      let points = [];
      for (let i = 0; i < fence.getAt(0).getLength(); i++) {
        let point = fence.getAt(0).getAt(i);
        points.push({ lat: point.lat(), lng: point.lng() });
      }
      this.newComplex.geofence = points;
    },
    geocodePosition(position) {
      // eslint-disable-next-line
      new google.maps.Geocoder().geocode(
        {
          latLng: position,
        },
        (res, status) => {
          if (status == "OK") {
            this.newComplex.address = res[0].formatted_address;
            this.newComplex.lat = res[0].geometry.location.lat();
            this.newComplex.lng = res[0].geometry.location.lng();
          } else {
            this.$swal({
              icon: "error",
              title: "Error!",
              text: "Error de Geolocalizacion",
            });
          }
        }
      );
    },
    setPlace(place) {
      console.log(place);
      this.currentPlace = place;
      this.newComplex.address = place.formatted_address;
    },
    addMarker() {
      if (this.currentPlace) {
        this.place = this.currentPlace;
        this.center = {
          lat: this.currentPlace.geometry.location.lat(),
          lng: this.currentPlace.geometry.location.lng(),
        };
        this.fence = [];
        this.fence.push([
          {
            lat: this.center.lat - 0.001,
            lng: this.center.lng - 0.001,
          },
          {
            lat: this.center.lat - 0.001,
            lng: this.center.lng + 0.001,
          },
          {
            lat: this.center.lat + 0.001,
            lng: this.center.lng + 0.001,
          },
          {
            lat: this.center.lat + 0.001,
            lng: this.center.lng - 0.001,
          },
        ]);
        this.newComplex.geofence = this.fence[0];
        this.newComplex.lat = this.currentPlace.geometry.location.lat();
        this.newComplex.lng = this.currentPlace.geometry.location.lng();
        this.mapZoom = 15;
        this.currentPlace = null;
      }
    },
    geolocate() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.center = {
          lat: position.coords.latitude,
          lng: position.coords.longitude,
        };
        this.fence = [];
        this.fence.push([
          {
            lat: this.center.lat - 0.001,
            lng: this.center.lng - 0.001,
          },
          {
            lat: this.center.lat - 0.001,
            lng: this.center.lng + 0.001,
          },
          {
            lat: this.center.lat + 0.001,
            lng: this.center.lng + 0.001,
          },
          {
            lat: this.center.lat + 0.001,
            lng: this.center.lng - 0.001,
          },
        ]);
        this.newComplex.geofence = this.fence[0];
        this.newComplex.lat = position.coords.latitude;
        this.newComplex.lng = position.coords.longitude;
      });
    },
    markerChanged(place) {
      let coords = place.latLng;
      this.center = { lat: coords.lat(), lng: coords.lng() };
      this.fence = [];
      this.fence.push([
        { lat: this.center.lat - 0.001, lng: this.center.lng - 0.001 },
        { lat: this.center.lat - 0.001, lng: this.center.lng + 0.001 },
        { lat: this.center.lat + 0.001, lng: this.center.lng + 0.001 },
        { lat: this.center.lat + 0.001, lng: this.center.lng - 0.001 },
      ]);
      this.newFence = this.fence[0];
      this.geocodePosition(place.latLng);
    },
    resetRegister() {
      this.$emit("resetRegister");
    },
    registrationSuccessful() {
      this.$emit("registrationSuccessful");
    },
    createComplex() {
      let loader = this.$loading.show();
      this.$http({
        method: "POST",
        url: "/api/complexes",
        data: this.newComplex,
      })
        .then(() => {
          loader.hide();
          this.$swal({
            icon: "success",
            title: "Hecho",
            text: "Conjunto registrado",
          }).then(() => {
            this.registrationSuccessful();
          });
        })
        .catch(() => {
          loader.hide();
          this.$swal({
            icon: "error",
            title: "Error",
          });
        });
    },
  },
};
</script>

<style></style>
