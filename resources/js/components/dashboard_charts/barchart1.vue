<template>
  <center>
    <div id="piedesu"></div>
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
      this.chartDom = document.getElementById("piedesu");
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
#piedesu {
  height: 60vh;
}
</style>
