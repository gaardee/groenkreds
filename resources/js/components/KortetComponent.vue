<template>
  <div id="kortet" v-bind:class="{ showBox: kreds != null }">
    <div id="map-parent">
      <gmaps-component id="map" :kredse="kredse" v-model:kreds="kreds"></gmaps-component>
    </div>
    <div id="box" v-bind:class="{ show: kreds != null }">
      <template v-if="kreds">
        <div class="title mt-4">
          <h1>FDF {{ kreds.navn }}</h1>
          <div class="close" role="button" aria-label="Luk" @click="kreds = null">
            <i class="fas fa-times"></i>
          </div>
        </div>
        <div class="motivation">
          <h4>Kredsens motivation</h4>
          <div v-if="kreds.motivation">{{ kreds.motivation }}</div>
          <div v-else>
            <i>Kredsen har ikke skrevet nogen motivation</i>
          </div>
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
:style="`background-image: url(/storage/photos/${billede});`"
            ></div>
          </div>
        </div>
        <div class="aktiviteter mt-4">
          <h4>Aktiviteter kredsen har udført</h4>
          <div id="aktiviteter-select" class="d-flex" v-if="kreds.aktiviteter.length > 0">
            <a
              :href="`/aktiviteter/${aktivitet.slug}`"
:class="`btn btn-round d-flex type-${aktivitet.type} aktivitet active`"
              v-for="aktivitet in kreds.aktiviteter"
              :key="aktivitet.id"
              target="_blank"
            >
              <div class="icon-badge rounded-circle">
                <i :class="aktivitet.ikon"></i>
              </div>
              <div class="titel">{{ aktivitet.title }}</div>
            </a>
          </div>
          <div v-else>
            <i>Kredsen har ikke valgt nogen aktiviteter</i>
          </div>
        </div>
      </template>
    </div>

    <vue-easy-lightbox
      escDisabled
      moveDisabled
      :visible="visible"
:imgs="kreds && kreds.billeder ? Object.values(kreds.billeder).map((b) => '/storage/photos/' + b) : []"
      :index="index"
      @hide="handleHide"
    ></vue-easy-lightbox>
  </div>
</template>

<script>
import VueEasyLightbox from "vue-easy-lightbox";
import GmapsComponent from "./GmapsComponent.vue";

export default {
  components: {
    GmapsComponent,
    VueEasyLightbox,
  },
  props: ["kredse", "kredsprop"],
  data() {
    return {
      kreds: this.kredsprop,
      visible: false,
      index: 0,
    };
  },
  watch: {
    kreds(val) {
      if (val) {
        window.history.replaceState(
          "kreds",
          "Kortet - Kreds " + val.id,
          "/kortet/" + val.id
        );
      } else {
        window.history.replaceState("kortet", "Kortet", "/kortet");
      }
    },
  },
  methods: {
    showImg(index) {
      this.index = index;
      this.visible = true;
    },
    handleHide() {
      this.visible = false;
    },
  },
};
</script>
