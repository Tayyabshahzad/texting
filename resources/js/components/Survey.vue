<template>
    <div class="container">
        <div class="row justify-content-center">
            <v-row class="pa-4 text-center justify-center">
                <v-card-text class="text-white">
                    <h2>Customer Survey</h2>
                </v-card-text>

                <v-col class="col-6">
                    <v-card class="py-2">
                        <v-card-text class="text-left">
                            <div>Question 1</div>
                            <p class="text-h6 text--primary">
                                What are you most interested in hearing more
                                about?
                            </p>
                            <div class="text--primary">
                                <v-container class="px-0" fluid>
                                    <v-radio-group v-model="q1">
                                        <v-radio
                                            label="Beer Releases"
                                            value="beer_releases"
                                        ></v-radio>
                                        <v-radio
                                            label="Upcoming events"
                                            value="events"
                                        ></v-radio>
                                        <v-radio
                                            label="Specials & Discounts"
                                            value="specials"
                                        ></v-radio>
                                    </v-radio-group>
                                </v-container>
                            </div>
                        </v-card-text>
                        <v-card-actions class="text-center justify-center">
                            <v-btn
                                color="primary"
                                :disabled="!q1"
                                @click="saveSurvey()"
                                >Submit</v-btn
                            >
                        </v-card-actions>
                        <v-card-text v-if="!q1" class="text-center red--text">
                            Please complete the survey to continue.
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </div>

        <!-- Overlay -->
        <v-overlay :value="overlay">
            <div class="text-center">
                <v-icon size="50" v-if="this.overlayData.icon">{{
                    this.overlayData.icon
                }}</v-icon>
                <div v-if="this.overlayData.message" class="text-h6 py-2">
                    {{ this.overlayData.message }}
                </div>
            </div>
            <v-progress-circular
                indeterminate
                size="64"
                v-if="this.overlayData.loading"
            ></v-progress-circular>
        </v-overlay>
    </div>
</template>

<script>
import moment from "moment";

export default {
    props: [],
    data() {
        return {
            overlay: false,
            overlayData: {
                icon: "",
                message: "",
            },
            q1: "",
        };
    },
    filters: {},
    mounted() {},
    methods: {
        saveSurvey() {
            this.overlay = true;
            this.overlayData.loading = true;

            this.newCouponDialog = false;

            axios
                .post("/save-survey", {
                    q1: this.q1,
                })
                .then((response) => {
                    this.birthdayCouponDialog = false;
                    this.newSubberCouponDialog = false;

                    if (response.data.message == "Success") {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Update Successful!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
                            window.location.href = "/home";
                        }, 2000);
                    } else {
                        this.overlayData.icon = "mdi-alert-circle";
                        this.overlayData.message =
                            "Update Failed, please try again.";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
                        }, 2000);
                    }
                })
                .catch((error) => {
                    this.overlayData.icon = "mdi-alert-circle";
                    this.overlayData.message =
                        "Update Failed, please try again.";
                    this.overlayData.loading = false;
                    this.newCouponDialog = false;
                });
        },
    },
};
</script>
