<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- <v-btn @click="sendTest()">send</v-btn> -->
                <v-card class="pa-6">
                    <div
                        class="d-flex flex-column justify-space-between align-center pa-8"
                    >
                        <v-img
                            :src="this.details.logo_location"
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
                            <template v-slot:activator="{ on, attrs }">
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
                                :max="maxDate"
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
                                ><a target="_blank" href="/user-agreement"
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
                            @click="doLiveSignup()"
                        >
                            Register
                        </v-btn>
                    </v-card-actions>
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
    props: ["details"],
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
            dob: "",
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
        maxDate() {
            const currentDate = new Date();
            const maxYear = currentDate.getFullYear() - 21;
            const maxDate = new Date(
                maxYear,
                currentDate.getMonth(),
                currentDate.getDate()
            );

            return maxDate.toISOString().substring(0, 10);
        },
        isCompleteUser() {
            return (
                this.name &&
                this.phone &&
                this.birthday &&
                this.password &&
                this.confirmPassword &&
                this.passwordRules.every(
                    (rule) => rule(this.password) === true
                ) &&
                this.confirmPasswordRules.every(
                    (rule) => rule(this.confirmPassword) === true
                )
            );
        },
    },
    mounted() {
        console.log(this.details);
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
        doLiveSignup() {
            this.overlay = true;
            this.overlayData.loading = true;

            axios
                .post("/do-live-signup", {
                    name: this.name,
                    phone: this.phone,
                    dob: this.birthday,
                    password: this.password,
                    customer_id: this.details.id,
                    customer_user_id: this.details.user_id,
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
                    console.log(error);
                    this.overlayData.icon = "mdi-alert-circle";
                    this.overlayData.message =
                        "Something went wrong, please try again.";
                    this.overlayData.loading = false;

                    setTimeout(() => {
                        this.overlay = false;
                        var url = "/live-signup/" + this.details.liveurl;
                        location.href = url;
                    }, 2000);
                });
        },
    },
};
</script>
