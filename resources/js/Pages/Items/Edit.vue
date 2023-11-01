<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import { Head,Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    item:Object,
    errors:Array
})

const form = reactive({
    id:props.item.id,
    name:props.item.name,
    memo:props.item.memo,
    price:props.item.price,
    is_selling:props.item.is_selling,
})

const updateItem = id => {
    Inertia.put(route('items.update',{item:id}),form)
}
</script>

<template>
    <Head title="商品編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">商品編集</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="updateItem(form.id)">
                             <div class="container px-5 py-24 mx-auto">
                               <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                 <div class="flex flex-wrap -m-2">
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="name" class="leading-7 text-sm text-gray-600">商品名</label>
                                       <input type="text" id="name" name="name" v-model="form.name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                       <div v-if="errors.name" class="text-red-500">{{ errors.name }}</div>
                                     </div>
                                   </div>
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                       <textarea id="memo" name="memo" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 h-32 text-base outline-none text-gray-700 py-1 px-3 resize-none leading-6 transition-colors duration-200 ease-in-out"></textarea>
                                       <div v-if="errors.memo" class="text-red-500">{{ errors.memo }}</div>
                                     </div>
                                   </div>
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="price" class="leading-7 text-sm text-gray-600">価格</label>
                                       <input type="number" id="price" name="price" v-model="form.price" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                       <div v-if="errors.price" class="text-red-500">{{ errors.price }}</div>
                                     </div>
                                   </div>
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label class="leading-7 text-sm text-gray-600">ステータス</label>
                                         <ul class="w-48 text-sm font-medium text-gray-900 bg-white   rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <div v-if="errors.is_selling" class="text-red-500">{{ errors.is_selling }}</div>
                                           <li class="w-full  rounded-t-lg">
                                               <div class="flex items-center pl-3">
                                                   <input type="radio" v-model="form.is_selling" value=1 name="is_selling" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                   <label class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">販売中</label>
                                               </div>
                                           </li>
                                           <li class="w-full rounded-t-lg">
                                               <div class="flex items-center pl-3">
                                                   <input type="radio" v-model="form.is_selling" value=0 name="is_selling" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                   <label class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">停止中</label>
                                               </div>
                                           </li>
                                         </ul>
                                     </div>
                                   </div>
                                   <div class="p-2 w-full">
                                     <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">更新</button>
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
