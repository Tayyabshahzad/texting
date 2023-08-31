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
                        prefix="(+1)"
                        v-model="phone"
                        hint="Mobile Number"
                        persistent-hint
                        class="m-2"
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
    },
    data() {
        return {
            phone: "",
            overlay: false,
            overlayData: {
                icon: "",
                message: "",
            },
        };
    },
    methods: {
        sendPasswordReset() {
            this.overlay = true;
            this.overlayData.loading = true;

            axios
                .post("/reset-password-sms", {
                    phone: this.phone,
                })
                .then((response) => {
                    console.log(response);
                    if (response.data.message == "Success") {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Password Reset Sent!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
                            location.href = "/";
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
