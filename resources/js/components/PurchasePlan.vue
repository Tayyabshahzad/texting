<template>
    <div class="container">
        <div class="row justify-content-center">
            <v-row class="pa-4">
                <v-card-text>
                    <h2>Select A Plan</h2>
                </v-card-text>

                <v-col
                    v-for="(item, index) in this.plans"
                    :key="index"
                    class="col-6"
                >
                    <v-card class="py-2" style="max-height: 420px">
                        <div v-if="item.id == 3" class="text-center">
                            <v-chip color="primary" outlined label class="ma-2">
                                Most Popular
                            </v-chip>
                            <v-chip color="primary" label class="ma-2">
                                Best Value
                            </v-chip>
                        </div>

                        <div
                            v-else
                            class="text-center"
                            style="visibility: hidden"
                        >
                            <v-chip color="primary" label class="ma-2">
                                Plan
                            </v-chip>
                        </div>

                        <v-list-item class="text-center">
                            <v-list-item-content>
                                <v-list-item-title class="text-h5">
                                    {{ item.plan_name }}
                                </v-list-item-title>
                                <v-list-item-subtitle>
                                    {{ item.type }}
                                </v-list-item-subtitle>
                            </v-list-item-content>
                        </v-list-item>

                        <v-card-text>
                            <v-row justify="center">
                                <v-col
                                    class="mx-0 text-center px-0 p-3"
                                    cols="12"
                                >
                                    <span class="text-h5 align-items-top"
                                        >$</span
                                    ><span class="text-h2">{{
                                        item.price
                                    }}</span>
                                    <div
                                        v-if="item.type == 'Monthly'"
                                        class="text-center"
                                    >
                                        <p>Every Month</p>
                                    </div>
                                    <div v-else class="text-center">
                                        <p>Every Year</p>
                                    </div>
                                </v-col>

                                <v-card-text class="text-center">
                                    Up to {{ item.max_smses }} Messages Per
                                    Month
                                    <br />
                                </v-card-text>
                            </v-row>
                        </v-card-text>

                        <v-card-actions
                            justify="center"
                            class="text-center ma-4"
                        >
                            <v-btn
                                v-if="item.id == 3"
                                x-large
                                block
                                color="primary"
                                :href="'/view-plan/' + item.id"
                                >Purchase</v-btn
                            >

                            <v-btn
                                v-else
                                x-large
                                block
                                outlined
                                color="grey"
                                class="text-black"
                                :href="'/view-plan/' + item.id"
                                >Purchse</v-btn
                            >
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
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

export default {
    props: ["plans"],
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
    mounted() {},
    methods: {},
};
</script>
