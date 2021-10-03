<template>
    <div id='multi_desu'>

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
            this.chartDom = document.getElementById('multi_desu')
            this.chartDom = echarts.init(this.chartDom)
            this.chartDom.setOption(this.D);
        },
    },
    mounted(){ this.initChart(); },
    watch:{
        D:{
            handler: function(n,o){ 
                this.chartDom.setOption(this.D); 
                //console.log("CHANGED")
            },
            deep: true
        }
    }
}
</script>

<style scoped>
    #multi_desu{  height: 50vh; }
</style>
