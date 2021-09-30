<template>
  <v-app>
    <h3 class="subheading grey--text">Dashboard</h3>
    <!-- CSO INDICATOR PIE -->
    <div class="card p-md-5">
      <h4 class="subheading card-text">CSO² Project Indicators</h4>
      <h1 class="pt-4 card-text text-center"></h1>
      <div class="card-body">
        <center>
          <v-combobox
            class="d-inline-block p-3"
            hide-selected
            small-chips
            v-on:change="updateCSOIndicatorsChart()"
            v-model="selectedOrganization"
            :items="responsibleOrganization"
            label="Responsible Organization"
          ></v-combobox>
        </center>
        <!-- <h5 class="card-title"> Responsible Organization </h5> -->
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
            <!-- <p class="card-text">
                  <apexchart
                    type="donut"
                    width="380"
                    :options="CSOProfileTypesOfOrganizationChartOptions"
                    :series="CSOProfileTypesOfOrganizationSeries"
                  ></apexchart>
                </p> -->
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
          <!-- <p
            v-for="(
              item, index
            ) in CSOProfileAccreditation.accreditedMapping.slice(3)"
            :key="index"
            class="card-text font-weight-bold text-uppercase"
          >
            {{ item.tos }} :
            <span class="font-weight-normal">{{ item.percentage }} %</span>
          </p> -->
          <!-- <v-chip
              class="chip teal lighten-3 px-3 m-3 p-3"
              outlined
              v-for="(
                item, index
              ) in CSOProfileAccreditation.accreditationMapping.slice(0, 3)"
              :key="index"
            >
              {{ item.accr }} : {{ item.percentage }} %
            </v-chip> -->
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
                <!-- <apexchart
                  type="bar"
                  height="350"
                  :options="CSOProfilePrimaryStakeholderChartOptions"
                  :series="CSOProfilePrimaryStakeholderSeries"
                ></apexchart> -->
                <BarChart :D="barData" />
              </div>
            </v-list-item-content>
          </v-list-item>
        </v-card>
      </v-flex>
    </div>

    <div class="card p-md-5">
      <h4 class="subheading card-text">Assessment</h4>
      <div class="card-body">
        <!-- <p class="card-text row justify-content-md-center">
          <apexchart
            type="radar"
            height="350"
            :options="assessmentSubDomainPerYearChartOptions"
            :series="assessmentSubDomainPerYearSeries"
          ></apexchart>
        </p> -->
        <RadarChart :D="radarData" />
      </div>
    </div>

    <div class="card p-md-5">
      <h4 class="subheading card-text">Finance Tracker</h4>
      <v-flex>
        <v-card class="ma-1">
          <v-list-item>
            <v-list-item-content>
              <h5 class="card-title">Budget vs Actual Expenditures</h5>
              <div class="text-center">
                <apexchart
                  type="line"
                  height="350"
                  :options="financeTrackerBudgetChartOptions"
                  :series="financeTrackerBudgetSeries"
                ></apexchart>
              </div>
            </v-list-item-content>
          </v-list-item>
        </v-card>
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

