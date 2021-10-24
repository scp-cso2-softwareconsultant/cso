<template>
    <div>
        <div id="bar1"></div>
    </div>
</template>
<script>
import * as echarts from "echarts";

export default {
    name : "bardesu1",
    props:['D'],
    data(){
        return {
            chartDom : ''
        };
    },
    methods:{
        initChart(){
            this.chartDom = null
            this.chartDom = document.getElementById('bar1')
            this.chartDom = echarts.init(this.chartDom)
            this.chartDom.setOption(this.D);
        },
    },
    mounted(){ this.initChart(); },
    watch:{
        D:{
            handler: function(n,o){ this.chartDom.setOption(this.D); },
            deep: true
        }
    }
}
</script>
<style scoped>
    #bar1{  height: 60vh; width: 55vh; }
</style>
