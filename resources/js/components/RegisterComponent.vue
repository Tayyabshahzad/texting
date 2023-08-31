<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- <v-btn @click="sendTest()">send</v-btn> -->
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
                        <v-tab-item
                            key="User Registration"
                            @click="this.A = true"
                        >
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
                                        label="Name"
                                        prepend-icon="mdi-account-circle"
                                        v-model="name"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Phone"
                                        v-model="phone"
                                        prepend-icon="mdi-cellphone"
                                        prefix="(+1)"
                                        maxlength="10"
                                        @keypress="restrictToNumbers"
                                    ></v-text-field>
                                    <v-menu
                                        ref="menu"
                                        v-model="menu"
                                        :close-on-content-click="false"
                                        transition="scale-transition"
                                        offset-y
                                        min-width="auto"
                                    >
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-text-field
                                                v-model="birthday"
                                                label="Birthday date"
                                                prepend-icon="mdi-calendar"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="birthday"
                                            :active-picker.sync="activePicker"
                                            :max="
                                                new Date(
                                                    Date.now() -
                                                        new Date().getTimezoneOffset() *
                                                            60000
                                                )
                                                    .toISOString()
                                                    .substring(0, 10)
                                            "
                                            min="1950-01-01"
                                            @click="$refs.menu.save(birthday)"
                                        ></v-date-picker>
                                    </v-menu>
                                    <v-text-field
                                        v-model="password"
                                        label="Password"
                                        name="password"
                                        prepend-icon="mdi-lock"
                                        type="password"
                                        :rules="passwordRules"
                                    />

                                    <v-text-field
                                        v-model="confirmPassword"
                                        label="Confirm Password"
                                        name="confirmPassword"
                                        prepend-icon="mdi-lock"
                                        type="password"
                                        :rules="confirmPasswordRules"
                                    />

                                    <div>
                                        By registering, you agree to our
                                        <span
                                            ><a
                                                target="_blank"
                                                href="/user-agreement"
                                                >Terms & Conditions</a
                                            ></span
                                        >
                                        and that you are over 21 years of age.
                                    </div>
                                </v-card-text>

                                <v-card-actions>
                                    <v-btn
                                        block
                                        lg
                                        color="primary"
                                        :disabled="!isCompleteUser"
                                        @click="registerUser()"
                                    >
                                        Register
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-tab-item>
                        <v-tab-item
                            key="Business Registration"
                            @click="this.B = true"
                        >
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
                                        label="Name"
                                        prepend-icon="mdi-account-circle"
                                        v-model="customerName"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Phone"
                                        v-model="customerPhone"
                                        prepend-icon="mdi-cellphone"
                                        prefix="(+1)"
                                        maxlength="10"
                                        @keypress="restrictToNumbers"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Email"
                                        v-model="customerEmail"
                                        prepend-icon="mdi-email"
                                    ></v-text-field>
                                    <v-text-field
                                        label="Description"
                                        prepend-icon="mdi-information"
                                        v-model="customerDescription"
                                    ></v-text-field>
                                    <v-text-field
                                        v-model="customerPassword"
                                        label="Password"
                                        name="customerPassword"
                                        prepend-icon="mdi-lock"
                                        type="password"
                                        :rules="customerPasswordRules"
                                    />
                                    <v-text-field
                                        v-model="customerConfirmPassword"
                                        label="Confirm Password"
                                        name="customerConfirmPassword"
                                        prepend-icon="mdi-lock"
                                        type="password"
                                        :rules="customerConfirmPasswordRules"
                                    />
                                </v-card-text>
                                <v-card-actions>
                                    <v-btn
                                        block
                                        lg
                                        color="primary"
                                        :disabled="!isCompleteCustomer"
                                        @click="registerCustomer()"
                                    >
                                        Register
                                    </v-btn>
                                </v-card-actions>
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
            activePicker: null,
            overlay: false,
            date: "",
            overlayData: {
                icon: "",
                message: "",
            },
            tab: null,
            items: ["User Registration", "Business Registration"],
            menu: false,
            name: "",
            phone: "",
            birthday: "",
            password: "",
            confirmPassword: "",
            passwordRules: [
                (value) => !!value || "Please type password.",
                (value) =>
                    (value && value.length >= 6) || "minimum 6 characters",
            ],
            confirmPasswordRules: [
                (value) => !!value || "type confirm password",
                (value) =>
                    value === this.password ||
                    "The password confirmation does not match.",
            ],
            customerPasswordRules: [
                (value) => !!value || "Please type password.",
                (value) =>
                    (value && value.length >= 6) || "minimum 6 characters",
            ],
            customerConfirmPasswordRules: [
                (value) => !!value || "type confirm password",
                (value) =>
                    value === this.customerPassword ||
                    "The password confirmation does not match.",
            ],
            dob: "",
            customerName: "",
            customerPhone: "",
            customerEmail: "",
            customerDescription: "",
            customerPassword: "",
            customerConfirmPassword: "",
        };
    },
    watch: {
        menu(val) {
            val && setTimeout(() => (this.activePicker = "YEAR"));
        },
    },
    methods: {
        save(date) {
            this.$refs.menu.save(date);
        },
    },
    computed: {
        isCompleteUser() {
            return (
                this.name &&
                this.phone &&
                this.birthday &&
                this.password &&
                this.confirmPassword
            );
        },
        isCompleteCustomer() {
            return (
                this.customerName &&
                this.customerPhone &&
                this.customerEmail &&
                this.customerDescription &&
                this.customerPassword &&
                this.customerConfirmPassword
            );
        },
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
        registerUser() {
            this.overlay = true;
            this.overlayData.loading = true;

            axios
                .post("/register", {
                    name: this.name,
                    phone: this.phone,
                    dob: this.birthday,
                    password: this.password,
                    password_confirmation: this.confirmPassword,
                })
                .then((response) => {
                    console.log(response);
                    if (response.status == 201) {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Account Created!";
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
                    alert(error);
                });
        },
        registerCustomer() {
            this.overlay = true;
            this.overlayData.loading = true;

            axios
                .post("/register-new-customer", {
                    name: this.customerName,
                    phone: this.customerPhone,
                    email: this.customerEmail,
                    desc: this.customerDescription,
                    password: this.customerPassword,
                    password_confirmation: this.customerConfirmPassword,
                })
                .then((response) => {
                    console.log(response);
                    if (response.status == 200) {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Account Created!";
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
        sendTest() {
            axios
                .get("/send-test")
                .then((response) => {
                    console.log(response);
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
