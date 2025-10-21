<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import {ref} from "vue";
import VueApexCharts from "vue3-apexcharts";

const lineSeries = ref([]);
const lineChartOptions = ref({
    chart: { type: 'line' },
    xaxis: {
        categories: [],
        convertedCatToNumeric: false,
    },
    stroke: { curve: 'smooth' },
    title: { text: 'Динамика прихода и расхода' }
});
const donutSeries = ref([]);
const donutChartOptions = ref({
    chart: {
        type: 'donut'
    },
    labels: [],
    title: {
        text: 'Соотношение прихода и расхода',
        align: 'center'
    },
    legend: {
        position: 'bottom'
    },
    dataLabels: {
        enabled: true,
        formatter: (val) => `${val.toFixed(1)}%`
    }
});
const loading = ref(true);

axios.get('/api/dashboard').then((response) => {
    const lineChartData = response.data.lineChart.data
    lineSeries.value = Object.values(lineChartData);
    lineChartOptions.value = {
        ...lineChartOptions.value,
        xaxis: {
            type: 'category',
            categories: response.data.lineChart.months
        }
    };

    const donutChart = response.data.donutChart
    donutSeries.value = Object.values(donutChart.data).map(Number);
    donutChartOptions.value = {
        chart: { type: 'donut' },
        labels: donutChart.labels,
        title: { text: 'Соотношение прихода и расхода' },
        legend: { position: 'bottom' }
    };
    loading.value = false;
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-2"
                    v-loading
                >
                    <el-row :gutter="20">
                        <el-col :span="12">
                            <apexchart
                                type="line"
                                :options="lineChartOptions"
                                :series="lineSeries" />
                        </el-col>
                        <el-col :span="12">
                            <apexchart
                                type="donut"
                                :series="donutSeries"
                                :options="donutChartOptions"
                            />
                        </el-col>
                    </el-row>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
