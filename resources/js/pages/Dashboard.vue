<template>
  <v-app>
    <h3 class="subheading grey--text">Dashboard</h3>
    <!-- CSO INDICATOR PIE -->
    <div class="card p-md-5">
      <h4 class="subheading card-text">CSO² Project Indicators</h4>
      <h1 class="pt-4 card-text text-center"></h1>
      <div class="card-body">
        <!-- <center>
          <v-combobox
            class="d-inline-block p-3"
            hide-selected
            small-chips
            v-on:change="updateCSOIndicatorsChart()"
            v-model="selectedOrganization"
            :items="responsibleOrganization"
            label="Responsible Organization"
          ></v-combobox>
        </center> -->
        <PieChart :D="pieData" />
      </div>
    </div>
    <!-- CSO NETWORK DOUGHNUT-->
    <div class="card m-0 p-md-5">
      <h4 class="subheading card-text">CSO and CSO Network Members Profile</h4>
      <div class="card">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Types of Organization</h5>
            <DoughnutChart :D="doughData" />
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Top 3 Accreditation Bodies</h5>
          <div class="row mb-5">
            <div class="col-lg-4 col-sm-2">
              <div class="card-box shadow rounded bg-red">
                <div class="inner">
                  <h3>
                    {{
                      CSOProfileAccreditation.accreditedMapping[0].percentage
                    }}
                    %
                  </h3>
                  <h5>
                    {{ CSOProfileAccreditation.accreditedMapping[0].tos }}
                  </h5>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <a href="#" class="card-box-footer">
                  <i class="fa fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
            <div class="col-lg-4 col-sm-6">
              <div class="card-box shadow rounded bg-orange">
                <div class="inner">
                  <h3>
                    {{
                      CSOProfileAccreditation.accreditedMapping[1].percentage
                    }}
                    %
                  </h3>
                  <h5>
                    {{ CSOProfileAccreditation.accreditedMapping[1].tos }}
                  </h5>
                </div>
                <div class="icon">
                  <i class="fa fa-user-plus" aria-hidden="true"> </i>
                </div>
                <a href="#" class="card-box-footer"
                  ><i class="fa fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>

            <div class="col-lg-4 col-sm-6">
              <div class="card-box shadow rounded bg-green">
                <div class="inner">
                  <h3>
                    {{
                      CSOProfileAccreditation.accreditedMapping[2].percentage
                    }}
                    %
                  </h3>
                  <h5>
                    {{ CSOProfileAccreditation.accreditedMapping[2].tos }}
                  </h5>
                </div>
                <div class="icon">
                  <i class="fa fa-money" aria-hidden="true"></i>
                </div>
                <a href="#" class="card-box-footer"
                  ><i class="fa fa-arrow-circle-right"></i
                ></a>
              </div>
            </div>
          </div>
          <template>
            <v-card tile>
              <v-list rounded>
                <v-list-item-group
                  v-model="CSOProfileAccreditation.SELECTED"
                  active-class="pink--text"
                  multiple
                >
                  <v-list-item
                    v-for="(
                      item, index
                    ) in CSOProfileAccreditation.accreditationMapping.slice(
                      0,
                      3
                    )"
                    :key="index"
                  >
                    <v-list-item-content>
                      <v-list-item-title v-text="item.accr"></v-list-item-title>
                    </v-list-item-content>
                    <v-list-item-content>
                      <v-list-item-title
                        >{{ item.percentage }} %</v-list-item-title
                      >
                    </v-list-item-content>
                  </v-list-item>
                </v-list-item-group>
              </v-list>
            </v-card>
          </template>
        </div>
      </div>
      <v-flex>
        <v-card class="ma-1">
          <v-list-item>
            <v-list-item-content>
              <h5 class="card-title">Primary Stakeholders</h5>
              <div class="text-center">
                <BarChart :D="barData" />
              </div>
            </v-list-item-content>
          </v-list-item>
        </v-card>
      </v-flex>
    </div>
    <!-- ASSESSMENT -->
    <div class="card p-md-5">
      <h4 class="subheading card-text">Assessment</h4>
      <div class="card-body">
        <RadarChart :D="radarData" />
      </div>
    </div>
    <!-- FINCANCE TRACKER-->
    <div class="card p-md-5">
      <h4 class="subheading card-text">Finance Tracker</h4>
      <v-flex>
        <v-card class="ma-1 m-3">
          <v-row class="mt-0">
            <v-col class="d-flex" cols="12" sm="12" md="12">
              <v-select
                chips
                :items="financeYears"
                v-model="selectedFinanceYear"
                @change="financeTracker"
                label="Select Year"
                class="m-2"
              ></v-select>
              <v-select
                chips
                :items="financeMonths"
                v-model="selectedFinanceMonth"
                @change="financeTracker"
                label="Select Month"
                class="m-2"
              ></v-select>
            </v-col>
          </v-row>
        </v-card>
        <div class="text-center mt-5 pt-2">
          <MultiBar :D="financeBarData" />
        </div>
      </v-flex>
      <v-flex>
        <v-card class="ma-1">
          <v-list-item>
            <v-list-item-content>
              <h5 class="card-title">Burn Rate</h5>
              <div class="text-center">
                <apexchart
                  type="bar"
                  height="350"
                  :options="burnRateChartOptions"
                  :series="burnRateSeries"
                ></apexchart>
              </div>
            </v-list-item-content>
          </v-list-item>
        </v-card>
      </v-flex>
    </div>
    <div class="card p-md-5">
      <h4 class="subheading card-text">Project Tracking Document</h4>
      <div class="card-body">
        <p class="card-text">
          <apexchart
            type="bar"
            height="380"
            :options="projectTrackingDocumentChartOptions"
            :series="projectTrackingDocumentSeries"
          ></apexchart>
        </p>
      </div>
    </div>
  </v-app>
