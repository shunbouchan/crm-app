<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { reactive, onMounted } from 'vue';
import { getToday } from '@/common'
import axios from 'axios';
import dayjs from 'dayjs'
import Chart from '@/Components/Chart.vue'

onMounted(() => {
form.startDate = getToday()
form.endDate = getToday()
})

const data = reactive({})

const form = reactive({
    startDate: null,
    endDate: null,
    type: 'perDay',
})

function comma(num) {
    return String(num).replace( /(\d)(?=(\d\d\d)+(?!\d))/g, '$1,');
}

const getData = async () => {
    try{
        await axios.get('/api/analysis/',{
            params: {
                startDate: form.startDate,
                endDate: form.endDate,
                type: form.type,
            }
        }).then(res =>{
            data.data = res.data.data;
            data.labels = res.data.labels.map(function(date){
                return dayjs(date).format('YYYY/MM/DD');
            })
            data.totals = res.data.totals
        })
    }catch(e){
        console.log(e);
    }
}

</script>

<template>
    <Head title="データ分析" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">データ分析</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="getData">
                            <div class="text-center">
                                From: <input type="date" name="startDate" v-model="form.startDate" class="bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"> 〜
                                To: <input type="date" name="endDate" v-model="form.endDate" class=" bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                            <button class="flex mx-auto mt-3 text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">分析する</button>
                        </form>
                        <div v-show="data.data">
                          <div class="lg:w-2/3 w-full mx-auto overflow-auto">
                          </div>
                          <Chart :data="data"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
