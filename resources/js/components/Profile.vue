<template>
    <v-card color="basil">
        <v-tabs v-model="tab" background-color="transparent" color="basil" grow>
            <v-tab v-for="item in items" :key="item">
                {{ item }}
            </v-tab>
        </v-tabs>

        <v-tabs-items v-model="tab">
            <v-tab-item key="Profile">
                <v-card color="basil" flat>
                    <v-card-text>
                        <div>
                            <h5>Your Details</h5>
                            <h6>Name: {{ this.user.name }}</h6>
                            <h6>Phone: (+1) {{ this.user.phone }}</h6>
                        </div>
                    </v-card-text>
                </v-card>
            </v-tab-item>
            <v-tab-item v-if="this.isCustomer" key="Company Details">
                <v-card color="basil" flat>
                    <v-card-text>
                        <div>
                            <h5>Your Details</h5>
                            <h6>Name: {{ this.customer.name }}</h6>
                            <h6>Phone: (+1) {{ this.customer.phone }}</h6>
                        </div>
                    </v-card-text>
                </v-card>
            </v-tab-item>
        </v-tabs-items>
    </v-card>
</template>

<script>
export default {
    props: ["user", "customer"],
    data() {
        return {
            tab: null,
            items: ["Profile"],
            isCustomer: false,
        };
    },
    mounted() {
        console.log(this.customer);
        console.log(this.user.roles[0].name);
        if (
            this.user.roles[0].id == 2 &&
            this.user.roles[0].name == "Customer"
        ) {
            this.isCustomer = true;
            this.items.push("Company Details");
        }
    },
};
</script>
