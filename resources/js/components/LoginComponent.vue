<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <v-card>
                    <v-tabs
                        v-model="tab"
                        background-color="transparent"
                        color="primary"
                        centered
                    >
                        <v-tab v-for="item in items" :key="item">
                            {{ item }}
                        </v-tab>
                    </v-tabs>

                    <v-tabs-items v-model="tab">
                        <v-tab-item key="User Login">
                            <v-card class="pa-6">
                                <div
                                    class="d-flex flex-column justify-space-between align-center pa-8"
                                >
                                    <v-img
                                        :src="'/images/FullLogo_Transparent_NoBuffer.png'"
                                        alt="Login"
                                        max-width="200px"
                                    />
                                </div>

                                <v-card-text class="text-center">
                                    <v-text-field
                                        label="Phone"
                                        v-model="username"
                                        prepend-icon="mdi-cellphone"
                                        prefix="(+1)"
                                        maxlength="11"
                                        @keypress="restrictToNumbers"
                                    ></v-text-field>

                                    <v-text-field
                                        v-model="password"
                                        label="Password"
                                        name="password"
                                        prepend-icon="mdi-lock"
                                        type="password"
                                    />
                                </v-card-text>
                                <v-card-actions>
                                    <v-btn
                                        block
                                        lg
                                        color="primary"
                                        @click="login()"
                                    >
                                        Login
                                    </v-btn>
                                </v-card-actions>
                                <v-divider></v-divider>
                                <v-card-text class="text-center">
                                    <a class="nav-link" href="password-reset"
                                        >Forgot Password?</a
                                    >
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item key="Business Login">
                            <v-card class="pa-6">
                                <div
                                    class="d-flex flex-column justify-space-between align-center pa-8"
                                >
                                    <v-img
                                        :src="'/images/FullLogo_Transparent_NoBuffer.png'"
                                        alt="Login"
                                        max-width="200px"
                                    />
                                </div>


                                <v-card-text class="text-center">
                                    <v-text-field
                                        label="Email"
                                        v-model="username"
                                        prepend-icon="mdi-email"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="password"
                                        label="Password"
                                        name="customerPassword"
                                        prepend-icon="mdi-lock"
                                        type="password"
                                    />
                                </v-card-text>
                                <v-card-actions>
                                    <v-btn
                                        block
                                        lg
                                        color="primary"
                                        @click="login()"
                                    >
                                        Login
                                    </v-btn>
                                </v-card-actions>
                                <v-divider></v-divider>
                                <v-card-text class="text-center">
                                    <a class="nav-link" href="password/reset"
                                        >Forgot Password?</a
                                    >
                                </v-card-text>
                            </v-card>
                        </v-tab-item>
                    </v-tabs-items>
                </v-card>
            </div>
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
import axios from "axios";

export default {
    data() {
        return {
            overlay: false,
            overlayData: {
                icon: "",
                message: "",
            },
            tab: null,
            items: ["User Login", "Business Login"],
            menu: false,
            username: "",
            password: "",
        };
    },
    methods: {
        restrictToNumbers(event) {
            const keyCode = event.keyCode || event.which;
            const keyValue = String.fromCharCode(keyCode);
            const regex = /^[0-9]*$/; // Only allow numbers

            if (!regex.test(keyValue)) {
                event.preventDefault();
            }
        },
        login() {
            this.overlay = true;
            this.overlayData.loading = true;

            axios
                .post("/login", {
                    username: this.username,
                    password: this.password,
                })
                .then((response) => {
                    console.log(response);
                    if (response.status == 204) {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Logged In!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
                            location.href = "/home";
                        }, 2000);
                    } else {
                        this.overlayData.icon = "mdi-alert-circle";
                        this.overlayData.message =
                            "Something went wrong, please try again.";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
                            location.href = "/register";
                        }, 2000);
                    }
                })
                .catch((error) => {
                    this.overlayData.loading = false;
                    this.overlayData.icon = "mdi-alert-circle";
                    this.overlayData.message = error.response.data.message;
                    this.overlayData.loading = false;
                });
        },
    },
};
</script>
