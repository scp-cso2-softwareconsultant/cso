<template>
    <v-app>
        <h3 class="subheading grey--text">Dashboard</h3>
        <v-card >
            <v-card-text>
                <v-container dense >
                    <v-row>
                        <v-col
                            cols="12"
                            lg="6"
                        >
                            <div id="chartRadar">
                                <apexchart type="radar" height="350" :options="radarChartOptions" :series="radarSeries"></apexchart>
                            </div>
                        </v-col>

                        <v-col
                            cols="12"
                            lg="6"
                        >
                            <div id="chartGroup">
                                <apexchart type="bar" height="350" :options="groupChartOptions" :series="groupSeries"></apexchart>
                            </div>
                        </v-col>
                    </v-row>
                </v-container>
            </v-card-text>
        </v-card>
<!--                <v-flex-->
<!--                    sm6-->
<!--                    xs12-->
<!--                    md6-->
<!--                    lg3-->
<!--                >-->
<!--                    <v-card class="ma-3">-->
<!--                        <v-list-item  >-->
<!--                            <v-list-item-avatar-->
<!--                                tile-->
<!--                                class="mt-n7"-->
<!--                            >-->
<!--                                <v-sheet color="green" width="80" height="80" elevation="10">-->
<!--                                    <v-icon dark large>store</v-icon>-->
<!--                                </v-sheet>-->
<!--                            </v-list-item-avatar>-->
<!--                            <v-list-item-content>-->
<!--                                <div class="overline text-right">Article</div>-->
<!--                                <v-list-item-title class="headline mb-1 text-right" >523614</v-list-item-title>-->
<!--                                <div><v-divider></v-divider></div>-->
<!--                            </v-list-item-content>-->
<!--                        </v-list-item>-->
<!--                        <v-card-actions>-->
<!--                            <v-icon text class="ma-2">person</v-icon>-->
<!--                            <div class="overline">Iyad</div>-->
<!--                        </v-card-actions>-->
<!--                    </v-card>-->
<!--                </v-flex>-->
<!--                <v-flex-->
<!--                    sm6-->
<!--                    xs12-->
<!--                    md6-->
<!--                    lg3-->
<!--                >-->
<!--                    <v-card class="ma-3">-->
<!--                        <v-list-item>-->
<!--                            <v-list-item-avatar-->
<!--                                tile-->
<!--                                class="mt-n7"-->
<!--                            >-->
<!--                                <v-sheet color="#F44336" width="80" height="80" elevation="10">-->
<!--                                    <v-icon dark large>subscriptions</v-icon>-->
<!--                                </v-sheet>-->
<!--                            </v-list-item-avatar>-->
<!--                            <v-list-item-content>-->
<!--                                <div class="overline text-right">Abonné</div>-->
<!--                                <v-list-item-title class="headline mb-1 text-right" >+700</v-list-item-title>-->
<!--                                <div><v-divider></v-divider></div>-->
<!--                            </v-list-item-content>-->
<!--                        </v-list-item>-->
<!--                        <v-card-actions>-->
<!--                            <v-icon text class="ma-2">subscriptions</v-icon>-->
<!--                            <div class="overline">AAE IdeaPro</div>-->
<!--                        </v-card-actions>-->
<!--                    </v-card>-->
<!--                </v-flex>-->
<!--                <v-flex-->
<!--                    sm6-->
<!--                    xs12-->
<!--                    md6-->
<!--                    lg3-->
<!--                >-->
<!--                    <v-card class="ma-3">-->
<!--                        <v-list-item>-->
<!--                            <v-list-item-avatar-->
<!--                                tile-->
<!--                                class="mt-n7"-->
<!--                            >-->
<!--                                <v-sheet color="#03A9F4" width="80" height="80" elevation="10">-->
<!--                                    <v-icon dark large>add_shopping_cart</v-icon>-->
<!--                                </v-sheet>-->
<!--                            </v-list-item-avatar>-->
<!--                            <v-list-item-content>-->
<!--                                <div class="overline text-right">Shopping</div>-->
<!--                                <v-list-item-title class="headline mb-1 text-right" >$34,245</v-list-item-title>-->
<!--                                <div><v-divider></v-divider></div>-->
<!--                            </v-list-item-content>-->
<!--                        </v-list-item>-->
<!--                        <v-card-actions>-->
<!--                            <v-icon text class="ma-2">credit_card</v-icon>-->
<!--                            <div class="overline">VISA Card</div>-->
<!--                        </v-card-actions>-->
<!--                    </v-card>-->
<!--                </v-flex>-->
<!--                <v-flex-->
<!--                    sm6-->
<!--                    xs12-->
<!--                    md6-->
<!--                    lg3-->
<!--                >-->
<!--                    <v-card class="ma-3">-->
<!--                        <v-list-item >-->
<!--                            <v-list-item-avatar-->
<!--                                tile-->
<!--                                class="mt-n7"-->
<!--                            >-->
<!--                                <v-sheet color="#FFC107" width="80" height="80" elevation="10">-->
<!--                                    <v-icon dark large>folder_shared</v-icon>-->
<!--                                </v-sheet>-->
<!--                            </v-list-item-avatar>-->
<!--                            <v-list-item-content>-->
<!--                                <div class="overline text-right">Folder shared</div>-->
<!--                                <v-list-item-title class="headline mb-1 text-right" >1730</v-list-item-title>-->
<!--                                <div><v-divider></v-divider></div>-->
<!--                            </v-list-item-content>-->
<!--                        </v-list-item>-->
<!--                        <v-card-actions>-->
<!--                            <v-icon text class="ma-2">folder</v-icon>-->
<!--                            <div class="overline">Prodect</div>-->
<!--                        </v-card-actions>-->
<!--                    </v-card>-->
<!--                </v-flex>-->
<!--                <v-flex xs12 sm6 md4 lg3 v-for="person in team" :key="person.name">-->
<!--                    <v-card class="text-center ma-3">-->
<!--                        <v-responsive class="pt-4">-->
<!--                            <v-avatar size="100" class="red lighten-2">-->
<!--                                <img :src="person.avatar" alt="" >-->
<!--                            </v-avatar>-->
<!--                        </v-responsive>-->
<!--                        <v-card-text>-->
<!--                            <div class="subheading">{{person.name}}</div>-->
<!--                            <div class="grey&#45;&#45;text">{{person.role}}</div>-->
<!--                        </v-card-text>-->
<!--                        <v-card-actions>-->
<!--                            <v-btn outlined color="orange">-->
<!--                                <v-icon small left >message</v-icon>-->
<!--                                <span>Message</span>-->
<!--                            </v-btn>-->
<!--                        </v-card-actions>-->
<!--                    </v-card>-->
<!--                </v-flex>-->

        </v-card>
    </v-app>
