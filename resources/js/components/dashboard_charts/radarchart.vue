<template>
    <div>
        <div id="radardesu"></div>
    </div>
</template>
<script>
import * as echarts from "echarts";

export default {
    name : "radarchart",
    props:['D'],
    data(){
        return {
            chartDom : ''
        };
    },
    methods:{
        initChart(){
            this.chartDom = null
            this.chartDom = document.getElementById('radardesu')
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
    #radardesu{  height: 60vh; }
</style>
