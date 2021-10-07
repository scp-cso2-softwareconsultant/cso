<template>
    <v-card>
        <v-dialog v-model="dialog" width="700" class="card p-md-5 pd-5">
            <template v-slot:activator="{ on, attrs }">
                <v-btn class="ma-2" color="red lighten-2" dark block v-bind="attrs" v-on="on">View History</v-btn>
            </template>
            <v-card>
                <div class="card-body">
                    <center>
                        <v-combobox class="d-inline-block" hide-selected small-chips v-on:change="changeHistoryValue()"
                            v-model="date_value" :items="date_selection" label="PTD History List"></v-combobox>
                    </center>
                </div>
                <v-card class="ma-1">
                    <v-list-item>
                        <v-list-item-content>
                            <div class="overline text-left">
                                Start Date :
                                <strong>{{ editedItem.startDate }}</strong>
                            </div>
                            <div class="overline text-left">
                                Current Date :
                                <strong>{{ editedItem.curDate }}</strong>
                            </div>
                            <div class="overline text-left">
                                Days Completed :
                                <strong>{{ editedItem.daysCompleted }}</strong>
                            </div>
                            <div class="overline text-left">
                                Days Left :
                                <strong>{{ editedItem.daysLeft }}</strong>
                            </div>
                            <div class="overline text-left">
                                Days Completed:
                                <strong>{{ editedItem. daysCompleted }}</strong>
                            </div>
                            <div class="overline text-left">
                                Spent To Date:
                                <strong>{{ editedItem.spent_to_date }}</strong>
                            </div>
                            <div class="overline text-left">
                                Days Left :
                                <strong>{{ editedItem.daysLeft }}</strong>
                            </div>
                            <div class="overline text-left">
                                Percent Complete:
                                <strong>{{ editedItem.percentComplete }} %</strong>
                            </div>
                            <div class="overline text-left">
                                Burnrate :
                                <strong>{{ editedItem.burnRate}}</strong>
                            </div>
                            <div class="overline text-left">
                                Remaining :
                                <strong>{{ editedItem.remaining }}</strong>
                            </div>
                        </v-list-item-content>
                    </v-list-item>
                </v-card>
                <div class="card p-md-5">
                    <h4 class="subheading card-text">Project Tracking Document</h4>
                    <div class="card-body">
                        <p class="card-text">
                            <apexchart type="bar" height="380" :options="projectTrackingDocumentChartOptions"
                                :series="projectTrackingDocumentSeries"></apexchart>
                        </p>
                    </div>
                </div>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary" text @click="dialog = false">Back</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-card>
</template>

<script>
    export default {
        data() {
            return {
                dialog: false,
                date_selection: [],
                date_value: 0,
                editedItemList: {},
                editedItem: {
                    burnRate: "",
                    startDate: "",
                    curDate: "",
                    endDate: "",
                    daysCompleted: 0,
                    spent_to_date: 0,
                    daysLeft: 0,
                    percentComplete: 0,
                    remaining: 0,
                    totalBudget: 0,
                    objective_1: 0,
                    objective_2: 0,
                    objective_3: 0,
                },
                projectTrackingDocumentSeries: [{
                    data: [0, 0, 0, 0, 0, 0],
                }, ],
                projectTrackingDocumentChartOptions: {
                    chart: {
                        type: "bar",
                        height: 380,
                    },
                    plotOptions: {
                        bar: {
                            barHeight: "100%",
                            distributed: true,
                            horizontal: true,
                            borderRadius: 15,
                            padding: 10,
                            dataLabels: {
                                position: "bottom",
                            },
                            startingShape: "rounded",
                            endingShape: "rounded",
                        },
                    },
                    colors: [
                        "#FFA203",
                        "#FE5F02",
                        "#F90E1E",
                        "#CB0033",
                        "#704F8D",
                        "#CB0033",
                        "#BE3F2E",
                        "#F47043",
                        "#B15C86",
                        "#D98790",
                    ],
                    dataLabels: {
                        enabled: true,
                        textAnchor: "start",
                        style: {
                            colors: ["#fff"],
                        },
                        formatter: function (val, opt) {
                            return opt.w.globals.labels[opt.dataPointIndex] + ":  " + val;
                        },
                        offsetX: 0,
                        background: {
                            enabled: true,
                            foreColor: "#000",
                            padding: 4,
                            borderRadius: 4,
                            borderWidth: 1,
                            borderColor: "#704F8D", //BACK
                            opacity: 0.5,
                            dropShadow: {
                                enabled: false,
                                top: 1,
                                left: 1,
                                blur: 1,
                                color: "#000",
                                opacity: 0.45,
                            },
                        },
                        dropShadow: {
                            enabled: false,
                            top: 1,
                            left: 1,
                            blur: 1,
                            color: "#000",
                            opacity: 0.45,
                        },
                    },
                    stroke: {
                        width: 1,
                        colors: ["#fff"],
                    },
                    xaxis: {
                        min: 0,
                        max: 100,
                        categories: [
                            "Progress bar of days completed",
                            "Progress bar of burn rate",
                            "Progress bar for Objective 1",
                            "Progress bar for Objective 2",
                            "Progress bar for Objective 3",
                        ],
                    },
                    yaxis: {
                        labels: {
                            show: false,
                        },
                    },
                    tooltip: {
                        theme: "dark",
                        x: {
                            show: false,
                        },
                        y: {
                            title: {
                                formatter: function () {
                                    return "";
                                },
                            },
                        },
                    },
                },
            };
        },
        created() {
            this.initialize();
        },

        methods: {
            initialize() {
                axios.get("/get-project-tracking-document-history").then((response) => {
                    const data = response.data;
                    var date_selection = [];
                    var editedItemList = {};

                    for (const index in data) {
                        const value = data[index].id;
                        const text = "# " + data[index].id + " - " + data[index].created_at;
                        date_selection.push({
                            value,
                            text
                        });
                        editedItemList[value] = data[index];
                    }
                    this.date_selection = date_selection;
                    this.editedItemList = editedItemList;

                    this.editedItem = data[0];
                    const selected_latest = date_selection[data[0].id];

                    this.projectTrackingDocumentSeries = [{
                        data: [
                            this.editedItem.percentComplete,
                            this.editedItem.burnRate,
                            this.editedItem.objective_1,
                            this.editedItem.objective_2,
                            this.editedItem.objective_3,
                        ],
                    }, ];
                });
            },
            changeHistoryValue() {
                const size = Object.keys(this.editedItemList).length;
                if (size > 0) {
                    const editedItem = this.editedItemList[this.date_value.value];
                    if (editedItem) {
                        this.editedItem = editedItem;
                        this.projectTrackingDocumentSeries = [{
                            data: [
                                this.editedItem.percentComplete,
                                this.editedItem.burnRate,
                                this.editedItem.objective_1,
                                this.editedItem.objective_2,
                                this.editedItem.objective_3,
                            ],
                        }, ];
                    }
                }
            },
        },
    };

</script>
