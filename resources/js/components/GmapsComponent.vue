<template>
  <GmapMap
    ref="mapRef"
    :center="center"
    :zoom="zoom"
    map-type-id="terrain"
    style="width: 100%; height: 100%"
    :options="{
        gestureHandling: 'greedy',
        styles: styles,
   zoomControl: true,
   mapTypeControl: false,
   scaleControl: false,
   streetViewControl: false,
   rotateControl: false,
   fullscreenControl: false,
   disableDefaultUI: false
 }"
  >
    <GmapMarker
      :key="index"
      v-for="(kreds, index) in kredse"
      :position="{lat:kreds.latitude, lng:kreds.longitude}"
      :clickable="true"
      @click="selectKreds(kreds)"
      :icon="selectedKreds ? kreds.id == selectedKreds.id ? markerSelectedOptions : markerOptions : markerOptions"
    />
  </GmapMap>
</template>

<script>
import { gmapApi } from "vue2-google-maps";
const markerSize = 40;

export default {
  props: ["kredse", "kreds"],
  data() {
    return {
      center: { lat: 56.244995, lng: 11.47533 },
      coordinates: [12.5030745, 55.6926708],
      zoom: 12,
      selectedKreds: this.kreds,
      map: null,
      markerOptions: {
        url: "/images/Marker.svg",
        size: {
          width: markerSize * 2,
          height: markerSize * 2,
          f: "px",
          b: "px",
        },
        scaledSize: { width: markerSize, height: markerSize, f: "px", b: "px" },
        anchor: { x: markerSize / 2, y: markerSize },
        // origin: { x: 0, y: 0 },
      },
      markerSelectedOptions: {
        url: "/images/MarkerSelected.svg",
        size: {
          width: markerSize * 2,
          height: markerSize * 2,
          f: "px",
          b: "px",
        },
        scaledSize: { width: markerSize, height: markerSize, f: "px", b: "px" },
        anchor: { x: markerSize / 2, y: markerSize },
        // origin: { x: 0, y: 0 },
      },
      styles: [
        {
          stylers: [
            {
              hue: "#2c3e50",
            },
            {
              saturation: 250,
            },
          ],
        },
        {
          featureType: "road",
          elementType: "geometry",
          stylers: [
            {
              lightness: 50,
            },
            {
              visibility: "simplified",
            },
          ],
        },
        {
          featureType: "road",
          elementType: "labels",
          stylers: [
            {
              visibility: "off",
            },
          ],
        },
        {
          featureType: "administrative",
          elementType: "geometry",
          stylers: [{ visibility: "off" }],
        },
        {
          featureType: "poi",
          stylers: [{ visibility: "off" }],
        },
        {
          featureType: "transit",
          stylers: [{ visibility: "off" }],
        },
      ],
    };
  },
  computed: {
    google: gmapApi,
  },
  mounted: function () {
    this.$refs.mapRef.$mapPromise.then((map) => {
      this.map = map;
      this.generateBounds(map);
    });
  },
  watch: {
    kreds: function (val, oldVal) {
      this.selectKreds(val);
    },
  },
  methods: {
    selectKreds: function (kreds) {
      if (kreds)
        this.$refs.mapRef.panTo({ lat: kreds.latitude, lng: kreds.longitude });
      this.selectedKreds = kreds;
      this.$emit("update:kreds", kreds);
    },
    generateBounds(map) {
      const bounds = new google.maps.LatLngBounds();
      for (let kreds of this.kredse) {
        bounds.extend({ lat: kreds.latitude, lng: kreds.longitude });
      }
      map.fitBounds(bounds);
    },
  },
};
</script>
