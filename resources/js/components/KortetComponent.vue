<template>
    <div class="" id="kortet">
        <div id="map-parent">
            <mapbox-component
                id="map"
                :kredse="kredse"
                :kreds.sync="kreds"
            ></mapbox-component>
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
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                        Integer commodo ultricies lacus sit amet tincidunt.
                        Nulla facilisi. Fusce tempor turpis ac iaculis
                        ultricies. Phasellus ultrices, purus nec tincidunt
                        volutpat, lacus felis aliquet sapien, vel blandit ipsum
                        nibh a arcu. Cras rutrum odio metus, sit amet viverra
                        ante varius vitae. Suspendisse eget sagittis erat.
                        Mauris congue porttitor venenatis. In laoreet, orci ac
                        commodo mattis, ligula velit consectetur augue,
                        tristique scelerisque erat risus a arcu. Proin aliquam
                        nunc sed velit porta ullamcorper. Praesent congue nisi
                        at tellus tristique venenatis.
                    </p>
                </div>
                <div class="billeder">
                    <div class="img-wrapper img-thumbnail">
                        <div
                            class="img"
                            style="background-image: url('/storage/billeder/78343090_132363218204658_6574630727197917184_o.png');"
                        ></div>
                    </div>
                    <div class="img-wrapper img-thumbnail">
                        <div
                            class="img"
                            style="background-image: url('/storage/billeder/78343090_132363218204658_6574630727197917184_o.png');"
                        ></div>
                    </div>
                    <div class="img-wrapper img-thumbnail">
                        <div
                            class="img"
                            style="background-image: url('/storage/billeder/78343090_132363218204658_6574630727197917184_o.png');"
                        ></div>
                    </div>
                    <div class="img-wrapper img-thumbnail">
                        <div
                            class="img"
                            style="background-image: url('/storage/billeder/78343090_132363218204658_6574630727197917184_o.png');"
                        ></div>
                    </div>
                </div>
                <div class="aktiviteter mt-4">
                    <h4>Aktiviteter kredsen har udført</h4>
                    <div></div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    props: ["kredse", "kredsprop"],
    data() {
        return {
            kreds: this.kredsprop
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
