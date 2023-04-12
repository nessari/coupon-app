<template>
    <div>
        <h1 class="text-gray-700 font-semibold text-3xl">Find the nearest offers</h1>
        <GMapMap
            ref="mapRef"
            :center="userCoordinates"
            :zoom="zoom"
            style="width: 100%; height: 360px; margin: 32px auto"
            @dragend="handleDrag"
            @click="handleMapClick"
        >
            <GMapMarker
                v-for="(p, index) in partners"
                :key="index"
                :options="{
                    position: getPosition(p),
                    clickable: true,
                    draggable: false,
                }"
                @click="handleMarkerClicked(p, index)"
            >
                <GMapInfoWindow
                    :position="infoWindowPosition"
                    :closeclick="true"
                    @closeclick="handleCloseClick"
                    :opened="openedMarkerID === index"
                >
                    <div>
                        <h2 v-text="p.name" class="font-semibold"></h2>
                        <h5 v-text="'Hours: ' + p.hours"></h5>
                        <p v-text="p.address" class="font-italic"></p>
                        <p v-text="p.city" class="font-italic"></p>
                    </div>
                </GMapInfoWindow>
            </GMapMarker>
        </GMapMap>
    </div>
</template>

<script>
import { ref, mounted } from "vue";

export default {
    props: {
        partners: Array,
    },
    data() {
        return {
            map: null,
            userCoordinates: {
                lat: 0,
                lng: 0,
            },
            zoom: 14,
            activeMarker: {},
            openedMarkerID: null,
            infoWindowOptions: {
                pixelOffset: {
                    width: 0,
                    height: -35,
                },
            },
        };
    },
    created() {
        if (localStorage.center) {
            this.userCoordinates = JSON.parse(localStorage.center);
        } else {
            this.$getLocation({})
                .then((coordinates) => {
                    this.userCoordinates = coordinates;
                    this.$emit('gotUserCoords', this.userCoordinates);
                })
                .catch((error) => {
                    // alert(error);
                    this.userCoordinates.lat = 47.499062;
                    this.userCoordinates.lng = 19.044032;
                    this.$emit('gotUserCoords', this.userCoordinates);
                });
        }
        if (localStorage.zoom) {
            this.zoom = parseInt(localStorage.zoom);
        }
    },
    mounted() {
        console.log(this.$refs.mapRef);
        this.$refs.mapRef.$mapPromise.then((map) => (this.map = map));
    },
    methods: {
        getPosition(p) {
            return {
                lat: parseFloat(p.latitude),
                lng: parseFloat(p.longitude),
            };
        },
        handleDrag() {
            let center = {
                lat: this.map.getCenter().lat(),
                lng: this.map.getCenter().lng(),
            };
            let zoom = this.map.getZoom();
            localStorage.center = JSON.stringify(center);
            localStorage.zoom = zoom;
        },
        handleMarkerClicked(p, index) {
            console.log(p);
            this.activeMarker = p;
            this.openedMarkerID = index;
        },
        handleCloseClick() {
            console.log("info window closed");
            this.activeMarker = {};
            this.openedMarkerID = null;
        },
        handleMapClick(e) {
            this.handleCloseClick();
        },
    },
    computed: {
        mapCoordinates() {
            if (!this.map) {
                return {
                    lat: 0,
                    lng: 0,
                };
            }
            return {
                lat: this.map.getCenter().lat().toFixed(4),
                lng: this.map.getCenter().lng().toFixed(4),
            };
        },
        infoWindowPosition() {
            return {
                lat: parseFloat(this.activeMarker.latitude),
                lng: parseFloat(this.activeMarker.longitude),
            };
        },
    },
};
</script>
