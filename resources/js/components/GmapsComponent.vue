<template>
  <div ref="map" style="width: 100%; height: 100%"></div>
</template>

<script>
import { importLibrary } from "@googlemaps/js-api-loader";

const markerSize = 40;

const styles = [
  { stylers: [{ hue: "#2c3e50" }, { saturation: 250 }] },
  {
    featureType: "road",
    elementType: "geometry",
    stylers: [{ lightness: 50 }, { visibility: "simplified" }],
  },
  { featureType: "road", elementType: "labels", stylers: [{ visibility: "off" }] },
  { featureType: "administrative", elementType: "geometry", stylers: [{ visibility: "off" }] },
  { featureType: "poi", stylers: [{ visibility: "off" }] },
  { featureType: "transit", stylers: [{ visibility: "off" }] },
];

function icon(url) {
  return {
    url,
    size: new google.maps.Size(markerSize, markerSize),
    scaledSize: new google.maps.Size(markerSize, markerSize),
    anchor: new google.maps.Point(markerSize / 2, markerSize),
  };
}

export default {
  props: ["kredse", "kreds"],
  emits: ["update:kreds"],
  data() {
    return {
      selectedKreds: this.kreds,
    };
  },
  async mounted() {
    const { Map } = await importLibrary("maps");
    await importLibrary("marker");

    // Kept off `data` so Vue doesn't wrap the Google Maps objects in proxies.
    this.map = new Map(this.$refs.map, {
      center: { lat: 56.244995, lng: 11.47533 },
      zoom: 12,
      mapTypeId: "terrain",
      gestureHandling: "greedy",
      styles,
      zoomControl: true,
      mapTypeControl: false,
      scaleControl: false,
      streetViewControl: false,
      rotateControl: false,
      fullscreenControl: false,
    });

    this.icons = {
      normal: icon("/images/Marker.svg"),
      selected: icon("/images/MarkerSelected.svg"),
    };

    this.markers = this.kredse.map((kreds) => {
      const marker = new google.maps.Marker({
        map: this.map,
        position: { lat: kreds.latitude, lng: kreds.longitude },
        title: kreds.navn,
        clickable: true,
      });
      marker.addListener("click", () => this.selectKreds(kreds));
      return { kreds, marker };
    });

    this.updateIcons();
    this.fitBounds();
  },
  watch: {
    kreds(val) {
      this.selectKreds(val);
    },
  },
  methods: {
    selectKreds(kreds) {
      if (kreds && this.map) {
        this.map.panTo({ lat: kreds.latitude, lng: kreds.longitude });
      }
      this.selectedKreds = kreds;
      this.updateIcons();
      this.$emit("update:kreds", kreds);
    },
    updateIcons() {
      if (!this.markers) return;
      for (const { kreds, marker } of this.markers) {
        const selected = this.selectedKreds && kreds.id === this.selectedKreds.id;
        marker.setIcon(selected ? this.icons.selected : this.icons.normal);
      }
    },
    fitBounds() {
      if (this.kredse.length === 0) return;
      const bounds = new google.maps.LatLngBounds();
      for (const kreds of this.kredse) {
        bounds.extend({ lat: kreds.latitude, lng: kreds.longitude });
      }
      this.map.fitBounds(bounds);
    },
  },
};
</script>
