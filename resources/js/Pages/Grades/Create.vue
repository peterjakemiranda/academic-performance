<template>
  <div>
    <Head title="Create Grade Point Average (GPA)" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/grades">Grades</Link>
      <span class="text-indigo-400 font-medium">/</span> Create GPA
    </h1>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="store">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <select-input v-model="form.student_id" :error="form.errors.student_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Student">
            <option v-for="student in students" :key="student.id" :value="student.id">{{ student.name }}</option>
          </select-input>
          <select-input v-model="form.school_year" :error="form.errors.school_year" class="pb-8 pr-6 w-full lg:w-1/2" label="School Year">
            <option v-for="school_year in school_years" :key="school_year" :value="school_year">{{ school_year }}</option>
          </select-input>
          <select-input v-model="form.semester" :error="form.errors.semester" class="pb-8 pr-6 w-full lg:w-1/2" label="Semester">
            <option v-for="semester in semesters" :key="semester" :value="semester">{{ semester }}</option>
          </select-input>
          <text-input v-model="form.gpa" :error="form.errors.gpa" class="pb-8 pr-6 w-full lg:w-1/2" label="GPA" />
        </div>
        <div class="flex items-center justify-end px-8 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo" type="submit">Create Grade</loading-button>
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
    students: Array,
    school_years: Array,
    semesters: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        student_id: null,
        school_year: this.school_years[this.school_years.length - 1],
        semester: '',
        gpa: '',
      }),
    }
  },
  mounted() {
    
  },
  methods: {
    store() {
      this.form.post('/grades')
    },
  },
}
</script>
