<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <div class="card-body">
                        <v-card class="my-4 mx-4">
                            <v-row justify="space-between">
                                <v-col class="ml-2">
                                    <v-btn
                                        small
                                        rounded
                                        outlined
                                        color="primary"
                                        onclick="window.location.href = '/home'"
                                    >
                                        Back
                                    </v-btn>
                                </v-col>
                                <v-col class="text-right body-1 mr-2">
                                    Exipres:
                                    {{ this.coupon.expiry | expiry_format }}
                                </v-col>
                            </v-row>
                            <v-card-text class="text-center">
                                <div class="text-h5">
                                    <b>{{ this.place.name }}</b>
                                    <br />
                                    <v-chip color="green" class="text-center">
                                        <div class="text-h6">
                                            Code: {{ this.coupon.code }}
                                        </div>
                                    </v-chip>
                                </div>

                                <div></div>
                            </v-card-text>
                            <v-card-text class="text-center">
                                <div class="body-1">
                                    {{ this.coupon.description }}
                                </div>
                            </v-card-text>

                            <v-card-text
                                v-if="this.redeemed == 1"
                                class="text-center"
                            >
                                <div class="body-1 red--text">
                                    This coupon has already been redeemed
                                </div>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn
                                    :disabled="this.disabled"
                                    block
                                    lg
                                    color="primary"
                                    @click="redeemDialog = true"
                                >
                                    REDEEM THIS COUPON
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Dialog -->
        <v-dialog v-model="redeemDialog" max-width="400">
            <v-card>
                <v-card-title class="text-h5"> Verify Coupon </v-card-title>

                <v-card-text>
                    Please ask one of the friendly staff members to verify your
                    coupon.
                </v-card-text>

                <v-card-text>
                    <v-text-field
                        v-model="redeemVerificationCode"
                        label="Staff Verification Code"
                        prepend-icon="mdi-lock-check"
                    ></v-text-field>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        color="red darken-1"
                        text
                        @click="redeemDialog = false"
                    >
                        close
                    </v-btn>
                    <v-btn
                        class="text-white"
                        color="green lighten-1"
                        @click="submitRedeem()"
                    >
                        REDEEM
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

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
    props: ["coupon", "place", "redeemed"],
    data() {
        return {
            redeemDialog: false,
            redeemVerificationCode: "",
            disabled: false,
            overlay: false,
            overlayData: {
                icon: "",
                message: "",
            },
        };
    },
    filters: {
        expiry_format: function (date) {
            var a = moment(date).format("MMMM Do");
            var b = moment(date).format("HH:mm");
            var result = a + " at " + b;
            return result;
        },
    },
    mounted() {
        console.log(this.redeemed);
        if (this.redeemed == 0) {
            this.disabled = false;
        } else if (this.redeemed == 1) {
            this.disabled = true;
        }
    },
    methods: {
        submitRedeem() {
            this.overlay = true;
            this.overlayData.loading = true;
            this.redeemDialog = false;
            this.disabled = true;

            axios
                .post("/redeem-coupon", {
                    verification_code: this.redeemVerificationCode,
                    coupon_id: this.coupon.id,
                    customer_id: this.place.id,
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.message == "Success") {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Coupon Redeemed!";
                        this.disabled = true;
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
                        }, 2000);
                    } else {
                        this.overlayData.icon = "mdi-alert-circle";
                        this.overlayData.message =
                            "Verification Failed, please try again.";
                        this.overlayData.loading = false;
                        this.redeemDialog = false;

                        setTimeout(() => {
                            this.overlay = false;
                        }, 2000);
                    }
                })
                .catch((error) => {
                    this.overlayData.icon = "mdi-alert-circle";
                    this.overlayData.message =
                        "Verification Failed, please try again.";
                    this.overlayData.loading = false;
                    this.newCouponDialog = false;
                    console.log("Error!");
                });
        },
    },
};
</script>
