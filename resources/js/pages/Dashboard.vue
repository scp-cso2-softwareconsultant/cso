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
          <div class="row">
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
          <p
            v-for="(
              item, index
            ) in CSOProfileAccreditation.accreditationMapping.slice(0,3)"
            :key="index"
            class="card-text font-weight-bold text-uppercase"
          >
            {{ item.tos }} :
            <span class="font-weight-normal">{{ item.percentage }} %</span>
          </p>
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
        <p class="card-text row justify-content-md-center">
          <apexchart
            type="radar"
            height="350"
            :options="assessmentSubDomainPerYearChartOptions"
            :series="assessmentSubDomainPerYearSeries"
          ></apexchart>
        </p>
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

export default {
  components: {
    apexchart: VueApexCharts,
    PieChart,
    DoughnutChart,
    BarChart,
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
          dataView: { show: true, readOnly: false },
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
      data: [],
      total: 0,
      accreditedMapping: [
        { count: 0, tos: "local policy makers" },
        { count: 0, tos: "private sector support organizations and CSRs" },
        { count: 0, tos: "peer CSOs or related networks" },
        { count: 0, tos: "larger CSOs/CSO Network in Manila, Cebu or Davao" },
        { count: 0, tos: "local researchers and scholars" },
        { count: 0, tos: "potential donors" },
      ],
      accreditationMapping: []
    },
    //BARCHART
    barData: {
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
          "tite",
        ],
      },
      series: [
        {
          name: "Direct",
          type: "bar",
          stack: "total",
          label: {
            formatter: "{c}%",
            show: true,
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
          data: [
            { value: 8, name: "Local Policy Makers : 21" },
            { value: 15, name: "22" },
            { value: 50, name: "23" },
            { value: 7, name: "24" },
            { value: 7, name: "25" },
            { value: 5, name: "26" },
            { value: 3, name: "27" },
          ],
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
    initialize() {
      document.title = "SCP: CSO² Project | Dashboard";
      this.updateCSOIndicatorsChart();
      this.updateCSOProfileChart();
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
          console.log(lead_org);
          if (i.cso_lead_organization === lead_org) {
            var obj = DATA.find((obj) => obj.name === i.cso_status);
            var idx = DATA.indexOf(obj);
            DATA[idx] = { value: DATA[idx].value + 1, name: i.cso_status };
          }
        });
        /*
        TODO LATER

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

      // COMPUTING TOP 3 ACCREDIT..
      var constructedObjectMapping = [];
      var constructedObjectMapping2 = [];
      /* structure
      CSOProfileAccreditation
        .AccreditedBodies:[],
        .data: [],
        .total : 0,
        .accreditedMapping:[] 
        */
      // REMOVE DUE TO CHANGES REQUEST BY CLIENT
      axios.get("/types-of-support").then((response) => {
        const data = response.data;
        data.forEach((i) => {
          constructedObjectMapping.push({ count: 0, tos: i.name });
        });
      });
      axios.get("/getAccreditations").then((response) => {
        const data = response.data;
        data.forEach((i) => {
          constructedObjectMapping2.push({
            count: 0,
            accr: i.text,
          });
        });
      });

      // axios.get('/getStakeHolders').then((response)=>{
      //         response.data.forEach((i)=>{
      //             constructedObjectMapping.push({count: 0, tos : i.text})
      //         });
      //     })

      axios.get("/cso-profile").then((response) => {
        this.CSOProfileAccreditation.total = response.data.length;
        this.CSOProfileAccreditation.data = response.data;
        this.CSOProfileAccreditation.data.forEach((item) => {
          var parsed = item.cso_stakeholders.split("^^");
          var parsed2 = item.cso_registration.split("^^");

          var constructed = [];
          var constructed2 = [];

          parsed.forEach((it) => {
            if (it.length === 0) return;
            constructed.push({ value: it, tos: it });
          });

          parsed2.forEach((it) => {
            if (it.length === 0) return;
            constructed2.push({ value: it, accr: it });
          });

          item.cso_stakeholders = constructed;
          item.cso_registration = constructed2;

          var found = constructedObjectMapping.find(
            (obj) => obj.tos === item.type_of_support
          );

          if (found === undefined) {
            // console.log(
            //   "One of Data has unknown cso_stakeholders - will not be counted in Top 3 Accreditation",
            //   item.type_of_support
            // );
          } else {
            var idx = constructedObjectMapping.indexOf(found);
            constructedObjectMapping[idx] = {
              count: found.count + 1,
              tos: found.tos,
            };
          }

          constructedObjectMapping2.forEach((i)=>{
               //var hasAccr = item.registration.find(reg => reg.accr )
               console.log(item)
            //    if(hasAccr !== -1)
            //        i.count += 1
          })
        });
        constructedObjectMapping.sort((i1, i2) =>
          i1.count < i2.count ? 1 : -1
        );
        constructedObjectMapping.forEach(
          (i) =>
            (i.percentage = (
              (i.count / this.CSOProfileAccreditation.total) *
              100
            ).toFixed(2))
        );
        this.CSOProfileAccreditation.accreditedMapping =
          constructedObjectMapping;
      });
    },
    assessment() {
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