<script setup>
import axios from 'axios';
import { onMounted, ref ,reactive} from 'vue'

const search =ref('');
const customers =reactive({});
const searchCustomers = async () => {
    try{
        await axios.get(`/api/searchCustomers/?search=${search.value}`)
        .then(res=>{
            customers.value = res.data
        })
        toggleStatus()
    }catch(e){
        console.log(e.message);
    }
}

onMounted(()=>{
    axios.get('/api/user')
    .then( res =>{
        console.log(res);
    })
})

const isShow = ref(false)
const toggleStatus = () => { isShow.value = !isShow.value}

const emit = defineEmits(['update:customerId'])
const setCustomer = e => {
    search.value=e.kana
    emit('update:customerId',e.id)
    toggleStatus()
}
</script>
<template>
    <div v-show="isShow" class="modal" id="modal-1" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
      <div class="modal__container w-2/3" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
        <header class="modal__header">
          <h2 class="modal__title" id="modal-1-title">
            顧客検索
          </h2>
          <button type="button" @click="toggleStatus" class="modal__close" aria-label="Close modal" data-micromodal-close></button>
        </header>
        <main class="modal__content" id="modal-1-content">
            <div v-if="customers.value">
                <table class="table-auto w-full text-left whitespace-no-wrap">
                  <thead>
                    <tr>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">Id</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100 rounded-tl rounded-bl">氏名</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">カナ</th>
                      <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-100">電話番号</th>
                    </tr>
                  </thead>
                  <tbody>
                      <tr v-for="customer in customers.value.data" :key="customer.id">
                          <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">
                            <button type="button" class="text-blue-500" @click="setCustomer({id:customer.id,kana:customer.kana})">
                                {{ customer.id }}
                            </button>
                        </td>
                          <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">{{ customer.name }}</td>
                          <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">{{ customer.kana }}</td>
                          <td class="border-t-2 border-b-2 border-gray-200 px-4 py-3">{{ customer.tel }}</td>
                        </tr>
                  </tbody>
                </table>
            </div>
        </main>
        <footer class="modal__footer">
          <button type="button" @click="toggleStatus" class="modal__btn" data-micromodal-close aria-label="Close this dialog window">Close</button>
        </footer>
      </div>
    </div>
  </div>
  <input type="text" name="customer" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 mb-2 leading-8 transition-colors duration-200 ease-in-out" v-model="search">
  <button type="button" @click="searchCustomers" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg"  data-micromodal-trigger="modal-1">検索する</button>
</template>
