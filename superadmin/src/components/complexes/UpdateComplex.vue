<template>
  <div>
    <Panel title="Actualizar conjunto">
      <b-container>
        <legend>Información del conjunto</legend>
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
                v-model="complex.name"
                placeholder="Conjunto/Edificio"
              ></b-form-input>
            </b-form-group>
            <b-form-group
              class="row"
              label="Dirección"
              label-cols-md="3"
              label-for="update-address"
            >
              <div class="input-group m-b-3">
                <gmap-autocomplete
                  class="form-control"
                  :value="complex.address"
                  :options="autocompleteOptions"
                  @place_changed="setPlace"
                  @input="complex.address = $event.target.value"
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
                refs="mapa-update"
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
              <b-button variant="outline-primary" @click="resetUpdate"
                >Cancelar</b-button
              >
              <b-button variant="warning" class="m-l-10" @click="updateComplex"
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
    initialComplex: Object,
  },
  data() {
    return {
      complex: { ...this.initialComplex },
      mapZoom: 15,
      currentPlace: null,
      center: {
        lat: parseFloat(this.initialComplex.lat),
        lng: parseFloat(this.initialComplex.lng),
      },
      fence: [this.initialComplex.geofence],
      autocompleteOptions: {
        componentRestrictions: { country: "co" },
        strictBounds: true,
      },
    };
  },
  methods: {
    updateComplex() {
      let loader = this.$loading.show();
      this.$http({
        method: "PUT",
        url: "/api/complexes/" + this.complex.id,
        data: this.complex,
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
    updateEdited(fence) {
      let points = [];
      for (let i = 0; i < fence.getAt(0).getLength(); i++) {
        let point = fence.getAt(0).getAt(i);
        points.push({ lat: point.lat(), lng: point.lng() });
      }
      this.complex.geofence = points;
    },
    geocodePosition(position) {
      /*global google*/
      /*eslint no-undef: "error"*/
      new google.maps.Geocoder().geocode(
        {
          latLng: position,
        },
        (res, status) => {
          if (status == "OK") {
            this.complex.address = res[0].formatted_address;
            this.complex.lat = res[0].geometry.location.lat();
            this.complex.lng = res[0].geometry.location.lng();
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
      this.currentPlace = place;
      this.complex.address = place.formatted_address;
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
        this.complex.geofence = this.fence[0];
        this.complex.lat = this.currentPlace.geometry.location.lat();
        this.complex.lng = this.currentPlace.geometry.location.lng();
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
        this.complex.geofence = this.fence[0];
        this.complex.lat = position.coords.latitude;
        this.complex.lng = position.coords.longitude;
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
      this.complex.geofence = this.fence[0];
      this.geocodePosition(place.latLng);
    },
    resetUpdate() {
      this.$emit("resetUpdate");
    },
  },
};
</script>

<style></style>
