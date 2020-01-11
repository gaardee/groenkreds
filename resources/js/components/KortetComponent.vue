<template>
  <div class id="kortet">
    <div id="map-parent">
      <mapbox-component id="map" :kredse="kredse" :kreds.sync="kreds"></mapbox-component>
    </div>
    <div id="box" v-bind:class="{ show: kreds != null }">
      <template v-if="kreds">
        <div class="title mt-4">
          <h1>FDF {{ kreds.navn }}</h1>
          <div class="close" @click="kreds = null">
            <i class="fas fa-times"></i>
          </div>
        </div>
        <div class="motivation">
          <h4>Kredsens motivation</h4>
          <div>{{ kreds.motivation }}</div>
        </div>
        <div class="billeder">
          <div
            class="img-wrapper img-thumbnail"
            v-for="(billede, index) in kreds.billeder"
            :key="billede"
            @click="showImg(index)"
          >
            <div
              class="img"
              :style="
                                'background-image: url(/storage/photos/' +
                                    billede +
                                    ');'
                            "
            ></div>
          </div>
        </div>
        <!-- <div class="aktiviteter mt-4">
          <h4>Aktiviteter kredsen har udført</h4>
          <div></div>
        </div>-->
      </template>
    </div>

    <vue-easy-lightbox
      escDisabled
      moveDisabled
      :visible="visible"
      :imgs="
                kreds ? Object.values(kreds.billeder).map(b => '/storage/photos/' + b) : []
            "
      :index="index"
      @hide="handleHide"
    ></vue-easy-lightbox>
  </div>
</template>

<script>
import VueEasyLightbox from "vue-easy-lightbox";

export default {
  components: {
    VueEasyLightbox
  },
  props: ["kredse", "kredsprop"],
  data() {
    return {
      kreds: this.kredsprop,
      visible: false,
      index: 0 // default: 0
    };
  },
  mounted: function() {
    console.log(this.kreds);
  },
  watch: {
    kreds: function(val, oldVal) {
      if (val) {
        window.history.replaceState(
          "kreds",
          "Kortet - Kreds " + this.kreds.id,
          "/kortet/" + this.kreds.id
        );
      } else {
        window.history.replaceState("kortet", "Kortet", "/kortet");
      }
    }
  },
  methods: {
    showImg(index) {
      this.index = index;
      this.visible = true;
    },
    handleHide() {
      this.visible = false;
    },
    async onMapLoad(event) {
      // Here we cathing 'load' map event
      const asyncActions = event.component.actions;
      console.log(event);
      event.map.resize();

      const newParams = await asyncActions.fitBounds([
        [15.258936, 54.629487],
        [7.961436, 57.846724]
      ]);

      console.log(newParams);
      /* => {
              center: [30, 30],
              zoom: 9,
              bearing: 9,
              pitch: 7
            }
      */
    }
    // closeBox: function () {
    //   this.kreds = null;
    //   window.history.replaceState('kortet', 'Kortet', '/kortet');
    // },
    // kredsSelected: function (kreds) {
    //   this.kreds = kreds;
    //   window.history.replaceState('kreds', 'Kortet - Kreds ' + kreds.id, '/kortet/' + kreds.id);
    // }
  }
};
</script>