export default {
  components: {
    apexchart: VueApexCharts,
    PieChart,
    DoughnutChart,
    BarChart,
    RadarChart,
  },
  data: () => ({
    responsibleOrganization: [], // Lead Organizations
    selectedOrganization: "",

    //ECHART1
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
          mark: { show: true },
          dataView: { show: true, readOnly: true },
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
      series: [
        {
          name: "Status",
          type: "pie",
          radius: [35, 170],
          center: ["50%", "50%"],
          roseType: "area",
          itemStyle: {
            borderRadius: 8,
          },
          data: [],
        },
      ],
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
          mark: { show: true },
          dataView: { show: true, readOnly: true },
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
        { count: 0, tos: "local policy makers" },
        { count: 0, tos: "private sector support organizations and CSRs" },
        { count: 0, tos: "peer CSOs or related networks" },
        { count: 0, tos: "larger CSOs/CSO Network in Manila, Cebu or Davao" },
        { count: 0, tos: "local researchers and scholars" },
        { count: 0, tos: "potential donors" },
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
      toolbox: {
        show: true,
        feature: {
          mark: { show: true },
          //dataView: { show: true, readOnly: true },
          //restore: { show: true },
          saveAsImage: {
            show: true,
          },
        },
      },
      tooltip: {
        trigger: "axis",
        formatter: "{b}",
        axisPointer: {
          // Use axis to trigger tooltip
          type: "shadow", // 'shadow' as default; can also be 'line' or 'shadow'
        },
      },
      legend: { show: false },
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
          label: {
            formatter: "{label_white|{c}}%",
            show: true,
            rich: {
              label_white: {
                color: "#fff",
              },
            },
          },
          itemStyle: {
            borderRadius: 6,
            color: new echarts.graphic.LinearGradient(1, 0, 0, 1, [
              { offset: 0.5, color: "#824f7e" },
              { offset: 1, color: "#824f7e" },
              { offset: 0, color: "#5c3759" },
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
        text: "Domain",
        left: "center",
      },toolbox: {
        show: true,
        feature: {
          mark: { show: true },
          dataView: { show: true, readOnly: true },
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
      radar: {
        indicator: [],
      },
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
        {
          name: "TR = TotalRating per domain per year\nN = Number of a Domain per year\nComputation: TR / N = Domain Point in Radar Chart\n\nExample:\n\tYear 2022:\n\tdomain\trating\t\t\tComputation:\n\tsub1\t5\t\t\tsub1 N = 3\t\t\tTotal RatingOfSub1 = 15\n\tsub1\t4\t\t\tsub2 N = 2\t\t\tTotal RatingOfSub2 = 9\n\tsub1\t6\t\t\tsub3 N = 3\t\t\tTotal RatingOfSub3 = 3\n\tsub2\t5\n\tsub2\t4\t\t\tforSub1 = 15/3 = 5\n\tsub3\t1\t\t\tforSub2 = 9/2 = 4.5\n\tsub3\t1\t\t\tforSub3 = 3/3 = 1\n\tsub3\t1\t\t\tThe result would be 3 points toward sub1 sub2 sub3 indicator\n\n\n***DATA BELOW IS THE REAL COMPUTED DATA OF THE RADAR CHART BASED ON DOMAIN OF LRO ASSESSMENT PER DATE & PER DOMAIN***\n\n\n",
          type: "radar",
          data: [],
        },
      ],
    },
    CSOProfilePrimaryStakeholderSeries: [
      {
        data: [1, 1, 1, 1, 1, 1],
      },
    ],
    CSOProfilePrimaryStakeholderChartOptions: {
      chart: {
        type: "bar",
        height: 350,
      },
      plotOptions: {
        bar: {
          borderRadius: 4,
          horizontal: true,
        },
      },
      dataLabels: {
        enabled: false,
      },
      xaxis: {
        categories: [
          "local policy makers",
          "private sector support organizations and CSRs",
          "peer CSOs or related networks",
          "larger CSOs/CSO Network in Manila, Cebu or Davao",
          "local researchers and scholars",
          "potential donors",
        ],
      },
    },

    assessmentSubDomainPerYearSeries: [
      {
        name: "Series 1",
        data: [80, 50, 30, 40, 100, 20],
      },
    ],
    assessmentSubDomainPerYearChartOptions: {
      chart: {
        height: 450,
        type: "radar",
      },
      title: {
        text: "average of SUBDOMAIN, per YEAR",
      },
      xaxis: {
        categories: ["January", "February", "March", "April", "May", "June"],
      },
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
        data: [10, 2, 30, 0, 0, 0],
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
          dataLabels: {
            position: "bottom",
          },
        },
      },
      xaxis: {
        min: 0,
        max: 100,
      },
      colors: [
        "#33b2df",
        "#546E7A",
        "#d4526e",
        "#13d8aa",
        "#A5978B",
        "#2b908f",
        "#f9a3a4",
        "#90ee7e",
        "#f48024",
        "#69d2e7",
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
        dropShadow: {
          enabled: true,
        },
      },
      stroke: {
        width: 1,
        colors: ["#fff"],
      },
      xaxis: {
        categories: [
          "Progress bar of days completed",
          "Progress bar of burn rate",
          "Progress bar for Objective 1",
          "Progress bar for Objective 2",
          "Progress bar for Objective 3",
          "Progress bar for Objective 4",
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
      this.assessment();
      this.financeTracker();
      this.ProjectTrackingDocument();

      axios.get("/get-lead-organization").then((res) => {
        this.responsibleOrganization = res.data;
      });
    },

    //FOR CSO2 INDICATOR PIE CHART
    updateCSOIndicatorsChart() {
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
        { value: 0, name: "Not Yet Started" },
        { value: 0, name: "In Progress" },
        { value: 0, name: "Completed" },
        { value: 0, name: "Delayed" },
        { value: 0, name: "Cancelled" },
      ];

      axios.get("/dashboard-cso-indicator").then((response) => {
        const data = response.data;
        data.forEach((i) => {
          //console.log(lead_org);
          if (i.cso_lead_organization === lead_org) {
            var obj = DATA.find((obj) => obj.name === i.cso_status);
            var idx = DATA.indexOf(obj);
            DATA[idx] = { value: DATA[idx].value + 1, name: i.cso_status };
          }
        });
        /*
        TODO LATER IF POSSIBLE Sep 27
        Correct Color via 
        https://echarts.apache.org/en/option.html#legend.data.itemStyle.decal.color

        var len = DATA.length
        for(var x = 0; x < len; x++){
            console.log(DATA[x].value)
            if(DATA[x].value === 0){
                DATA.splice(x,1)
                x--
                len = DATA.length
            }
        }
        */
        this.pieData.series[0].data = DATA;
      });
    },

    //FOR CSO NETWORK PROFILE DOUGHNUT CHART
    updateCSOProfileChart() {
      axios.get("/dashboard-cso-profile").then((res) => {
        const data = res.data;
        let legends = {};

        var DATA = [
          { value: 0, name: "Member-based (Organization)" },
          { value: 0, name: "Member-based (Individuals)" },
          { value: 0, name: "Stand alone" },
        ];

        data.forEach((i) => {
          var obj = DATA.find((ob) => ob.name === i.cso_type);
          var idx = DATA.indexOf(obj);
          DATA[idx] = { value: DATA[idx].value + 1, name: obj.name };
        });

        this.doughData.series[0].data = DATA;
      });
    },
    async initTop3() {
      var constructedObjectMapping = [];
      var constructedObjectMapping2 = [];

      const typeOfSupport = await this.req("/types-of-support");
      const csoProfile = await this.req("/cso-profile");
      const accreditation = await this.req("/getAccreditations");

      typeOfSupport.forEach((i) => {
        constructedObjectMapping.push({ count: 0, tos: i.name });
      });
      accreditation.forEach((i) => {
        constructedObjectMapping2.push({
          count: 0,
          accr: i.text,
        });
      });

      csoProfile.forEach((item) => {
        var found = constructedObjectMapping.find(
          (obj) => obj.tos === item.type_of_support
        );

        if (found === undefined) {
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
      this.CSOProfileAccreditation.accreditationMapping =
        constructedObjectMapping2;
    },
    //FOR PRIMARY STAKEHOLDER BARCHART
    async initPrimaryBar() {
      const Stakeholders = await this.req("/getStakeHolders");
      const csoProfile = await this.req("/cso-profile");

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
        data[idx] = { value: computed, name: name };
        xAxis[idx] = data[idx].value;
      });

      this.barData.xAxis.data = xAxis;
      this.barData.yAxis.data = yAxis;
      this.barData.series[0].data = data;
    },

    //ASYNC REQ
    async req(url) {
      try {
        const response = await axios.get(url);
        return response.data;
      } catch (err) {}
    },

    //FOR ASSESSMENT RADAR CHART
    async assessment() {
      const DATES = await this.req("/getDistinctAssessmentDate");
      const SUBDOMAIN = await this.req("/getDistinctSubDomain");

      let constructedDate = [];
      let legends = [];
      let indicators = [];

      let maxScore = 0;

      SUBDOMAIN.forEach((i) => { maxScore = Math.max(maxScore, i.rating); });

      SUBDOMAIN.forEach((i) => {
        let search = indicators.find((obj) => obj.name.toLowerCase() === i.sub_domain.toLowerCase());
        let idx = indicators.indexOf(search)
        if(idx === -1)
          indicators.push({ name: i.sub_domain, max: maxScore });
      });
      console.log("INIT",SUBDOMAIN)

      DATES.forEach((date) => { //date.year
        let D = Array(indicators.length).fill(0);
        let Div = Array(indicators.length).fill(0);

        SUBDOMAIN.forEach((dom)=>{
             if(dom.year === date.year){
             let findObj = indicators.find((obj) => obj.name.toLowerCase() === dom.sub_domain.toLowerCase());
             let idx = indicators.indexOf(findObj);
             if(idx !== -1){
               //console.log("PLACING To ", idx, "which contain "+D[idx], "Value of "+dom.rating)
               D[idx] += dom.rating
               Div[idx] += 1
             }
           }
        })

        constructedDate.push({ name: date.year.toString(), value: D , Div : Div});
        legends.push(date.year.toString());
      });

      console.log(maxScore)

      constructedDate.forEach((i)=>{
        i.value.forEach((ix,idx)=>{
          if(i.Div[idx] === 0 || i.Div[idx] === 0) return;
          i.value[idx] /= i.Div[idx]
        })
      })

    console.log(constructedDate)
      this.radarData.series[0].data = constructedDate;
      this.radarData.legend.data = legends;
      this.radarData.radar.indicator = indicators;

      // assessmentSubDomainPerYearSeries
      // assessmentSubDomainPerYearChartOptions
    },
    financeTracker() {
      // financeTrackerBudgetSeries
      // financeTrackerBudgetChartOptions
      // burnRateSeries
      // burnRateChartOptions
    },
    ProjectTrackingDocument() {
      // projectTrackingDocumentSeries
      // projectTrackingDocumentChartOptions
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