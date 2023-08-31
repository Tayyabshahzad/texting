<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div>
                    <v-card class="ma-4">
                        <v-row class="mx-2">
                            <v-col class="body-1 my-4 text-center"
                                >Users <br />
                                <b class="text-h6">{{
                                    this.counts["users"]
                                }}</b></v-col
                            >
                            <v-col class="body-1 my-4 text-center"
                                >Customers <br />
                                <b class="text-h6">{{
                                    this.counts["customers"]
                                }}</b></v-col
                            >
                            <v-col class="body-1 my-4 text-center"
                                >Total <br />
                                <b class="text-h6">{{
                                    this.counts["total"]
                                }}</b></v-col
                            >
                        </v-row>
                    </v-card>

                    <v-card class="ma-4">
                        <apexchart
                            id="chart"
                            type="bar"
                            :options="userOptions"
                            :series="userOptions.series"
                        ></apexchart>
                    </v-card>
                    <v-card class="ma-4">
                        <v-card-title> SMS Content </v-card-title>
                        <v-card-subtitle>
                            <div>Use dct-comp-name to insert company name</div>
                            <div>
                                Use dct-url to insert company name
                            </div></v-card-subtitle
                        >
                        <v-card-subtitle></v-card-subtitle>
                        <v-card-text class="text-center">
                            <v-textarea
                                class="text-center ma-2"
                                v-model="smsText"
                                :placeholder="this.sms.content"
                                no-resize
                            >
                            </v-textarea>
                        </v-card-text>

                        <v-card-actions>
                            <v-btn color="primary" @click="updateSmsContent()">
                                Update Sms Content
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </div>
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
export default {
    mounted() {
        console.log("Component mounted.");
    },
    props: ["sms", "counts"],
    data() {
        return {
            overlay: false,
            overlayData: {
                icon: "",
                message: "",
            },
            smsText: "",
            // Graph 1
            userOptions: {
                title: {
                    text: "New Users",
                    align: "left",
                },
                chart: {
                    height: 350,
                    type: "line",
                    toolbar: {
                        show: false,
                    },
                },
                series: this.counts.userCounts.series,
                xaxis: this.counts.userCounts.xaxis,
            },
        };
    },
    mounted() {
        console.log(this.counts);
    },
    methods: {
        updateSmsContent() {
            this.overlay = true;
            this.overlayData.loading = true;

            axios
                .post("/update-sms", {
                    data: this.smsText,
                })
                .then((response) => {
                    if (response.data.message == "Success") {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Update Successful!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
                            location.href = "/admin-tools";
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
                });
        },
    },
};
</script>
