<template>
    <MglMap
        :accessToken="accessToken"
        :mapStyle="mapStyle"
        :zoom="zoom"
        :center="center"
        @load="onMapLoad"
    >
        <MglMarker
            :coordinates="[kreds.longitude, kreds.latitude]"
            v-for="(kreds, index) in kredse"
            :key="kreds.id"
            :offset="[-40 * index, -20]"
            @click="selectKreds(kreds)"
        >
            <template slot="marker" v-if="selectedKreds">
                <img
                    v-if="kreds.id == selectedKreds.id"
                    src="/images/Marker.svg"
                    width="40"
                    height="40"
                    style="cursor:pointer;"
                />
                <img
                    v-else
                    src="/images/Marker.svg"
                    width="40"
                    height="40"
                    style="cursor:pointer; -webkit-filter: grayscale(100%); filter: grayscale(100%);"
                />
            </template>
            <template slot="marker" v-else>
                <img
                    src="/images/Marker.svg"
                    width="40"
                    height="40"
                    style="cursor:pointer;"
                />
            </template>
        </MglMarker>
    </MglMap>
</template>

<script>
import Mapbox from "mapbox-gl";
import { MglMap, MglMarker } from "vue-mapbox";

export default {
    components: {
        MglMap,
        MglMarker
    },
    props: ["kredse", "kreds"],
    data() {
        return {
            center: [11.47533, 56.244995],
            coordinates: [12.5030745, 55.6926708],
            zoom: 6,
            selectedKreds: this.kreds,
            accessToken:
                "pk.eyJ1IjoiZ2FhcmRlZSIsImEiOiJjajQ2dW82NjgxMm9iMnFvZmhiMnQ5M3gzIn0.wBQu4g8FTED0qcJXZJQBJw", // your access token. Needed if you using Mapbox maps
            mapStyle: "mapbox://styles/gaardee/ck4gvn1w519cp1cmubzu4ke3x" // your map style
        };
    },
    mounted: function() {
        console.log(this.kredse);
    },
    watch: {
        kreds: function(val, oldVal) {
            this.selectKreds(val);
        }
    },
    methods: {
        async onMapLoad(event) {
            // Here we cathing 'load' map event
            const asyncActions = event.component.actions;
            console.log(event);
            event.map.resize();
            const newParams = await asyncActions.fitBounds([
                [15.258936, 54.629487],
                [7.961436, 57.846724]
            ]);
        },
        selectKreds: function(kreds) {
            this.selectedKreds = kreds;
            this.$emit("update:kreds", kreds);
        }
    },
    created() {
        // We need to set mapbox-gl library here in order to use it in template
        this.mapbox = Mapbox;
    }
};
</script>
