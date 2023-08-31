<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <v-form>
                    <v-container>
                        <v-row>
                            <v-col>
                                <v-text-field
                                    v-model="number"
                                    label="Number"
                                    required
                                ></v-text-field>
                            </v-col>
                        </v-row>
                        <v-btn @click="sendSMS()">Send SMS</v-btn>
                    </v-container>
                </v-form>
            </div>
        </div>
        <v-overlay :value="overlay"></v-overlay>
    </div>
</template>

<script>
import axios from "axios";

export default {
    mounted() {
        console.log("Component mounted.");
    },
    data() {
        return {
            number: "",
            overlay: false,
        };
    },
    mounted() {},
    methods: {
        sendSMS() {
            this.overlay = true;

            axios
                .post("send-test-sms", {
                    number: this.number,
                })
                .catch(function (error) {
                    if (error.response) {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx
                        console.log(error.response.data);
                        console.log(error.response.status);
                        console.log(error.response.headers);
                    } else if (error.request) {
                        // The request was made but no response was received
                        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                        // http.ClientRequest in node.js
                        console.log(error.request);
                    } else {
                        // Something happened in setting up the request that triggered an Error
                        console.log("Error", error.message);
                    }
                    console.log(error.config);
                });

            this.overlay = false;
        },
    },
};
</script>
