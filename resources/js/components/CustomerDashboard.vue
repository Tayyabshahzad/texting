<template>
    <div>
        <v-card color="basil">
            <v-tabs
                v-model="tab"
                background-color="transparent"
                slider-color="primary"
                grow
                show-arrows
            >
                <v-tab v-for="item in items" :key="item">
                    {{ item }}
                </v-tab>
            </v-tabs>

            <v-tabs-items v-model="tab">
                <v-tab-item key="Overview">
                    <v-row class="pa-4">
                        <v-col cols="4">
                            <v-card>
                                <v-card-text>
                                    <div>Coupon Stats</div>
                                    <p class="text-h4 text--primary">
                                        {{ this.sentTotal }} /
                                        {{ this.currentPlan.max_smses }}
                                    </p>
                                    <p>{{ usedCouponPercentage }}% used</p>
                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col cols="4">
                            <v-card>
                                <v-card-text>
                                    <div>Subscribers</div>
                                    <p
                                        class="text-h4 text--primary text-center"
                                    >
                                        {{ this.totalSubscribers }}
                                    </p>
                                    <p>Total Subscribers</p>
                                </v-card-text>
                            </v-card>
                        </v-col>
                        <v-col cols="4">
                            <v-card>
                                <v-card-text>
                                    <div>New Subscribers</div>
                                    <p
                                        class="text-h4 text--primary text-center"
                                    >
                                        {{ this.monthlySubscribers }}
                                    </p>
                                    <p>This Month</p>
                                </v-card-text>
                            </v-card>
                        </v-col>
                    </v-row>
                    <v-card flat>
                        <v-card-text>
                            <div>
                                <apexchart
                                    id="chart"
                                    type="line"
                                    :options="this.subscriberStatsOptions"
                                    :series="this.subscriberStatsOptions.series"
                                ></apexchart>
                            </div>

                            <div>
                                <apexchart
                                    id="chart2"
                                    :options="this.smsStatsOptions"
                                    :series="this.smsStatsOptions.series"
                                ></apexchart>
                            </div>

                            <div>
                                <apexchart
                                    id="chart3"
                                    :options="this.redeemedStatsOptions"
                                    :series="this.redeemedStatsOptions.series"
                                ></apexchart>
                            </div>

                            <div style="height: 300px" class="py-2">
                                <apexchart
                                    type="pie"
                                    height="300"
                                    :options="this.surveyChartOptions1"
                                    :series="this.surveySeries1"
                                ></apexchart>
                            </div>

                            <div style="height: 300px" class="py-2">
                                <apexchart
                                    type="pie"
                                    height="300"
                                    :options="this.surveyChartOptions2"
                                    :series="this.surveySeries2"
                                ></apexchart>
                            </div>

                            <div style="height: 300px" class="py-2">
                                <apexchart
                                    type="pie"
                                    height="300"
                                    :options="this.surveyChartOptions3"
                                    :series="this.surveySeries3"
                                ></apexchart>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-tab-item>

                <v-tab-item key="Coupons">
                    <v-card-actions class="mx-2">
                        <v-btn
                            color="blue lighten"
                            class="white--text"
                            @click.stop="newSubberCouponDialog = true"
                        >
                            <v-icon> mdi-account-multiple-plus </v-icon>
                        </v-btn>
                        <v-btn
                            color="blue lighten"
                            class="white--text"
                            @click.stop="birthdayCouponDialog = true"
                        >
                            <v-icon> mdi-cake-variant </v-icon>
                        </v-btn>
                        <v-spacer></v-spacer>
                        <!-- disable the button if coupon percentage = 100 percent -->
                        <v-btn
                            :disabled="this.usedCouponPercentage === 100"
                            color="green lighten"
                            class="white--text"
                            @click.stop="newCouponDialog = true"
                        >
                            <v-icon> mdi-plus </v-icon>
                            New Coupon 2
                        </v-btn>
                    </v-card-actions>
                    <v-card
                        v-for="(item, index) in this.coupons"
                        :key="index"
                        class="mb-4 mx-4"
                    >
                        <v-card-text>
                            <div class="subtitle-2 text-right">
                                ID: {{ item.id }}
                            </div>
                            <p class="text-h6">Code: "{{ item.code }}"</p>
                            <v-badge
                                bordered
                                :color="item.expiry | check_expired"
                                :icon="item.expiry | check_expired_icon"
                            >
                                <div>
                                    Exipres: {{ item.expiry | expiry_format }}
                                </div>
                            </v-badge>

                            <div>
                                Created: {{ item.created_at | created_format }}
                            </div>
                        </v-card-text>
                        <v-card-text>
                            <div class="body-1">
                                {{ item.description }}
                            </div>
                        </v-card-text>
                    </v-card>
                </v-tab-item>

                <v-tab-item key="Subscribers">
                    <v-card-actions class="mx-2">
                        <v-btn
                            color="blue lighten"
                            class="white--text"
                            @click.stop="viewGroupsDialog = true"
                        >
                            <v-icon> mdi-eye </v-icon>
                            View Groups
                        </v-btn>
                        <v-spacer></v-spacer>
                        <!-- disable the button if coupon percentage = 100 percent -->
                        <v-btn
                            :disabled="this.usedCouponPercentage === 100"
                            color="green lighten"
                            class="white--text"
                            @click.stop="newGroupDialog = true"
                        >
                            <v-icon> mdi-plus </v-icon>
                            New Group
                        </v-btn>
                    </v-card-actions>
                    <v-card>
                        <v-card-title>
                            <v-text-field
                                v-model="search"
                                append-icon="mdi-magnify"
                                label="Search"
                                single-line
                                hide-details
                            ></v-text-field>
                        </v-card-title>
                        <v-data-table
                            :search="search"
                            :headers="headers"
                            :items="this.subscribers"
                            :items-per-page="10"
                            class="elevation-1"
                        ></v-data-table>
                    </v-card>
                </v-tab-item>

                <v-tab-item key="Settings">
                    <v-card flat>
                        <v-card-actions>
                            <v-btn
                                v-if="this.survey"
                                color="green lighten"
                                class="ma-2 white--text"
                                href="view-customer-survey"
                            >
                                View Survey
                            </v-btn>
                            <v-btn
                                v-else
                                color="green lighten"
                                class="ma-2 white--text"
                                href="create-survey"
                            >
                                Create Survey
                            </v-btn>
                            <v-spacer></v-spacer>

                            <v-btn
                                color="green lighten"
                                class="ma-2 white--text"
                                @click="updateDetails()"
                            >
                                Save
                            </v-btn>
                        </v-card-actions>
                        <v-card-text>
                            <v-text-field
                                v-model="newData.name"
                                :label="details.name"
                                hint="Name"
                                persistent-hint
                                class="m-2"
                            ></v-text-field>

                            <v-text-field
                                v-model="newData.phone"
                                :label="details.phone"
                                hint="Phone (+1)"
                                persistent-hint
                                class="mx-2"
                                disabled
                            ></v-text-field>

                            <v-text-field
                                v-model="newData.description"
                                :label="details.description"
                                hint="Description"
                                persistent-hint
                                class="mx-2"
                            ></v-text-field>

                            <v-text-field
                                v-model="newData.verification_code"
                                :label="details.verification_code"
                                hint="Coupon Verification Code"
                                persistent-hint
                                class="mx-2"
                            ></v-text-field>

                            <v-text-field
                                v-model="newData.map_url"
                                :label="details.map_url"
                                hint="Google Maps URL"
                                persistent-hint
                                class="mx-2"
                            ></v-text-field>

                            <v-row>
                                <v-col>
                                    <v-text-field
                                        v-model="newData.current_pass"
                                        hint="Current Password"
                                        persistent-hint
                                        class="my-2 ml-2"
                                        type="password"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="newData.new_pass"
                                        hint="New Password"
                                        persistent-hint
                                        class="my-2"
                                        type="password"
                                        :rules="passwordRules"
                                    ></v-text-field>
                                </v-col>
                                <v-col>
                                    <v-text-field
                                        v-model="newData.confirm_new_pass"
                                        hint="Confirm Password"
                                        persistent-hint
                                        class="my-2 mr-2"
                                        type="password"
                                        :rules="[
                                            ...passwordRules,
                                            confirmPasswordRule,
                                        ]"
                                    ></v-text-field>
                                </v-col>
                            </v-row>

                            <v-file-input
                                show-size
                                accept="image/png, image/jpeg, image/bmp"
                                placeholder="Upload Logo"
                                prepend-icon="mdi-camera"
                                v-model="uploadedLogo"
                                :rules="fileRules"
                            ></v-file-input>

                            <v-row class="">
                                <v-col cols="6">
                                    <p>Signup Page Color</p>
                                    <v-color-picker
                                        v-model="details.theme"
                                        dot-size="25"
                                        hide-inputs
                                    ></v-color-picker>
                                </v-col>
                                <v-col cols="6">
                                    <p>Signup Page Logo</p>
                                    <v-img
                                        class="pt-4"
                                        :src="details.logo_location"
                                    />
                                </v-col>
                            </v-row>

                            <div class="text-center">
                                <v-list>
                                    <v-list-item two-line>
                                        <v-list-item-content>
                                            <p>Customer Signup Link</p>
                                            <v-list-item-title>
                                                <a
                                                    target="_blank"
                                                    :href="
                                                        'https://dashboard.textingdiscounts.com/live-signup/' +
                                                        this.url
                                                    "
                                                    >https://dashboard.textingdiscounts.com/live-signup/{{
                                                        this.url
                                                    }}</a
                                                >
                                            </v-list-item-title>
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list>
                                <div>
                                    <v-btn
                                        elevation="2"
                                        :href="/qrcode/ + this.url"
                                        target="_blank"
                                        color="primary"
                                        >View QR</v-btn
                                    >
                                </div>
                            </div>
                        </v-card-text>
                    </v-card>
                </v-tab-item>
            </v-tabs-items>
        </v-card>

        <!-- Coupon Dialog -->
        <v-dialog v-model="newCouponDialog" max-width="500">
            <v-card>
                <v-card-title class="text-h5"> New Coupon 1</v-card-title>

                <v-card-text>
                    <v-form v-model="valid">
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-text-field
                                        v-model="newCoupon.code"
                                        :rules="requiredRules"
                                        :counter="10"
                                        label="Code"
                                        hint="Example #bogo or #freefries"
                                        persistent-hint
                                        required
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field
                                        v-model="newCoupon.description"
                                        :rules="requiredRules"
                                        label="Coupon Description"
                                        required
                                    ></v-text-field>
                                </v-col>

                                <v-row>
                                    <v-col cols="6">
                                        <v-radio-group
                                            v-model="newCoupon.recipientGroup"
                                        >
                                            <template v-slot:label>
                                                <div>Recipients</div>
                                            </template>
                                            <v-radio
                                                label="All"
                                                value="all"
                                            ></v-radio>

                                            <v-radio
                                                label="Group"
                                                value="group"
                                            ></v-radio>

                                            <v-radio
                                                label="Top Percentage"
                                                value="subset"
                                            ></v-radio>
                                        </v-radio-group>
                                    </v-col>
                                    <v-col
                                        cols="12"
                                        v-if="
                                            newCoupon.recipientGroup == 'group'
                                        "
                                    >
                                        <v-col cols="12">
                                            <v-select
                                                v-model="
                                                    newCoupon.selectedRecipientGroupId
                                                "
                                                :items="this.groups"
                                                item-text="name"
                                                item-value="id"
                                                label="Select Group"
                                            ></v-select>
                                        </v-col>
                                    </v-col>

                                    <v-col
                                        cols="12"
                                        v-if="
                                            newCoupon.recipientGroup == 'subset'
                                        "
                                    >
                                        <v-col cols="12">
                                            <v-subheader class="pl-0">
                                                Select percentage of subscribers
                                                (Based on most redeemed coupons)
                                            </v-subheader>
                                        </v-col>

                                        <v-col cols="12" class="pt-8">
                                            <v-slider
                                                v-model="
                                                    newCoupon.selectedRecipientPercentage
                                                "
                                                step="5"
                                                thumb-label="always"
                                            ></v-slider>
                                        </v-col>

                                        <v-col cols="12">
                                            <v-subheader class="pl-0">
                                                Sending to top
                                                {{
                                                    newCoupon.selectedRecipientPercentage
                                                }}% of Subscribers
                                            </v-subheader>
                                        </v-col>
                                    </v-col>
                                </v-row>

                                <v-col cols="12">
                                    <v-dialog
                                        ref="dateDialog"
                                        v-model="dateDialog"
                                        :return-value.sync="newCoupon.date"
                                        persistent
                                        width="290px"
                                    >
                                        <template
                                            v-slot:activator="{ on, attrs }"
                                        >
                                            <v-text-field
                                                v-model="newCoupon.date"
                                                label="Expiry Date"
                                                prepend-icon="mdi-calendar"
                                                readonly
                                                v-bind="attrs"
                                                v-on="on"
                                            ></v-text-field>
                                        </template>
                                        <v-date-picker
                                            v-model="newCoupon.date"
                                            scrollable
                                            :min="newCoupon.date"
                                        >
                                            <v-spacer></v-spacer>
                                            <v-btn
                                                text
                                                color="primary"
                                                @click="dateDialog = false"
                                            >
                                                Cancel
                                            </v-btn>
                                            <v-btn
                                                text
                                                color="primary"
                                                @click="
                                                    $refs.dateDialog.save(
                                                        newCoupon.date
                                                    )
                                                "
                                            >
                                                OK
                                            </v-btn>
                                        </v-date-picker>
                                    </v-dialog>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </v-card-text>

                <div></div>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="red darken-1"
                        text
                        @click="newCouponDialog = false"
                    >
                        close
                    </v-btn>

                    <v-btn
                        outlined
                        color="green darken-1"
                        @click="saveCoupon(newCoupon)"
                    >
                        Save & Send
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- Birthday Coupon -->
        <v-dialog v-model="birthdayCouponDialog" max-width="500">
            <v-card>
                <v-card-title class="text-h5"> Birthday Coupons </v-card-title>
                <v-card-subtitle class="subtitle-1 pt-2">
                    Let your customers celebrate their special day by sending
                    them a coupon on their birthday. <br />(You can enable or
                    disable this feature)
                </v-card-subtitle>

                <v-card-text>
                    <v-form v-model="valid">
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-checkbox
                                        v-model="birthdayCoupon.active"
                                        :label="
                                            birthdayCoupon.active | status_name
                                        "
                                    ></v-checkbox>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        :disabled="!birthdayCoupon.active"
                                        :rules="requiredRules"
                                        v-model="birthdayCoupon.code"
                                        :counter="10"
                                        label="Code"
                                        required
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field
                                        :disabled="!birthdayCoupon.active"
                                        :rules="requiredRules"
                                        v-model="birthdayCoupon.description"
                                        label="Description"
                                        required
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </v-card-text>

                <div></div>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="red darken-1"
                        text
                        @click="birthdayCouponDialog = false"
                    >
                        close
                    </v-btn>

                    <v-btn
                        outlined
                        color="green darken-1"
                        @click="updateStaticCoupon(birthdayCoupon, 3)"
                    >
                        Update
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- New Subber Coupons -->
        <v-dialog v-model="newSubberCouponDialog" max-width="500">
            <v-card>
                <v-card-title class="text-h5">
                    New Customer Coupons
                </v-card-title>
                <v-card-subtitle class="subtitle-1 pt-2">
                    Greet your customers with a welcome coupon when they first
                    subscribe to your coupon list. <br />(You can enable or
                    disable this feature)
                </v-card-subtitle>

                <v-card-text>
                    <v-form v-model="valid">
                        <v-container>
                            <v-row>
                                <v-col cols="12">
                                    <v-checkbox
                                        v-model="newSubberCoupon.active"
                                        :label="
                                            newSubberCoupon.active | status_name
                                        "
                                    ></v-checkbox>
                                </v-col>
                                <v-col cols="12">
                                    <v-text-field
                                        :disabled="!newSubberCoupon.active"
                                        :rules="requiredRules"
                                        v-model="newSubberCoupon.code"
                                        :counter="10"
                                        label="Code"
                                        required
                                    ></v-text-field>
                                </v-col>

                                <v-col cols="12">
                                    <v-text-field
                                        :disabled="!newSubberCoupon.active"
                                        :rules="requiredRules"
                                        v-model="newSubberCoupon.description"
                                        label="Description"
                                        required
                                    ></v-text-field>
                                </v-col>
                            </v-row>
                        </v-container>
                    </v-form>
                </v-card-text>

                <div></div>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="red darken-1"
                        text
                        @click="newSubberCouponDialog = false"
                    >
                        close
                    </v-btn>

                    <v-btn
                        outlined
                        color="green darken-1"
                        @click="updateStaticCoupon(newSubberCoupon, 2)"
                    >
                        Update
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- New Group Dialog -->
        <v-dialog v-model="newGroupDialog" max-width="500">
            <v-card>
                <v-card-title class="text-h5">
                    Create Subscriber Group
                </v-card-title>

                <v-card-text>
                    <v-container fluid>
                        <v-text-field
                            v-model="groupName"
                            label="Group Name"
                        ></v-text-field>

                        <v-virtual-scroll
                            :items="this.subscribers"
                            height="300"
                            item-height="30"
                        >
                            <template v-slot:default="{ item }">
                                <v-checkbox
                                    dense
                                    v-model="selectedGroupUsers"
                                    :label="item.name"
                                    :value="item.id"
                                ></v-checkbox>
                            </template>
                        </v-virtual-scroll>
                    </v-container>
                </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="red darken-1"
                        text
                        @click="
                            (newGroupDialog = false),
                                (selectedGroupUsers = []),
                                (groupName = null)
                        "
                    >
                        close
                    </v-btn>

                    <v-btn
                        outlined
                        color="green darken-1"
                        @click="createGroup()"
                    >
                        Save Group
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- View Groups Dialog -->
        <v-dialog v-model="viewGroupsDialog" max-width="600">
            <v-card>
                <v-card-title class="text-h5"> View Groups </v-card-title>
                <v-card-subtitle> Select group to view </v-card-subtitle>

                <v-row class="ma-2 mx-4">
                    <v-chip-group active-class="primary--text" row>
                        <v-chip
                            v-for="group in this.groups"
                            :key="group.id"
                            @click="getGroup(group.id)"
                        >
                            {{ group.name }}
                        </v-chip>
                    </v-chip-group>
                </v-row>

                <v-card-text v-if="this.foundGroupData.length > 0">
                    <p>{{ this.foundGroupData.length }} members</p>

                    <v-simple-table dense>
                        <thead>
                            <tr>
                                <th class="text-left">Name</th>
                                <th class="text-right">Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in foundGroupData" :key="item.name">
                                <td>{{ item.name }}</td>
                                <td class="text-right">{{ item.phone }}</td>
                            </tr>
                        </tbody>
                    </v-simple-table>
                </v-card-text>

                <v-card-text v-else> No Data </v-card-text>

                <v-card-actions>
                    <v-spacer></v-spacer>

                    <v-btn
                        color="red darken-1"
                        text
                        @click="viewGroupsDialog = false"
                    >
                        close
                    </v-btn>

                    <v-btn
                        color="red darken-1"
                        :disabled="activeGroupId == 0"
                        @click="deleteGroup(activeGroupId)"
                    >
                        Delete Group
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

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
import VueApexCharts from "vue-apexcharts";

