<template>
    <div>
        <div id="bar2"></div>
    </div>
</template>
<script>
import * as echarts from "echarts";

export default {
    name : "bardesu2",
    props:['D'],
    data(){
        return {
            chartDom : ''
        };
    },
    methods:{
        initChart(){
            this.chartDom = null
            this.chartDom = document.getElementById('bar2')
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
    #bar2{  height: 60vh;width: 55vh;  }
</style>