</template>


<script>
// @ is an alias to /src
import VueApexCharts from "vue-apexcharts";

import * as echarts from "echarts";
import PieChart from "../components/dashboard_charts/pie_chart.vue";
import DoughnutChart from "../components/dashboard_charts/doughnut_chart.vue";
import BarChart from "../components/dashboard_charts/barchart.vue";
import RadarChart from "../components/dashboard_charts/radarchart.vue";
import MultiBar from "../components/dashboard_charts/multi_bar.vue";

export default {
  components: {
    apexchart: VueApexCharts,
    PieChart,
    DoughnutChart,
    BarChart,
    RadarChart,
    MultiBar,
  },
  data: () => ({
    //responsibleOrganization: [], // Lead Organizations
    //selectedOrganization: "",

    /*ECHART1
            pieData: {
                title: {
                    text: "No Selected Organization",
                    left: "center",
                },
                legend: {
                    top: "bottom",
                },
                toolbox: {
                    show: true,
                    feature: {
                        mark: {
                            show: true
                        },
                        dataView: {
                            show: true,
                            readOnly: true
                        },
                        //restore: { show: true },
                        saveAsImage: {
                            show: true,
                        },
                    },
                },
                tooltip: {
                    trigger: "item",
                    backgroundColor: "#1c84cc",
                    borderColor: "#8C8D8E",
                    borderRadius: 10,
                    padding: 15,
                    textStyle: {
                        color: "#fff",
                    },
                },
                aria: {
                    enabled: true,
                    decal: {
                        show: true,
                    },
                },
                color: ["#ff9800", "#2196f3", "#4caf50", "#f44336", "#9e9e9e"],
                label: {
                    formatter: "{label|{b}} {label|:} {label|{c}}  {per|{d}%}",
                    backgroundColor: "#1c84cc",
                    borderRadius: 4,
                    padding: 8,
                    rich: {
                        label: {
                            color: "#fff",
                        },
                        per: {
                            color: "#fff",
                            backgroundColor: "#4C5058",
                            padding: [3, 4],
                            borderRadius: 4,
                        },
                    },
                },
                series: [{
                    name: "Status",
                    type: "pie",
                    radius: [35, 170],
                    center: ["50%", "50%"],
                    roseType: "area",
                    itemStyle: {
                        borderRadius: 8,
                    },
                    data: [],
                }, ],
            } removed due to change request to bargraph*/
    pieData: {
      title: {
        text: "Activity Status",
        left: "0",
      },
      tooltip: {
        trigger: "axis",
        axisPointer: {
          type: "shadow",
        },
      },
      legend: {
        data: [],
      },
      aria: {
        enabled: true,
        decal: {
          show: true,
        },
      },
      color: [],
      toolbox: {
        show: true,
        orient: "vertical",
        left: "right",
        top: "center",
        feature: {
          mark: { show: true },
          //dataView: { show: true, readOnly: false },
          magicType: { show: true, type: ["line", "bar", "stack"] },
          //restore: { show: true },
          saveAsImage: { show: true },
        },
      },
      xAxis: [
        {
          type: "category",
          axisTick: { show: false },
          data: [""],
        },
      ],
      yAxis: [
        {
          type: "value",
        },
      ],
      series: [],
    },

    //DOUGHNUT
    doughData: {
      title: {
        text: "Types Of Organization",
        left: "center",
      },
      toolbox: {
        show: true,
        feature: {
          mark: {
            show: true,
          },
          dataView: {
            show: true,
            readOnly: true,
          },
          //restore: { show: true },
          saveAsImage: {
            show: true,
          },
        },
      },
      tooltip: {
        trigger: "item",
      },
      legend: {
        orient: "horizontal",
        right: "15%",
        bottom: 1,
        left: "center",
      },
      aria: {
        enabled: true,
        decal: {
          show: true,
        },
      },
      label: {
        //formatter: "{a|{a}}{abg|}\n{hr|}\n  {b|{b}：}{val|{c}}  {per|{d}%}  ",
        formatter: " {b|{b}：}{val|{c}}  {per|{d}%} ",
        backgroundColor: "#37385c",
        borderColor: "#8C8D8E",
        borderRadius: 10,
        padding: 5,
        shadowColor: "rgba(0, 0, 0, 0.5)",
        shadowBlur: 10,
        rich: {
          a: {
            color: "#ffffff",
            lineHeight: 22,
            align: "center",
            padding: 40,
          },
          hr: {
            borderColor: "#8C8D8E",
            width: "100%",
            borderWidth: 1,
            height: 0,
          },
          b: {
            color: "#ffffff",
            fontSize: 13,
            fontWeight: "bold",
            lineHeight: 33,
          },
          val: {
            color: "#ffffff",
            fontSize: 14,
            fontWeight: "bold",
            lineHeight: 33,
          },
          per: {
            color: "#ffffff",
            backgroundColor: "#111121",
            padding: [5, 8],
            borderRadius: 4,
          },
        },
      },
      series: [
        {
          name: "Type Of Organization",
          type: "pie",
          radius: ["30%", "60%"],
          center: ["50%", "50%"],
          avoidLabelOverlap: false,
          itemStyle: {
            borderRadius: 20,
            borderColor: "#fff",
            borderWidth: 2,
          },
          emphasis: {
            label: {
              show: true,
              //fontSize: "25",
              fontWeight: "bold",
            },
          },
          data: [],
        },
      ],
    },
    //Top Accreditation
    CSOProfileAccreditation: {
      AccreditedBodies: [],
      accreditedMapping: [
        {
          count: 0,
          tos: "local policy makers",
        },
        {
          count: 0,
          tos: "private sector support organizations and CSRs",
        },
        {
          count: 0,
          tos: "peer CSOs or related networks",
        },
        {
          count: 0,
          tos: "larger CSOs/CSO Network in Manila, Cebu or Davao",
        },
        {
          count: 0,
          tos: "local researchers and scholars",
        },
        {
          count: 0,
          tos: "potential donors",
        },
      ],
      accreditationMapping: [],
      SELECTED: [0, 1, 2],
    },
    //BARCHART For Primary StakeHolders
    barData: {
      title: {
        text: "Primary Stakeholders",
        left: "center",
      },
      aria: {
        enabled: true,
        decal: {
          show: true,
        },
      },
      toolbox: {
        show: true,
        feature: {
          mark: {
            show: true,
          },
          saveAsImage: {
            show: true,
          },
        },
      },
      tooltip: {
        trigger: "axis",
        formatter: "{b}",
        borderColor: "#8C8D8E",
        axisPointer: {
          // Use axis to trigger tooltip
          type: "shadow",
        },
      },
      legend: {
        show: false,
      },
      grid: {
        left: "3%",
        right: "4%",
        bottom: "3%",
        containLabel: true,
      },
      xAxis: {
        type: "value",
        max: 100,
      },
      yAxis: {
        type: "category",
        data: [
          "Local Policy Makers",
          "private sector support organizations and CSRs",
          "peer CSOs or related networks",
          "larger CSOs/CSO Network in Manila, Cebu or Davao",
          "local researchers and scholars",
          "potential donors",
        ],
      },
      series: [
        {
          name: "Direct",
          type: "bar",
          stack: "total",
          // label: {
          //   formatter: "{label_white|{c}}%",
          //   show: true,
          //   rich: {
          //     label_white: {
          //       color: "#fff",
          //     },
          //   },
          // },
          itemStyle: {
            borderRadius: 6,
            color: new echarts.graphic.LinearGradient(1, 0, 0, 1, [
              {
                offset: 0.5,
                color: "#824f7e",
              },
              {
                offset: 1,
                color: "#824f7e",
              },
              {
                offset: 0,
                color: "#5c3759",
              },
            ]),
          },
          emphasis: {
            focus: "series",
          },
          data: [],
        },
      ],
    },
    //radar/spyder chart
    radarData: {
      title: {
        text: "OPI(Left) | OCAT(right)",
        left: "center",
      },
      toolbox: {
        show: true,
        feature: {
          mark: {
            show: true,
          },
          dataView: {
            show: true,
            readOnly: true,
          },
          //restore: { show: true },
          saveAsImage: {
            show: true,
          },
        },
      },
      legend: {
        data: [],
        bottom: 1,
      },
      radar: [],
      tooltip: {
        trigger: "item",
        backgroundColor: "#e0465f",
        borderColor: "#8C8D8E",
        borderRadius: 10,
        padding: 15,
        textStyle: {
          color: "#fff",
        },
      },
      series: [
        // {
        //   name: "TR = TotalRating per domain per year\nN = Number of a Domain per year\nComputation: TR / N = Domain Point in Radar Chart\n\nExample:\n\tYear 2022:\n\tdomain\trating\t\t\tComputation:\n\tsub1\t5\t\t\tsub1 N = 3\t\t\tTotal RatingOfSub1 = 15\n\tsub1\t4\t\t\tsub2 N = 2\t\t\tTotal RatingOfSub2 = 9\n\tsub1\t6\t\t\tsub3 N = 3\t\t\tTotal RatingOfSub3 = 3\n\tsub2\t5\n\tsub2\t4\t\t\tforSub1 = 15/3 = 5\n\tsub3\t1\t\t\tforSub2 = 9/2 = 4.5\n\tsub3\t1\t\t\tforSub3 = 3/3 = 1\n\tsub3\t1\t\t\tThe result would be 3 points toward sub1 sub2 sub3 indicator\n\n\n***DATA BELOW IS THE REAL COMPUTED DATA OF THE RADAR CHART BASED ON DOMAIN OF LRO ASSESSMENT PER DATE & PER DOMAIN***\n\n\n",
        //   type: "radar",
        //   data: [],
        // },
      ],
    },
    //financeBar
    financeYears: [],
    selectedFinanceYear: [],
    financeMonths: [],
    selectedFinanceMonth: [],
    financeBarData: {
      title: {
        text: "Fund Received vs Actual Expenditures as of --",
      },
      tooltip: {
        trigger: "axis",
        axisPointer: {
          type: "shadow",
        },
      },
      legend: {
        bottom: "1",
        data: ["Actual Expendature", "Funds Received", "Burn Rate"],
      },
      grid: {
        left: 100,
      },
      toolbox: {
        show: true,
        feature: {
          saveAsImage: {},
        },
      },
      aria: {
        enabled: true,
        decal: {
          show: true,
        },
      },
      xAxis: {
        type: "value",
        axisLabel: {
          //formatter: '{value}'
        },
      },
      yAxis: {
        type: "category",
        inverse: true,
        data: [],
        axisLabel: {
          formatter: function (value) {
            return value;
          },
        },
      },
      series: [
        {
          name: "Actual Expendature",
          type: "bar",
          label: {
            show: true,
            textStyle: {
              color: "white",
              fontSize: "10",
              fontWeight: "bold",
            },
          },
          itemStyle: {
            borderRadius: 2,
            color: new echarts.graphic.LinearGradient(1, 0, 0, 1, [
              {
                offset: 1,
                color: "#98182E",
              },
              {
                offset: 0.5,
                color: "#F52E00",
              },
              {
                offset: 0,
                color: "#FE7701",
              },
            ]),
          },
          data: [],
        },
        {
          name: "Funds Received",
          type: "bar",
          itemStyle: {
            color: "#5797ff",
          },
          label: {
            show: true,
            textStyle: {
              color: "white",
              fontSize: "10",
              fontWeight: "bold",
            },
          },
          itemStyle: {
            borderRadius: 2,
            color: new echarts.graphic.LinearGradient(1, 0, 0, 1, [
              {
                offset: 1,
                color: "#1e2f97",
              },
              {
                offset: 0.5,
                color: "#797ef6",
              },
              {
                offset: 0,
                color: "#1aa7ec",
              },
            ]),
          },
          data: [],
        },
      ],
    },

    financeTrackerBudgetSeries: [
      {
        name: "Approved Budget",
        type: "column",
        data: [1.4, 2, 2.5, 1.5, 2.5, 2.8, 3.8, 4.6],
      },
      {
        name: "Actual Expenditure",
        type: "column",
        data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5],
      },
      {
        name: "Budget Remaining",
        type: "column",
        data: [1.1, 3, 3.1, 4, 4.1, 4.9, 6.5, 8.5],
      },
      {
        name: "Burn rate",
        type: "line",
        data: [20, 29, 37, 36, 44, 45, 50, 58],
      },
    ],

    financeTrackerBudgetChartOptions: {
      chart: {
        height: 350,
        type: "line",
        stacked: false,
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        width: [1, 1, 4],
      },
      title: {
        text: "Budget vs Actual Expenditures",
        align: "center",
        offsetX: 110,
      },
      xaxis: {
        categories: [1, 2, 3, 4, 5, 6, 7, 8],
      },
      yaxis: [
        {
          axisTicks: {
            show: true,
          },
          axisBorder: {
            show: true,
            color: "#008FFB",
          },
          labels: {
            style: {
              colors: "#008FFB",
            },
          },
          title: {
            text: "Budget",
            style: {
              color: "#008FFB",
            },
          },
          tooltip: {
            enabled: true,
          },
        },
        {
          seriesName: "Revenue",
          opposite: true,
          axisTicks: {
            show: true,
          },
          axisBorder: {
            show: true,
            color: "#FEB019",
          },
          labels: {
            style: {
              colors: "#FEB019",
            },
          },
          title: {
            text: "Revenue (thousand crores)",
            style: {
              color: "#FEB019",
            },
          },
        },
      ],
      tooltip: {
        fixed: {
          enabled: true,
          position: "topLeft", // topRight, topLeft, bottomRight, bottomLeft
          offsetY: 30,
          offsetX: 60,
        },
      },
      legend: {
        horizontalAlign: "left",
        offsetX: 40,
      },
    },

    burnRateSeries: [
      {
        name: "Burn Rate (1st Liq)",
        data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
      },
      {
        name: "Burn Rate (2st Liq)",
        data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
      },
      {
        name: "Burn Rate (3st Liq)",
        data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
      },
    ],
    burnRateChartOptions: {
      chart: {
        type: "bar",
        height: 350,
      },
      plotOptions: {
        bar: {
          horizontal: false,
          columnWidth: "55%",
          endingShape: "rounded",
        },
      },
      dataLabels: {
        enabled: false,
      },
      stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
      },
      xaxis: {
        categories: ["AHA!BD", "PICPA", "AteneoCORD"],
      },
      yaxis: {
        title: {
          text: "$ (thousands)",
        },
      },
      fill: {
        opacity: 1,
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return "$ " + val + " thousands";
          },
        },
      },
    },
    projectTrackingDocumentSeries: [
      {
        data: [0, 0, 0, 0, 0, 0],
      },
    ],
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
  }),
  methods: {
    async initialize() {
      document.title = "SCP: CSO² Project | Dashboard";
      this.updateCSOIndicatorsChart();
      this.updateCSOProfileChart();
      await this.initTop3();
      await this.initPrimaryBar();
      await this.assessment();
      await this.financeTracker();
      this.burnRate();
      this.ProjectTrackingDocument();

      //   axios.get("/get-lead-organization").then((res) => {
      //     this.responsibleOrganization = res.data;
      //   });
    },

    //FOR CSO2 INDICATOR PIE CHART
    async updateCSOIndicatorsChart() {
      let RAWDATA = await this.req("/dashboard-cso-activity-count", {});
      let colors =  ["#ff9800", "#2196f3", "#f44336", "#4caf50","#9e9e9e"];
      RAWDATA.forEach((data, i) => {
        var colP = -1;
        if(data.status === "Not Yet Started") colP = 0
        else if(data.status === "In Progress") colP = 1
        else if(data.status === "Delayed") colP = 2
        else if(data.status === "Completed") colP = 3
        else if(data.status === "Cancelled") colP = 4
            
        this.pieData.legend.data.push(data.status)
        this.pieData.series.push({
          name: data.status,
          type: "bar",
          barGap: 0,
          label: {
            show: true,
            // position: app.config.position,
            // distance: app.config.distance,
            // align: app.config.align,
            //verticalAlign: app.config.verticalAlign,
            rotate: 50,
            formatter: "{c}  {name|{a}}",
            fontSize: 16,
            rich: {
              name: {},
            },
          },
          emphasis: { focus: "series" },
          data: [data.val],
        });
        if(colP != - 1 || colP < colors.length)
        this.pieData.color.push(colors[colP])
      });

      /* Remove due to change request to bargraph
      axios.get("/get-indicator-status").then((response) => {
        let labels = [];
        const data = response.data;
        for (let i = 0; i < data.length; i++) labels.push(data[i].value);
        this.CSOIndicatorChartOptions = {
          ...this.CSOIndicatorChartOptions,
          labels: labels,
        };
      });

      var lead_org = this.selectedOrganization.text;

      if (this.selectedOrganization === "") {
        this.pieData.title.text = "No Selected Organization";
        return;
      } else this.pieData.title.text = lead_org + " Project Activities";

      var DATA = [
        {
          value: 0,
          name: "Not Yet Started",
        },
        {
          value: 0,
          name: "In Progress",
        },
        {
          value: 0,
          name: "Completed",
        },
        {
          value: 0,
          name: "Delayed",
        },
        {
          value: 0,
          name: "Cancelled",
        },
      ];

      axios.get("/dashboard-cso-indicator").then((response) => {
        const data = response.data;
        data.forEach((i) => {
          if (i.cso_lead_organization === lead_org) {
            var obj = DATA.find((obj) => obj.name === i.cso_status);
            var idx = DATA.indexOf(obj);
            DATA[idx] = {
              value: DATA[idx].value + 1,
              name: i.cso_status,
            };
          }
        });
        
                    // TODO LATER IF POSSIBLE Sep 27
                    // Correct Color via 
                    // https://echarts.apache.org/en/option.html#legend.data.itemStyle.decal.color

                    // var len = DATA.length
                    // for(var x = 0; x < len; x++){
                    //     if(DATA[x].value === 0){
                    //         DATA.splice(x,1)
                    //         x--
                    //         len = DATA.length
                    //     }
                    // }
                    
        this.pieData.series[0].data = DATA;
        
      });*/
    },

    //FOR CSO NETWORK PROFILE DOUGHNUT CHART
    updateCSOProfileChart() {
      axios.get("/dashboard-cso-profile").then((res) => {
        const data = res.data;
        let legends = {};

        var DATA = [
          {
            value: 0,
            name: "Member-based (Organization)",
          },
          {
            value: 0,
            name: "Member-based (Individuals)",
          },
          {
            value: 0,
            name: "Stand alone",
          },
        ];

        data.forEach((i) => {
          var obj = DATA.find((ob) => ob.name === i.cso_type);
          var idx = DATA.indexOf(obj);
          DATA[idx] = {
            value: DATA[idx].value + 1,
            name: obj.name,
          };
        });

        this.doughData.series[0].data = DATA;
      });
    },
    async initTop3() {
      var constructedObjectMapping = [];
      var constructedObjectMapping2 = [];

      const typeOfSupport = await this.req("/types-of-support", {});
      const csoProfile = await this.req("/cso-profile", {});
      const accreditation = await this.req("/getAccreditations", {});
      // console.log( constructedObjectMapping )
      typeOfSupport.forEach((i) => {

        constructedObjectMapping.push({
          count: 0,
          tos: i.name,
        });
        
      });

      
      accreditation.forEach((i) => {
        constructedObjectMapping2.push({
          count: 0,
          accr: i.text,
        });
      });
      
      csoProfile.forEach((item) => {
        var found = constructedObjectMapping.find(
          (obj) => obj.tos.trim().toLowerCase() === item.type_of_support.trim().toLowerCase()
        );
        if (found === undefined) {
            const type_of_support = item.type_of_support.trim().toLowerCase(); 
            if( type_of_support  && !constructedObjectMapping[type_of_support] ){  
              constructedObjectMapping.push({
                count: 1,
                tos: type_of_support,
              });
            }
        } else {
          var idx = constructedObjectMapping.indexOf(found);
          constructedObjectMapping[idx] = {
            count: found.count + 1,
            tos: found.tos,
          };
        }
      });
      csoProfile.forEach((item) => {
        var idx = 0;
        constructedObjectMapping2.forEach((mp) => {
          var res = item.cso_registration.indexOf(mp.accr);
          if (res !== -1) {
            constructedObjectMapping2[idx] = {
              count: constructedObjectMapping2[idx].count + 1,
              accr: constructedObjectMapping2[idx].accr,
            };
          }
          idx++;
        });
      });

      let total1 = csoProfile.length;
      let total2 = 0;

      constructedObjectMapping2.forEach((item) => {
        total2 += item.count;
      });

      constructedObjectMapping.sort((i1, i2) => (i1.count < i2.count ? 1 : -1));
      constructedObjectMapping2.sort((i1, i2) =>
        i1.count < i2.count ? 1 : -1
      );

      constructedObjectMapping.forEach(
        (i) => (i.percentage = ((i.count / total1) * 100).toFixed(2))
      );

      constructedObjectMapping2.forEach((i) => {
        i.percentage = ((i.count / total2) * 100).toFixed(2);
      });

      this.CSOProfileAccreditation.accreditedMapping = constructedObjectMapping;
      this.CSOProfileAccreditation.accreditationMapping = constructedObjectMapping2;
    },

    //FOR PRIMARY STAKEHOLDER BARCHART
    async initPrimaryBar() {
      const Stakeholders = await this.req("/getStakeHolders", {});
      const csoProfile = await this.req("/cso-profile", {});

      var yAxis = []; //yAxis lodi
      var data = [];

      Stakeholders.forEach((item) => {
        yAxis.push(item.text);
      });

      var xAxis = Array(yAxis.length).fill(0);
      var totalStakeHolders = 0;

      csoProfile.forEach((item) => {
        var itemStakeholders = item.cso_stakeholders.split("^^");
        itemStakeholders.forEach((stakeholder) => {
          var idx = yAxis.indexOf(stakeholder);
          xAxis[idx] += 1;
        });
        totalStakeHolders += itemStakeholders.length;
      });

      xAxis.forEach((item, idx) => {
        let computed = ((item / totalStakeHolders) * 100).toFixed(2);
        let name = `${yAxis[idx]} : ${item} ( ${computed}% )`;
        data[idx] = {
          value: computed,
          name: name,
        };
        xAxis[idx] = data[idx].value;
      });

      this.barData.xAxis.data = xAxis;
      this.barData.yAxis.data = yAxis;
      this.barData.series[0].data = data;
    },

    //ASYNC REQ
    async req(url, params) {
      try {
        const response = await axios.get(url, params);
        return response.data;
      } catch (err) {}
    },

    //FOR ASSESSMENT RADAR CHART
    async assessment() {
      const DATES = await this.req("/getDistinctAssessmentDate", {});
      const SUBDOMAIN = await this.req("/getDistinctSubDomain", {});

      let constructedDate = [];
      let constructedDate2 = [];
      let legends = [];
      let indicators = [];

      let maxScore = 0;

      SUBDOMAIN.forEach((i) => {
        maxScore = Math.max(maxScore, i.rating);
      });

      SUBDOMAIN.forEach((i) => {
        let search = indicators.find(
          (obj) => obj.name.toLowerCase() === i.sub_domain.toLowerCase()
        );
        let idx = indicators.indexOf(search);
        if (idx === -1)
          indicators.push({
            name: i.sub_domain,
            max: maxScore,
          });
      });

      DATES.forEach((date) => {
        //     //date.year
        let D = Array(indicators.length).fill(0);
        let Div = Array(indicators.length).fill(0);

        SUBDOMAIN.forEach((dom) => {
          if (dom.year === date.year && dom.tool_used === 'OPI') {
            let findObj = indicators.find(
              (obj) => obj.name.toLowerCase() === dom.sub_domain.toLowerCase()
            );
            let idx = indicators.indexOf(findObj);
            if (idx !== -1) {
              D[idx] += dom.rating;
              Div[idx] += 1;
            }
          }
        });


        if (date && date.year) {
          constructedDate.push({
            name: date.year.toString(),
            value: D,
            Div: Div,
          });
          legends.push(date.year.toString());
        }
      });

      DATES.forEach((date) => {
        //     //date.year
        let D = Array(indicators.length).fill(0);
        let Div = Array(indicators.length).fill(0);

        SUBDOMAIN.forEach((dom) => {
          if (dom.year === date.year && dom.tool_used === 'OCAT') {
            let findObj = indicators.find(
              (obj) => obj.name.toLowerCase() === dom.sub_domain.toLowerCase()
            );
            let idx = indicators.indexOf(findObj);
            if (idx !== -1) {
              D[idx] += dom.rating;
              Div[idx] += 1;
            }
          }
        });


        if (date && date.year) {
          constructedDate2.push({
            name: date.year.toString(),
            value: D,
            Div: Div,
          });
          //legends.push(date.year.toString());
        }
      });


      constructedDate.forEach((i) => {
        i.value.forEach((ix, idx) => {
          if (i.Div[idx] === 0 || i.Div[idx] === 0) return;
          i.value[idx] /= i.Div[idx];
        });
      });

      this.radarData.series.push(
        {
        "type": "radar",
        "radarIndex":0,
        "data": constructedDate
        }
      );

      constructedDate2.forEach((i) => {
        i.value.forEach((ix, idx) => {
          if (i.Div[idx] === 0 || i.Div[idx] === 0) return;
          i.value[idx] /= i.Div[idx];
        });
      });

      this.radarData.series.push(
        {
        "type": "radar",
        "radarIndex":1,
        "data": constructedDate2
        }
      );
      this.radarData.legend.data = legends;
      this.radarData.radar.push({ indicator : indicators , center: ['25%', '50%']});
      this.radarData.radar.push({ indicator : indicators , center: ['75%', '50%']});
    },

    consoleWarn(msg) {
      console.warn(msg);
    },

    //FOR FINANCE TRACKER
    async financeTracker() {
      const DATA = await this.req("/getDashBoardDistinctFinance", {});

      this.financeYears = DATA.map((item) => item.year);

      if (this.selectedFinanceYear.length === 0) return;

      for (var x = 0; x < DATA.length; x++) {
        var month = DATA[x].month;
        var idx = this.financeMonths.indexOf(month);
        if (idx === -1) this.financeMonths.push(month);
      }

      if (this.selectedFinanceMonth.length === 0) return;
      this.financeBarData.title.text =
        "Fund Received vs Actual Expenditures (" +
        this.selectedFinanceMonth +
        ", " +
        this.selectedFinanceYear +
        ")";

      let filteredData = DATA.filter((i) => {
        return (
          i.year == this.selectedFinanceYear &&
          i.month == this.selectedFinanceMonth
        );
      });

      let NewLegend = ["Grand Total"];
      let FundsRecieved = [0];
      let Expenditures = [0];

      filteredData.forEach((i) => {
        NewLegend.push(i.finance_name);
      });
      filteredData.forEach((i) => {
        FundsRecieved.push(parseFloat(i.TotalBudget));
        FundsRecieved[0] += parseFloat(i.TotalBudget);
      });
      filteredData.forEach((i) => {
        Expenditures.push(parseFloat(i.TotalExpenditure));
        Expenditures[0] += parseFloat(i.TotalExpenditure);
        //console.log(FundsRecieved, i.TotalExpenditure);
      });

      //let

      this.financeBarData.yAxis.data = NewLegend;
      this.financeBarData.series[0].data = Expenditures;
      this.financeBarData.series[1].data = FundsRecieved;
    },
    burnRate() {
      const finance_tracker = axios.get("/dashboard-finance-tracker");
      const lead_organization = axios.get("/get-lead-organization");
      axios
        .all([finance_tracker, lead_organization])
        .then(
          axios.spread((...responses) => {
            var finance_tracker_data = responses[0].data;
            const lead_organization_data = responses[1].data;
            var approved_budget = [];
            var actual_expenditure = [];
            var budget_remaining = [];
            var burn_rate = [];
            var burnRateSeries = [];
            var burnRate1 = [];
            var burnRate2 = [];
            var burnRate3 = [];
            var burnRate4 = [];
            var burnRateNames = [];
            var used = {};

            for (const index in finance_tracker_data) {
              const finance = finance_tracker_data[index];
              const budget = this.roundUp(
                parseFloat(finance["finance_budget"])
              );
              const actuals = this.roundUp(
                parseFloat(finance["finance_actuals"])
              );
              const burnRate1Value = this.roundUp(
                parseFloat(finance["finance_burn1"])
              );
              const burnRate2Value = this.roundUp(
                parseFloat(finance["finance_burn2"])
              );
              const burnRate3Value = this.roundUp(
                parseFloat(finance["finance_burn3"])
              );
              const burnRate4Value = this.roundUp(
                parseFloat(finance["finance_burn4"])
              );
              let name = finance_tracker_data[index]["finance_name"];
              let newName = name;
              while (used[newName]) newName = `${name}(${used[name]++})`;
              used[newName] = 1;

              approved_budget.push(budget);
              actual_expenditure.push(actuals);
              budget_remaining.push(this.roundUp(budget - actuals));
              burn_rate.push(this.roundUp(actuals / budget));

              burnRate1.push(burnRate1Value);
              burnRate2.push(burnRate2Value);
              burnRate3.push(burnRate3Value);
              burnRate4.push(burnRate4Value);
              burnRateNames.push(newName);
            }
            this.burnRateChartOptions = {
              ...this.burnRateChartOptions,
              xaxis: {
                categories: burnRateNames,
              },
            };
            this.burnRateChartOptions.xaxis.categories = burnRateNames;
            this.burnRateSeries = [
              {
                name: "Burn Rate (1st Liq)",
                data: burnRate1,
              },
              {
                name: "Burn Rate (2st Liq)",
                data: burnRate2,
              },
              {
                name: "Burn Rate (3st Liq)",
                data: burnRate3,
              },
              {
                name: "Burn Rate (4st Liq)",
                data: burnRate4,
              },
            ];
          })
        )
        .catch((errors) => {
          // console.log(errors)
        });
    },
    roundUp(num) {
      return Math.round((num + Number.EPSILON) * 100) / 100;
    },
    ProjectTrackingDocument() {
      axios.get("/get-project-tracking-document-history").then((response) => {
        const data = response.data;
        var date_selection = [];
        var editedItemList = {};

        for (const index in data) {
          const value = data[index].id;
          const text = "# " + data[index].id + " - " + data[index].created_at;
          date_selection.push({
            value,
            text,
          });
          editedItemList[value] = data[index];
        }
        this.date_selection = date_selection;
        this.editedItemList = editedItemList;

        this.editedItem = data[0];
        const selected_latest = date_selection[data[0].id];

        this.projectTrackingDocumentSeries = [
          {
            data: [
              this.editedItem.percentComplete,
              this.editedItem.burnRate,
              this.editedItem.objective_1,
              this.editedItem.objective_2,
              this.editedItem.objective_3,
            ],
          },
        ];
      });
    },
    generateDayWiseTimeSeries: function (baseval, count, yrange) {
      var i = 0;
      var series = [];
      while (i < count) {
        var x = baseval;
        var y =
          Math.floor(Math.random() * (yrange.max - yrange.min + 1)) +
          yrange.min;
        series.push([i, y]);
        baseval += 86400;
        i++;
      }
      return series;
    },
  },
  created() {
    this.initialize();
  },
  mounted() {},
};
</script>
<style scoped>
</style>