export default {
    props: [
        "user",
        "coupons",
        "subscribers",
        "details",
        "subscriber-stats",
        "coupon-stats",
        "redeemed-ratio",
        "saved-birthday-coupon",
        "saved-newuser-coupon",
        "sent-total",
        "current-plan",
        "total-subscribers",
        "monthly-subscribers",
        "url",
        "groups",
        "survey",
        "survey-counts",
    ],
    data() {
        return {
            surveySeries1: [],
            surveyChartOptions1: {
                colors: ["#7C4DFF", "#40C4FF", "#00E676"],
                title: {
                    text: "",
                    align: "left",
                },
                chart: {
                    width: 380,
                    type: "pie",
                },
                labels: [],
                legend: {
                    position: "bottom",
                },
            },
            surveySeries2: [],
            surveyChartOptions2: {
                colors: ["#4e32a8", "#91c230", "#d46ee6"],
                title: {
                    text: "",
                    align: "left",
                },
                chart: {
                    width: 380,
                    type: "pie",
                },
                labels: [],
                legend: {
                    position: "bottom",
                },
            },
            surveySeries3: [],
            surveyChartOptions3: {
                colors: ["#c41d50", "#3dde37", "#34d6d9"],
                title: {
                    text: "",
                    align: "left",
                },
                chart: {
                    width: 380,
                    type: "pie",
                },
                labels: [],
                legend: {
                    position: "bottom",
                },
            },
            activeGroupId: 0,
            foundGroupData: [],
            groupName: "",
            selectedGroupUsers: [],
            newGroupDialog: false,
            viewGroupsDialog: false,
            search: "",
            headers: [
                {
                    text: "Name",
                    align: "start",
                    sortable: true,
                    value: "name",
                },
                { text: "Phone (+1)", value: "phone", sortable: true },
                {
                    text: "Redeemed Counpons",
                    value: "redeemed_count",
                    sortable: true,
                },
            ],
            tab: null,
            valid: false,
            items: ["Overview", "Coupons", "Subscribers", "Settings"],
            newCouponDialog: false,
            newSubberCouponDialog: false,
            birthdayCouponDialog: false,

            overlay: false,
            overlayData: {
                icon: "",
                message: "",
            },
            // Graph 1
            subscriberStatsOptions: {
                colors: ["#ff8503"],
                title: {
                    text: "Subscribers",
                    align: "left",
                },
                chart: {
                    height: 350,
                    type: "line",
                    toolbar: {
                        show: false,
                    },
                },
                series: [
                    {
                        name: "Subscribers",
                        data: [],
                    },
                ],
                xaxis: {
                    categories: [],
                },
            },
            // Graph 2
            smsStatsOptions: {
                series: [],
                colors: ["#7C4DFF", "#40C4FF", "#00E676"],
                title: {
                    text: "SMS Statistics",
                    align: "left",
                },
                chart: {
                    type: "bar",
                    height: 350,
                    stacked: true,
                    toolbar: {
                        show: false,
                    },
                },
                xaxis: {
                    categories: [],
                },
                legend: {
                    position: "bottom",
                },
            },
            // Graph 3
            redeemedStatsOptions: {
                series: [],
                colors: ["#EF5350", "#00E5FF"],
                chart: {
                    type: "bar",
                    height: 350,
                    stacked: true,
                    toolbar: {
                        show: false,
                    },
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                    },
                },
                title: {
                    text: "Redeemed Coupons",
                },
                xaxis: {
                    categories: [],
                },
                yaxis: {
                    title: {
                        text: undefined,
                    },
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val;
                        },
                    },
                },
                fill: {
                    opacity: 1,
                },
                legend: {
                    position: "bottom",
                    horizontalAlign: "left",
                },
            },
            menu: false,
            file: null,
            uploadedLogo: null,
            newData: {
                type: "customer",
                name: "",
                description: "",
                map_url: "",
                theme: "",
                logo: null,
                verification_code: "",
                current_pass: "",
                new_pass: "",
                confirm_new_pass: "",
            },
            imageUrl: "",
            imageFile: null,
            imageName: "",
            logoRules: [
                (v) =>
                    !v ||
                    v.size < 2000000 ||
                    "Logo size should be less than 2 MB!",
            ],
            dateDialog: false,
            timeDialog: false,
            newCoupon: {
                code: "",
                description: "",
                recipientGroup: "all",
                date: new Date(
                    Date.now() - new Date().getTimezoneOffset() * 60000
                )
                    .toISOString()
                    .substr(0, 10),

                time: "23:59",
                selectedRecipientGroupId: "",
                selectedRecipientPercentage: 0,
            },
            birthdayCoupon: {
                active: false,
                coupon_id: "",
                code: "",
                date: null,
                time: null,
                description: "",
            },
            newSubberCoupon: {
                active: false,
                coupon_id: "",
                code: "",
                date: null,
                time: null,
                description: "",
            },
            couponType: 0,
            requiredRules: [(v) => !!v || "This field is is required"],
            fileRules: [
                (value) =>
                    value.size < 5000000 ||
                    "Logo size should be less than 5 MB",
            ],
        };
    },
    created() {
        console.log("tayyab hello");
    },
    computed: {
        usedCouponPercentage() {
            return (
                (parseInt(this.sentTotal) /
                    parseInt(this.currentPlan.max_smses)) *
                100
            ).toFixed(2);
        },
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
                value === this.newData.new_pass || "Passwords do not match";
        },
    },
    filters: {
        american_date_format: function (date) {
            return moment(date).format("MM-DD-YYYY");
        },
        status_name: function (boolean) {
            if (boolean == true) {
                return "Enabled";
            } else {
                return "Disabled";
            }
        },
        created_format: function (date) {
            return moment(date).format("MM-DD-YYYY");
        },
        expiry_format: function (date) {
            var a = moment(date).format("MM-DD-YYYY");
            var result = a;
            return result;
        },
        check_expired: function (date) {
            var now = moment().format("YYYY-MM-DD HH:mm:ss");

            if (now > date) {
                return "red";
            } else {
                return "green";
            }
        },
        check_expired_icon: function (date) {
            var now = moment().format("YYYY-MM-DD HH:mm:ss");

            if (now > date) {
                return "mdi-lock";
            } else {
                return "mdi-clock";
            }
        },
    },
    mounted() {
        console.log(this.surveyCounts);
        this.checkStaticCoupons();
        this.loadGraphData();

        // Set colour picker colour
        // newData.theme = this.details.theme;
    },
    methods: {
        loadGraphData() {
            console.log("load graph data");
            console.log("g4");

            var surveyGraphs = [];

            console.log(this.surveyCounts);
            // this.surveyCounts.count.forEach((str) => {
            //     g4.push(parseInt(str));
            // });

            // console.log(g4);
            // this.surveySeries = g4;
            // this.surveyChartOptions.labels = this.surveyCounts.type;
            for (let i = 0; i < this.surveyCounts.questions.length; i++) {
                // console.log(surveyGraphs.questions[i]);
                // this.surveyChartOptions.labels.push(
                //     this.surveyCounts.questions[i].question
                // );
                var g = {};
                g.title = this.surveyCounts.questions[i].question;
                g.count = this.surveyCounts.questions[i].options.count;
                g.option = this.surveyCounts.questions[i].options.option;

                surveyGraphs.push(g);
            }

            console.log("final arr");
            console.log(surveyGraphs);

            this.surveySeries1 = surveyGraphs[0].count.map(Number);
            this.surveyChartOptions1.labels = surveyGraphs[0].option;
            this.surveyChartOptions1.title.text = surveyGraphs[0].title;

            this.surveySeries2 = surveyGraphs[1].count.map(Number);
            this.surveyChartOptions2.labels = surveyGraphs[1].option;
            this.surveyChartOptions2.title.text = surveyGraphs[1].title;

            this.surveySeries3 = surveyGraphs[2].count.map(Number);
            this.surveyChartOptions3.labels = surveyGraphs[2].option;
            this.surveyChartOptions3.title.text = surveyGraphs[2].title;

            console.log("g1");
            console.log(this.subscriberStats.count);
            this.subscriberStatsOptions.series[0].data =
                this.subscriberStats.count;
            this.subscriberStatsOptions.xaxis.categories =
                this.subscriberStats.date;

            console.log("g2");
            console.log(this.couponStats.stats);

            var g2 = this.couponStats.stats.map((obj) => ({
                ...obj,
                data: obj.data.map(Number),
            }));

            this.smsStatsOptions.series = g2;
            this.smsStatsOptions.xaxis.categories = this.couponStats.coupons;

            console.log("g2 after");
            console.log(g2);

            console.log("g3");
            console.log(this.redeemedRatio.stats);

            this.redeemedStatsOptions.series = this.redeemedRatio.stats;
            this.redeemedStatsOptions.xaxis.categories =
                this.redeemedRatio.coupons;
        },
        // onChange(e) {
        //     this.uploadedLogo = e.target.files[0];
        //     console.log(this.uploadedLogo);
        // },
        updateStaticCoupon(coupon, type) {
            // Update coupon if it exists, if not then create it
            this.overlay = true;
            this.overlayData.loading = true;
            this.overlayData.message = "";

            console.log(coupon);
            axios
                .post("/update-static-coupons", {
                    active: coupon.active,
                    coupon_id: coupon.coupon_id,
                    code: coupon.code,
                    description: coupon.description,
                    expiry_date: coupon.date,
                    expiry_time: coupon.time,
                    type: type,
                })
                .then((response) => {
                    this.newSubberCouponDialog = false;
                    this.birthdayCouponDialog = false;
                    if (response.data.message == "Success") {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Update Successful!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
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
        checkStaticCoupons() {
            // Set birthday coupon values if exists
            if (Object.keys(this.savedBirthdayCoupon).length > 0) {
                this.birthdayCoupon.active = true;
                this.birthdayCoupon.coupon_id = this.savedBirthdayCoupon[0].id;
                this.birthdayCoupon.code = this.savedBirthdayCoupon[0].code;
                this.birthdayCoupon.description =
                    this.savedBirthdayCoupon[0].description;
            }
            // Set newuser coupon values if exists
            if (Object.keys(this.savedNewuserCoupon).length > 0) {
                this.newSubberCoupon.active = true;
                this.newSubberCoupon.coupon_id = this.savedNewuserCoupon[0].id;
                this.newSubberCoupon.code = this.savedNewuserCoupon[0].code;
                this.newSubberCoupon.description =
                    this.savedNewuserCoupon[0].description;
            }
        },
        saveCoupon(coupon) {
            this.overlay = true;
            this.overlayData.icon = "";
            this.overlayData.loading = true;

            this.newCouponDialog = false;

            axios
                .post("/create-coupon", {
                    code: coupon.code,
                    description: coupon.description,
                    recipient_group: coupon.recipientGroup,
                    selected_recipient_group_id:
                        coupon.selectedRecipientGroupId,
                    selected_recipient_percentage:
                        coupon.selectedRecipientPercentage,
                    expiry_date: coupon.date,
                    expiry_time: coupon.time,
                    type: 1,
                })
                .then((response) => {
                    this.newCouponDialog = false;
                    this.birthdayCouponDialog = false;
                    this.newSubberCouponDialog = false;

                    if (response.data.message == "Success") {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Update Successful!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
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
        updateDetails() {
            this.overlay = true;
            this.overlayData.loading = true;
            this.overlayData.message = "";

            this.newData.theme = this.details.theme;

            console.log(this.uploadedLogo);

            var formData = new FormData();
            formData.append("file", this.uploadedLogo);
            formData.append("data", JSON.stringify(this.newData));

            console.log(formData);

            const config = {
                headers: { "Content-Type": "multipart/form-data" },
            };

            axios
                .post("/update-settings", formData)
                .then((response) => {
                    if (response.data.message == "Success") {
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Update Successful!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
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
        createGroup() {
            this.overlay = true;
            this.overlayData.loading = true;
            this.overlayData.message = "";

            this.newGroupDialog = false;

            axios
                .post("/create-group", {
                    name: this.groupName,
                    group_array: this.selectedGroupUsers,
                })
                .then((response) => {
                    if (response.data.message == "Success") {
                        this.newGroupDialog = false;
                        this.selectedGroupUsers = [];
                        this.groupName = null;

                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Update Successful!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
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

        getGroup(id) {
            this.activeGroupId = id;

            console.log("id");
            console.log(id);
            console.log("active group id");
            console.log(this.activeGroupId);

            axios
                .get("/get-group/" + id)
                .then((response) => {
                    if (response.data.message == "Success") {
                        console.log("response");
                        console.log(response);
                        // this.viewGroupsDialog = false;

                        console.log("response data");
                        console.log(response.data);

                        console.log("response data in int");

                        var r = [];
                        response.data.data.forEach((str) => {
                            r.push(parseInt(str));
                        });

                        console.log(r);

                        const filteredArray = this.subscribers.filter((obj) =>
                            r.includes(obj.id)
                        );

                        console.log("final");
                        console.log(filteredArray);
                        this.foundGroupData = filteredArray;

                        setTimeout(() => {
                            this.overlay = false;
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

        deleteGroup(id) {
            console.log("deleting " + id);
            this.overlay = true;
            this.overlayData.loading = true;
            this.overlayData.message = "";

            axios
                .get("/delete-group/" + id)
                .then((response) => {
                    if (response.data.message == "Success") {
                        this.viewGroupsDialog = false;
                        this.overlayData.icon = "mdi-check-circle";
                        this.overlayData.message = "Delete Successful!";
                        this.overlayData.loading = false;

                        setTimeout(() => {
                            this.overlay = false;
                            window.location.reload();
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
