<template>
    <v-container>
        <v-row justify="center" class="py-2">
            <v-card class="mx-auto" max-width="600" outlined>
                <v-list-item three-line>
                    <v-list-item-content>
                        <div class="text-overline mb-4">
                            {{ this.details.name }}
                        </div>
                        <v-list-item-title class="text-h5 mb-1">
                            Signup Survey
                        </v-list-item-title>
                        <div>Select one or multiple responses</div>
                    </v-list-item-content>

                    <v-list-item-avatar tile size="80">
                        <v-img
                            class="mx-2"
                            :src="this.details.logo_location"
                            max-height="80px"
                            max-width="80px"
                        ></v-img>
                    </v-list-item-avatar>
                </v-list-item>

                <v-list-item>
                    <v-card-text class="text-left">
                        <div>Question 1</div>
                        <p class="text-h6 text--primary">
                            {{ this.q1.question }}
                        </p>
                        <v-container class="px-0" fluid>
                            <v-radio-group>
                                <v-checkbox
                                    v-model="a1"
                                    v-for="i in opts1"
                                    :key="i.id"
                                    :label="i.survey_question_option"
                                    :value="i.id"
                                    @change="handleCheckboxChange1(i.id)"
                                ></v-checkbox>
                                <v-checkbox
                                    label="All of the above"
                                    v-model="selectAll1"
                                ></v-checkbox>
                            </v-radio-group>
                        </v-container>
                    </v-card-text>
                </v-list-item>

                <v-list-item>
                    <v-card-text class="text-left">
                        <div>Question 2</div>
                        <p class="text-h6 text--primary">
                            {{ this.q2.question }}
                        </p>
                        <div class="text--primary">
                            <v-container class="px-0" fluid>
                                <v-radio-group>
                                    <v-checkbox
                                        v-model="a2"
                                        v-for="i in opts2"
                                        :key="i.id"
                                        :label="i.survey_question_option"
                                        :value="i.id"
                                        @change="handleCheckboxChange2(i.id)"
                                    ></v-checkbox>
                                    <v-checkbox
                                        label="All of the above"
                                        v-model="selectAll2"
                                    ></v-checkbox>
                                </v-radio-group>
                            </v-container>
                        </div>
                    </v-card-text>
                </v-list-item>

                <v-list-item
                    ><v-card-text class="text-left">
                        <div>Question 3</div>
                        <p class="text-h6 text--primary">
                            {{ this.q3.question }}
                        </p>
                        <div class="text--primary">
                            <v-container class="px-0" fluid>
                                <v-radio-group>
                                    <v-checkbox
                                        v-model="a3"
                                        v-for="i in opts3"
                                        :key="i.id"
                                        :label="i.survey_question_option"
                                        :value="i.id"
                                        @change="handleCheckboxChange3(i.id)"
                                    ></v-checkbox>
                                    <v-checkbox
                                        label="All of the above"
                                        v-model="selectAll3"
                                    ></v-checkbox>
                                </v-radio-group>
                            </v-container>
                        </div>
                    </v-card-text>
                </v-list-item>

                <v-card-actions class="text-center justify-center">
                    <v-btn
                        color="primary"
                        :disabled="
                            a1.length == 0 || a2.length == 0 || a3.length == 0
                        "
                        @click="saveSurveyResponse()"
                        >Submit</v-btn
                    >
                </v-card-actions>
                <v-card-text
                    v-if="a1.length == 0 || a2.length == 0 || a3.length == 0"
                    class="text-center red--text"
                >
                    Please complete the survey to continue.
                </v-card-text>
            </v-card>
        </v-row>

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
    </v-container>
</template>

<script>
export default {
    props: ["details", "survey", "q1", "q2", "q3", "opts1", "opts2", "opts3"],
    data() {
        return {
            overlay: false,
            overlayData: {
                icon: "",
                message: "",
            },
            a1: [],
            a2: [],
            a3: [],
            selectedIds: [],
        };
    },
    filters: {},
    mounted() {
        console.log(this.q1);
    },
    computed: {
        selectAll1: {
            get() {
                return this.a1.length === this.opts1.length;
            },
            set(value) {
                if (value) {
                    // Select all checkboxes and add all i.id values to the selectedIds array
                    this.a1 = this.opts1.map((item) => item.id);
                    this.selectedIds = this.opts1.map((item) => item.id);
                } else {
                    // Deselect all checkboxes and clear the selectedIds array
                    this.a1 = [];
                    this.selectedIds = [];
                }
            },
        },
        selectAll2: {
            get() {
                return this.a2.length === this.opts2.length;
            },
            set(value) {
                if (value) {
                    // Select all checkboxes and add all i.id values to the selectedIds array
                    this.a2 = this.opts2.map((item) => item.id);
                    this.selectedIds = this.opts2.map((item) => item.id);
                } else {
                    // Deselect all checkboxes and clear the selectedIds array
                    this.a2 = [];
                    this.selectedIds = [];
                }
            },
        },
        selectAll3: {
            get() {
                return this.a3.length === this.opts3.length;
            },
            set(value) {
                if (value) {
                    // Select all checkboxes and add all i.id values to the selectedIds array
                    this.a3 = this.opts3.map((item) => item.id);
                    this.selectedIds = this.opts3.map((item) => item.id);
                } else {
                    // Deselect all checkboxes and clear the selectedIds array
                    this.a3 = [];
                    this.selectedIds = [];
                }
            },
        },
    },
    methods: {
        handleCheckboxChange1(id) {
            if (this.a1.includes(id)) {
                this.selectedIds.push(id);
            } else {
                const index = this.selectedIds.indexOf(id);
                if (index !== -1) {
                    this.selectedIds.splice(index, 1);
                }
            }
        },
        handleCheckboxChange2(id) {
            if (this.a2.includes(id)) {
                this.selectedIds.push(id);
            } else {
                const index = this.selectedIds.indexOf(id);
                if (index !== -1) {
                    this.selectedIds.splice(index, 1);
                }
            }
        },
        handleCheckboxChange3(id) {
            if (this.a3.includes(id)) {
                this.selectedIds.push(id);
            } else {
                const index = this.selectedIds.indexOf(id);
                if (index !== -1) {
                    this.selectedIds.splice(index, 1);
                }
            }
        },
        saveSurveyResponse() {
            console.log(this.a1);
            console.log(this.a2);
            console.log(this.a3);
            this.overlay = true;
            this.overlayData.loading = true;

            axios
                .post("/save-survey-response", {
                    q1: this.q1.id,
                    q2: this.q2.id,
                    q3: this.q3.id,
                    a1: this.a1,
                    a2: this.a2,
                    a3: this.a3,
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
