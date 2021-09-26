<template>
    <div id='chartdesu'>

    </div>
</template>
<script>
import * as echarts from "echarts";

export default {
    name:"doughnut",
    data(){
        return {
            chartDom : ''
        }
    },
    props: ['D'],
    methods:{
        initChart(){
            this.chartDom = null
            this.chartDom = document.getElementById('chartdesu')
            this.chartDom = echarts.init(this.chartDom)
            this.chartDom.setOption(this.D);
        },
    },
    mounted(){ this.initChart(); },
    watch:{
        D:{
            handler: function(n,o){ 
                this.chartDom.setOption(this.D); 
                console.log("CHANGED")
            },
            deep: true
        }
    }
}
</script>

<style scoped>
    #chartdesu{  height: 50vh; }
</style>
