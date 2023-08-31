<template>
    <div>
        <v-card>
            <v-tabs
                v-model="tab"
                background-color="transparent"
                slider-color="primary"
                grow
            >
                <v-tab v-for="item in items" :key="item">
                    {{ item }}
                </v-tab>
            </v-tabs>

            <!-- {{ this.couponList }} -->

            <v-tabs-items v-model="tab">
                <v-tab-item key="Coupons">
                    <v-card v-if="!this.couponList.length">
                        <v-card-text> No coupons </v-card-text>
                    </v-card>
                    <v-card
                        v-for="(item, index) in this.couponList"
                        :key="index"
                        class="my-4 mx-4"
                    >
                        <v-card-text>
                            <b>{{ item.name }}</b>
                            <v-row>
                                <v-col class="text-left text-h5">
                                    {{ item.coupon.description }}
                                </v-col>
                                <v-col class="text-right text-h4 text-bold">
                                    "{{ item.coupon.code }}"
                                </v-col>
                            </v-row>

                            <div>
                                {{ item.expiry | check_expired_text }}
                                <v-chip
                                    v-if="item.expiry"
                                    :color="item.expiry | check_expired"
                                    class="my-2"
                                    text-color="white"
                                    content="sasa"
                                >
                                    <b> {{ item.expiry | expiry_format }}</b>
                                </v-chip>
                            </div>
                        </v-card-text>
                        <v-card-text class="text-right">
                            <v-chip v-if="item.redeemed == 1" color="red">
                                <div>Redeemed</div>
                            </v-chip>
                        </v-card-text>

                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                :disabled="
                                    redeemDisabled(item.redeemed, item.expiry)
                                "
                                color="primary"
                                @click="redeemLink(item.coupon.id)"
                            >
                                REDEEM
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-tab-item>
                <v-tab-item key="Subscriptions">
                    <v-card flat>
                        <v-card-actions>
                            <v-btn
                                icon
                                color="blue lighten-1"
                                @click="infoDialog = true"
                            >
                                <v-icon>mdi-help-circle-outline</v-icon>
                            </v-btn>
                            <v-spacer></v-spacer>

                            <v-btn
                                :disabled="this.disabled"
                                color="green lighten"
                                class="ma-2 white--text"
                                @click="updateSubs()"
                            >
                                Update
                            </v-btn>
                        </v-card-actions>
                        <v-card-text>
                            <v-list-item
                                v-for="(item, index) in this.available"
                                :key="index"
                            >
                                <template v-slot:default="{ active }">
                                    <v-list-item-action>
                                        <v-checkbox
                                            v-model="userSubscriptions"
                                            :value="item.id"
                                        ></v-checkbox>
                                    </v-list-item-action>

                                    <v-list-item-content>
                                        <v-list-item-title>{{
                                            item.name
                                        }}</v-list-item-title>
                                        <v-list-item-subtitle>
                                            {{ item.description }}
                                        </v-list-item-subtitle>
                                    </v-list-item-content>

                                    <v-list-item-action>
                                        <v-list-item-action-text
                                            >View Info</v-list-item-action-text
                                        >

                                        <v-btn icon @click="showDetails(item)">
                                            <v-icon color="blue lighten-1">
                                                mdi-eye
                                            </v-icon>
                                        </v-btn>
                                    </v-list-item-action>
                                </template>
                            </v-list-item>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
                <v-tab-item key="Settings">
                    <v-card flat>
                        <v-card-actions>
                            <v-spacer></v-spacer>

                            <v-btn
                                color="green lighten"
                                class="ma-2 white--text"
                                @click="updateDetails()"
                            >
                                Save
                            </v-btn>
                        </v-card-actions>
                        <v-card-text>
                            <v-text-field
                                v-model="newData.name"
                                :label="user.name"
                                hint="Full Name"
                                persistent-hint
                                class="m-2"
                            ></v-text-field>

                            <v-menu
                                ref="menu"
                                v-model="menu"
                                :close-on-content-click="false"
                                :return-value.sync="newData.dob"
                                transition="scale-transition"
                                offset-y
                                min-width="auto"
                                disabled
                            >
                                <template v-slot:activator="{ on, attrs }">
                                    <v-text-field
                                        disabled
                                        v-model="newData.dob"
                                        :label="
                                            user.birthday | american_date_format
                                        "
                                        readonly
                                        v-bind="attrs"
                                        v-on="on"
                                        hint="Receive special birthday coupons on your special day!"
                                        persistent-hint
                                        class="mx-2"
                                    ></v-text-field>
                                </template>
                                <v-date-picker
                                    v-model="newData.dob"
                                    no-title
                                    scrollable
                                >
                                    <v-spacer></v-spacer>
                                    <v-btn
                                        text
                                        color="primary"
                                        @click="menu = false"
                                    >
                                        Cancel
                                    </v-btn>
                                    <v-btn
                                        text
                                        color="primary"
                                        @click="$refs.menu.save(newData.dob)"
                                    >
                                        OK
                                    </v-btn>
                                </v-date-picker>
                            </v-menu>

                            <v-text-field
                                :label="user.phone"
                                hint="Phone (+1)"
                                persistent-hint
                                disabled
                                class="mx-2"
                            ></v-text-field>

                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="newData.current_pass"
                                        hint="Current Password"
                                        persistent-hint
                                        class="my-2 ml-2"
                                        type="password"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="newData.new_pass"
                                        hint="New Password"
                                        persistent-hint
                                        class="my-2"
                                        type="password"
                                        :rules="passwordRules"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="newData.confirm_new_pass"
                                        hint="Confirm Password"
                                        persistent-hint
                                        class="my-2 mr-2"
                                        type="password"
                                        :rules="[
                                            ...passwordRules,
                                            confirmPasswordRule,
                                        ]"
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs-items>
        </v-card>

        <!-- Cusomer Details Dialog -->
        <v-dialog v-model="detailDialog" max-width="500">
            <v-card>
                <v-card-title class="text-h5">
                    {{ this.modalDetails.name }}
                </v-card-title>

                <v-card-text>
                    {{ this.modalDetails.description }}
                    <br />
                    +1{{ this.modalDetails.phone }}
                </v-card-text>

                <div></div>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="detailDialog = false"
                    >
                        close
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Info Dialog -->
        <v-dialog v-model="infoDialog" max-width="500">
            <v-card>
                <v-card-title class="text-h5">
                    Your Subscriptions
                </v-card-title>

                <v-card-text>
                    Browse and subscribe to our partners for more exciting
                    coupon discounts.
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="green darken-1"
                        text
                        @click="infoDialog = false"
                    >
                        close
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
    props: ["user", "available", "subscriptions", "coupon-list"],
    data() {
        return {
            tab: null,
            items: ["Coupons", "Subscriptions", "Settings"],
            addDialog: false,
            userSubscriptions: this.subscriptions,
            detailDialog: false,
            modalDetails: "",
            disabled: true,
            infoDialog: false,
            overlay: false,
            overlayData: {
                icon: "",
                message: "",
            },
            modified: false,
            menu: false,
            newData: {
                type: "user",
                name: "",
                phone: "",
                descriptions: "",
                map_url: "",
                logo: "",
                verification_code: "",
                current_pass: "",
                new_pass: "",
                confirm_new_pass: "",
            },
        };
    },
    computed: {
        passwordRules() {
            return [
                (value) => !!value || "Password is required",
                (value) =>
                    value.length >= 8 ||
                    "Password must be at least 8 characters long",
            ];
        },
        confirmPasswordRule() {
            return (value) =>
                value === this.newData.new_pass || "Passwords do not match";
        },
    },
    watch: {
        userSubscriptions: {
            deep: true,
            handler(newValue, oldValue) {
                this.disabled = false; // or whatever you need to do when the model becomes dirty
            },
        },
    },
    mounted() {
        console.log(this.subscriptions);
    },
    filters: {
        american_date_format: function (date) {
            return moment(date).format("MM-DD-YYYY");
        },
        created_format: function (date) {
            return moment(date).format("MMMM Do YYYY, h:mm a");
        },
        expiry_format: function (date) {
            var a = moment(date).format("MMMM Do");
            var b = moment(date).format("HH:mm");
            var result = a + " at " + b;
            return result;
        },
        is_expired: function (date) {
            var now = moment().format("YYYY-MM-DD HH:mm:ss");

            if (now > date) {
                return "true";
            } else {
                return "false";
            }
        },
        check_expired: function (date) {
            var now = moment().format("YYYY-MM-DD HH:mm:ss");

            if (now > date) {
                return "red";
            } else {
                return "green";
            }
        },
        check_expired_icon: function (date) {
            var now = moment().format("YYYY-MM-DD HH:mm:ss");

            if (now > date) {
                return "mdi-lock";
            } else {
                return "mdi-clock";
            }
        },
        check_expired_text: function (date) {
            var now = moment().format("YYYY-MM-DD HH:mm:ss");

            if (now > date) {
                return "Coupon Expired";
            } else if (now < date) {
                return "Coupon Expires";
            } else {
                return "Special Coupon";
            }
        },
    },
    methods: {
        updateSubs() {
            this.overlay = true;
            this.overlayData.loading = true;

            console.log(this.available);

            axios
                .post("/update-subs", {
                    subs: this.userSubscriptions,
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.message == "Success") {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Subscriptions Updated!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlayData.icon = "";
                            this.overlayData.message = "";
                            this.overlay = false;
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
                    alert(error);
                    console.log("Error!");
                });
        },
        showDetails(data) {
            this.detailDialog = true;
            this.modalDetails = data;
        },
        redeemLink(id) {
            console.log(id);
            location.href = "redeem/" + id;
        },
        redeemDisabled(redeemed, expiry) {
            var now = moment().format("YYYY-MM-DD HH:mm:ss");

            if (redeemed == 1 || now > expiry) {
                return true;
            } else if (redeemed == 0) {
                return false;
            }
        },
        updateDetails() {
            this.overlay = true;
            this.overlayData.loading = true;
            this.overlayData.message = "";

            axios
                .post("/update-user-settings", {
                    data: this.newData,
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.message == "Success") {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Update Successful!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
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

                    setTimeout(() => {
                        this.overlay = false;
                    }, 2000);
                });
        },
    },
};
</script>
