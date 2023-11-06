<script setup>
import { onMounted, reactive,ref,computed } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import { Head,Link,useForm } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import dayjs from 'dayjs'


const props = defineProps({
    items: Array,
    order: Array,
 })


onMounted(() => { // ページ読み込み後 即座に実行
    console.log(props.order);


})

</script>
<template>

    <Head title="購買履歴詳細" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">購買履歴詳細</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="storePurchase">
                             <div class="container px-5 py-8 mx-auto">
                               <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                 <div class="flex flex-wrap -m-2">
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="date" class="leading-7 text-sm text-gray-600">日付</label>
                                       <div id="name" name="date" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                    {{ dayjs(props.order[0].created_at).format('YYYY/MM/DD') }}
                                    </div>
                                     </div>
                                   </div>
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                         <label for="customer" class="leading-7 text-sm text-gray-600">顧客名</label>
                                         <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                            {{ props.order[0].customer_name }}
                                         </div>
                                     </div>
                                   </div>
                                   <table class="w-full table-auto w-full text-left whitespace-no-wrap">
                                    <thead>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Id</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">商品名</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">価格</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">数量</th>
                                        <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">小計</th>
                                    </thead>
                                        <tbody class="w-full">
                                            <tr v-for="item in props.items"  :key="item.id" class="w-full">
                                                <td class="w-1/8 border-t-2 border-b-2 border-gray-200 px-4 py-3">{{ item.item_id }}</td>
                                                <td class="w-3/8 border-t-2 border-b-2 border-gray-200 px-4 py-3">{{ item.item_name }}</td>
                                                <td class="w-1/8 border-t-2 border-b-2 border-gray-200 px-4 py-3">{{ item.item_price }}</td>
                                                <td class="w-2/8 border-t-2 border-b-2 border-gray-200 px-4 py-3">
                                                    {{ item.quantity }}
                                                </td>
                                                <td class="w-1/8 border-t-2 border-b-2 border-gray-200 px-4 py-3">
                                                    {{ item.subtotal }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="p-2 w-full">
                                     <div class="">
                                       <label for="price" class="leading-7 text-sm text-gray-600">ステータス</label>
                                       <div v-if="props.order[0].status === 0" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                           キャンセル済み
                                       </div>
                                     </div>
                                   </div>
                                    <div class="p-2 w-full">
                                     <div class="">
                                       <label for="price" class="leading-7 text-sm text-gray-600">キャンセル日</label>
                                       <div v-if="props.order[0].status === 0" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                           {{ dayjs(props.order[0].updated_at).format('YYYY/MM/DD') }}
                                       </div>
                                     </div>
                                   </div>
                                    <div class="p-2 w-full">
                                     <div class="">
                                       <label for="price" class="leading-7 text-sm text-gray-600">合計金額</label>
                                       <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                           {{ props.order[0].total }}円
                                       </div>
                                     </div>
                                   </div>
                                    <div class="p-2 w-full" v-if="props.order[0].status === 1">
                            <Link as="button" :href="route('purchases.edit',{purchase:props.order[0].id})" class="flex ml-auto mb-2 text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">編集</Link>
                                    </div>
                                 </div>
                               </div>
                             </div>
                            </form>
                         </section>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
