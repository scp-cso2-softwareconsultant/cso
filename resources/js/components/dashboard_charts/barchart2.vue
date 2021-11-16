<template>
  <center>
    <div id="piedesue"></div>
  </center>
</template>
<script>
import * as echarts from "echarts";

export default {
  name: "chart",
  props: ["D"],
  data() {
    return {
      chartDom: "",
    };
  },
  methods: {
    initChart() {
      this.chartDom = null;
      this.chartDom = document.getElementById("piedesue");
      this.chartDom = echarts.init(this.chartDom);
      this.chartDom.setOption(this.D);
    },
  },
  mounted() {
    this.initChart();
  },
  watch: {
    D: {
      handler: function (n, o) { this.chartDom.setOption(this.D); },
      deep: true,
    },
  },
};
</script>
<style scoped>
#piedesue {
  height: 60vh;
}
</style>
