<template>
    <v-container>
        <v-row justify="center" class="py-2">
            <v-card class="mx-auto" max-width="600" outlined>
                <v-list-item three-line>
                    <v-list-item-content>
                        <v-list-item-title class="text-h5 mb-1">
                            Signup Survey
                        </v-list-item-title>
                        <div>Select one or multiple responses</div>
                    </v-list-item-content>
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
                                ></v-checkbox>
                                <v-checkbox
                                    label="All of the above"
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
                                    ></v-checkbox>
                                    <v-checkbox
                                        label="All of the above"
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
                                    ></v-checkbox>
                                    <v-checkbox
                                        label="All of the above"
                                    ></v-checkbox>
                                </v-radio-group>
                            </v-container>
                        </div>
                    </v-card-text>
                </v-list-item>
            </v-card>
        </v-row>
    </v-container>
</template>

<script>
export default {
    props: ["survey", "q1", "q2", "q3", "opts1", "opts2", "opts3"],
    data() {
        return {
            overlay: false,
            overlayData: {
                icon: "",
                message: "",
            },
        };
    },
    filters: {},
    mounted() {
        console.log(this.q1);
    },
    methods: {},
};
</script>