</template>

<script>
// @ is an alias to /src
import VueApexCharts from 'vue-apexcharts';
export default {
    components: {
        apexchart: VueApexCharts,
    },
    data () {
        return {
            radarSeries: [
                {
                    name: '2013',
                    data: [3, 2.6, 2.8, 3.5, 3, 2.5,2.5,2.9],
                },
                {
                    name: '2014',
                    data: [1.8, 2.2, 2.6, 2.8, 2, 2.2, 2.2, 2.8],
                }],
            radarChartOptions: {
                chart: {
                    height: 350,
                    type: 'radar',
                },
                title: {
                    text: 'Graph View'
                },
                xaxis: {
                    categories: ['Results', 'Standards', 'Delivery', 'Reach', 'Target', 'Learning','Resources','Social']
                }
            },

            groupSeries: [{
                name: 'Actual',
                data: [90000, 120000, 80000]
            }, {
                name: 'Variance',
                data: [310000,280000,320000]
            }],
            groupChartOptions: {
                chart: {
                    type: 'bar',
                    height: 150
                },
                title: {
                    text: 'Finance Tracker'
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        dataLabels: {
                            position: 'top',
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    offsetX: -6,
                    style: {
                        fontSize: '12px',
                        colors: ['#fff']
                    }
                },
                stroke: {
                    show: true,
                    width: 1,
                    colors: ['#fff']
                },
                tooltip: {
                    shared: true,
                    intersect: false
                },
                xaxis: {
                    categories: ['AHA!BD', 'PICPA', 'AteneoCORD'],
                },
            },

            series: [{
                data: [21, 22, 10, 28, 16, 21, 13]
            }],
            chartOptions: {
                chart: {
                    height: 350,
                    type: 'bar',
                    events: {
                        click: function(chart, w, e) {
                            // console.log(chart, w, e)
                        }
                    }
                },
                title: {
                    text: 'Sign-In Attendance'
                },
                // colors: colors,
                plotOptions: {
                    bar: {
                        columnWidth: '45%',
                        distributed: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                legend: {
                    show: false
                },
                xaxis: {
                    categories: [
                        // ['Event A', 'Doe'],
                        'Event A',
                        'Event B',
                        'Event C',
                        'Event D',
                        'Event E',
                        'Event F',
                        'Event G',
                        'Event H'
                    ],
                    labels: {
                        style: {
                            // colors: colors,
                            fontSize: '12px'
                        }
                    }
                }
            },
        }
    },
}
</script>
