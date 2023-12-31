<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia';
import { Head,Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    customer:Object,
    errors:Array
})

const form = reactive({
    id:props.customer.id,
    name:props.customer.name,
    kana:props.customer.kana,
    tel:props.customer.tel,
    email:props.customer.email,
    postcode:props.customer.postcode,
    address:props.customer.address,
    birthday:props.customer.birthday,
    gender:props.customer.gender,
    memo:props.customer.memo,
})

const updateCustomer = id => {
    Inertia.put(route('customers.update',{customer:id}),form)
}
</script>

<template>
    <Head title="顧客情報編集" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">顧客情報編集</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <section class="text-gray-600 body-font relative">
                            <form @submit.prevent="updateCustomer(form.id)">
                             <div class="container px-5 py-8 mx-auto">
                               <div class="lg:w-1/2 md:w-2/3 mx-auto">
                                 <div class="flex flex-wrap -m-2">
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="name" class="leading-7 text-sm text-gray-600">氏名</label>
                                       <input type="text" id="name" name="name" v-model="form.name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                       <div v-if="errors.name" class="text-red-500">氏名は必ず入力してください</div>
                                     </div>
                                   </div>
                                    <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="kana" class="leading-7 text-sm text-gray-600">フリガナ</label>
                                       <input type="kana" id="kana" name="kana" v-model="form.kana" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                       <div v-if="errors.kana" class="text-red-500">{{ errors.kana }}</div>
                                     </div>
                                   </div>
                                    <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="tel" class="leading-7 text-sm text-gray-600">電話番号</label>
                                       <input type="tel" id="tel" name="tel" v-model="form.tel" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                       <div v-if="errors.tel" class="text-red-500">{{ errors.tel }}</div>
                                     </div>
                                   </div>
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                                       <input type="email" id="email" name="email" v-model="form.email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                       <div v-if="errors.email" class="text-red-500">{{ errors.email }}</div>
                                     </div>
                                   </div>
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="postcode" class="leading-7 text-sm text-gray-600">郵便番号</label>
                                       <input type="number" @change="fetchAddress" id="postcode" name="postcode" v-model="form.postcode" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                       <div v-if="errors.postcode" class="text-red-500">{{ errors.postcode }}</div>
                                     </div>
                                   </div>
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="address" class="leading-7 text-sm text-gray-600">住所</label>
                                       <input type="text" id="address" name="address" v-model="form.address" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                       <div v-if="errors.address" class="text-red-500">{{ errors.address }}</div>
                                     </div>
                                   </div>
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="birthday" class="leading-7 text-sm text-gray-600">誕生日</label>
                                       <input type="date" id="birthday" name="birthday" v-model="form.birthday" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                       <div v-if="errors.birthday" class="text-red-500">{{ errors.birthday }}</div>
                                     </div>
                                   </div>
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label class="leading-7 text-sm text-gray-600">性別</label>
                                         <ul class="w-48 text-sm font-medium text-gray-900 bg-white   rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                            <div v-if="errors.gender" class="text-red-500">{{ errors.gender }}</div>
                                           <li class="w-full  rounded-t-lg">
                                               <div class="flex items-center pl-3">
                                                   <input type="radio" v-model="form.gender" value=0 name="gender" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                   <label class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">男性</label>
                                               </div>
                                           </li>
                                           <li class="w-full rounded-t-lg">
                                               <div class="flex items-center pl-3">
                                                   <input type="radio" v-model="form.gender" value=1 name="gender" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                   <label class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">女性</label>
                                               </div>
                                           </li>
                                           <li class="w-full rounded-t-lg">
                                               <div class="flex items-center pl-3">
                                                   <input type="radio" v-model="form.gender" value=2 name="gender" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                   <label class="w-full py-3 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">指定無し</label>
                                               </div>
                                           </li>
                                         </ul>
                                     </div>
                                   </div>
                                   <div class="p-2 w-full">
                                     <div class="relative">
                                       <label for="memo" class="leading-7 text-sm text-gray-600">メモ</label>
                                       <input type="text" id="memo" name="memo" v-model="form.memo" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                       <div v-if="errors.memo" class="text-red-500">{{ errors.memo }}</div>
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
