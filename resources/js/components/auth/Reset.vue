<template>
    <div
        style="
            padding-top: 50px;
            background-image: url('https://static.wixstatic.com/media/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg/v1/fill/w_2024,h_1660,al_c,q_90,usm_0.66_1.00_0.01,enc_auto/11062b_63728f9042674bd9a69303659c7037cb~mv2.jpg');
            background-size: cover;
            width: 100%;
            height: 100vh;
        "
    >
        <div class="row justify-content-center">
            <v-card class="col-10 col-md-4">
                <v-card-title> Password Reset </v-card-title>
                <v-card-text>
                    <v-text-field
                        v-model="new_pass"
                        hint="New Password"
                        persistent-hint
                        class="my-2"
                        type="password"
                        :rules="passwordRules"
                    ></v-text-field>
                </v-card-text>
                <v-card-text>
                    <v-text-field
                        v-model="confirm_new_pass"
                        hint="Confirm Password"
                        persistent-hint
                        class="my-2 mr-2"
                        type="password"
                        :rules="[...passwordRules, confirmPasswordRule]"
                    ></v-text-field>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" @click="sendPasswordReset()"
                        >Reset Password</v-btn
                    >
                </v-card-actions>
            </v-card>
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
export default {
    mounted() {
        console.log("Component mounted.");
        let url = new URL(window.location.href);
        // get token
        this.token = url.pathname.substring(7);
    },
    data() {
        return {
            phone: "",
            overlay: false,
            overlayData: {
                icon: "",
                message: "",
            },
            new_pass: "",
            confirm_new_pass: "",
            token: "",
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
                value === this.new_pass || "Passwords do not match";
        },
    },
    methods: {
        sendPasswordReset() {
            this.overlay = true;
            this.overlayData.loading = true;

            axios
                .post("/handle-reset", {
                    password: this.new_pass,
                    token: this.token,
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.message == "Success") {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Password Reset!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
                            location.href = "/login";
                        }, 2000);
                    } else {
                        this.overlayData.icon = "mdi-alert-circle";
                        this.overlayData.message =
                            "Something went wrong, please try again.";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
                        }, 2000);
                    }
                })
                .catch((error) => {
                    this.overlayData.icon = "mdi-alert-circle";
                    this.overlayData.message =
                        "Something went wrong, please try again.";
                    this.overlayData.loading = false;
                    console.log(error);
                });
        },
    },
};
</script>
