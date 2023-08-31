<template>
    <v-card>
        <v-card-title class="text-h5"> Create Survey </v-card-title>
        <v-card-subtitle>
            Create a 3 question survey for your new subscribers to complete
            during sign-up
        </v-card-subtitle>

        <v-card-text>
            <v-text-field v-model="q1.name" label="Question 1"></v-text-field>

            <v-text-field
                v-model="q1.o1"
                label="Option 1"
                filled
                class="px-6"
            ></v-text-field>

            <v-text-field
                v-model="q1.o2"
                label="Option 2"
                filled
                class="px-6"
            ></v-text-field>

            <v-text-field
                v-model="q1.o3"
                label="Option 3"
                filled
                class="px-6"
            ></v-text-field>

            Question 1 Example:

            <v-card-text class="text-left">
                <div>Question 1</div>
                <p class="text-h6 text--primary">
                    {{ q1.name }}
                </p>
                <div class="text--primary">
                    <v-container fluid>
                        <v-checkbox
                            v-model="q1_selected"
                            :label="q1.o1"
                            value="o1"
                        ></v-checkbox>
                        <v-checkbox
                            v-model="q1_selected"
                            :label="q1.o2"
                            value="o2"
                        ></v-checkbox>
                        <v-checkbox
                            v-model="q1_selected"
                            :label="q1.o3"
                            value="o3"
                        ></v-checkbox>
                        <v-checkbox label="All of the above"></v-checkbox>
                    </v-container>
                </div>
            </v-card-text>

            <v-divider></v-divider>

            <v-text-field v-model="q2.name" label="Question 2"></v-text-field>

            <v-text-field
                v-model="q2.o1"
                label="Option 1"
                filled
                class="px-6"
            ></v-text-field>

            <v-text-field
                v-model="q2.o2"
                label="Option 2"
                filled
                class="px-6"
            ></v-text-field>

            <v-text-field
                v-model="q2.o3"
                label="Option 3"
                filled
                class="px-6"
            ></v-text-field>

            Question 2 Example:

            <v-card-text class="text-left">
                <div>Question 1</div>
                <p class="text-h6 text--primary">
                    {{ q2.name }}
                </p>
                <div class="text--primary">
                    <v-container fluid>
                        <v-checkbox
                            v-model="q2_selected"
                            :label="q2.o1"
                            value="o1"
                        ></v-checkbox>
                        <v-checkbox
                            v-model="q2_selected"
                            :label="q2.o2"
                            value="o2"
                        ></v-checkbox>
                        <v-checkbox
                            v-model="q2_selected"
                            :label="q2.o3"
                            value="o3"
                        ></v-checkbox>
                        <v-checkbox label="All of the above"></v-checkbox>
                    </v-container>
                </div>
            </v-card-text>

            <v-divider></v-divider>

            <v-text-field v-model="q3.name" label="Question 3"></v-text-field>

            <v-text-field
                v-model="q3.o1"
                label="Option 1"
                filled
                class="px-6"
            ></v-text-field>

            <v-text-field
                v-model="q3.o2"
                label="Option 2"
                filled
                class="px-6"
            ></v-text-field>

            <v-text-field
                v-model="q3.o3"
                label="Option 3"
                filled
                class="px-6"
            ></v-text-field>

            Question 3 Example:

            <v-card-text class="text-left">
                <div>Question 3</div>
                <p class="text-h6 text--primary">
                    {{ q3.name }}
                </p>
                <div class="text--primary">
                    <v-container fluid>
                        <v-checkbox
                            v-model="q3_selected"
                            :label="q3.o1"
                            value="o1"
                        ></v-checkbox>
                        <v-checkbox
                            v-model="q3_selected"
                            :label="q3.o2"
                            value="o2"
                        ></v-checkbox>
                        <v-checkbox
                            v-model="q3_selected"
                            :label="q3.o3"
                            value="o3"
                        ></v-checkbox>
                        <v-checkbox label="All of the above"></v-checkbox>
                    </v-container>
                </div>
            </v-card-text>

            <v-divider></v-divider>
        </v-card-text>

        <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn color="red darken-1" text href="/home"> Cancel </v-btn>

            <v-btn color="green darken-1 white--text" @click="saveSurvey()">
                Save Survey
            </v-btn>
        </v-card-actions>

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
    </v-card>
</template>

<script>
export default {
    props: [],
    data() {
        return {
            q1: {
                name: "",
                o1: "",
                o2: "",
                o3: "",
            },
            q2: {
                name: "",
                o1: "",
                o2: "",
                o3: "",
            },
            q3: {
                name: "",
                o1: "",
                o2: "",
                o3: "",
            },
            q1_selected: [],
            q2_selected: [],
            q3_selected: [],
            overlay: false,
            overlayData: {
                icon: "",
                message: "",
            },
        };
    },
    mounted() {},
    methods: {
        saveSurvey() {
            this.overlay = true;
            this.overlayData.loading = true;

            this.newCouponDialog = false;

            axios
                .post("/save-survey", {
                    q1: this.q1,
                    q2: this.q2,
                    q3: this.q3,
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
