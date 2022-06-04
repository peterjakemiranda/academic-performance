<template>
  <div>
    <Head title="Create Student" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/students">Students</Link>
      <span class="text-indigo-400 font-medium">/</span> Create
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.number" :error="form.errors.number" class="pb-8 pr-6 w-full lg:w-1/2" label="ID Number" />
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
          <select-input v-model="form.course_id" :error="form.errors.course_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Major">
            <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.name }}</option>
          </select-input>
          <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
          <text-input type="password" v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2" label="Password" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Student</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3'
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  props: {
    courses: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        number: '',
        name: '',
        course_id: null,
        email: this.student?.user?.email,
        password: '',
      }),
    }
  },
  mounted() {
    
  },
  methods: {
    store() {
      this.form.post('/students')
    },
  },
}
</script>
