<template>
  <div>
    <Head :title="`Edit GPA of ${grade.name}`" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/grades">Grades</Link>
      <span class="text-indigo-400 font-medium">/</span>
      Edit GPA ({{ grade?.student?.name }} #{{ grade?.student?.number }})
    </h1>
    <trashed-message v-if="grade.deleted_at" class="mb-6" @restore="restore"> This grade has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
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
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!grade.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Grade</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Grade</loading-button>
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
import TrashedMessage from '@/Shared/TrashedMessage'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    grade: Object,
    students: Array,
    school_years: Array,
    semesters: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        student_id: this.grade?.student?.id,
        school_year: this.grade.school_year,
        semester: this.grade.semester,
        gpa: this.grade.gpa,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/grades/${this.grade.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this grade?')) {
        this.$inertia.delete(`/grades/${this.grade.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this grade?')) {
        this.$inertia.put(`/grades/${this.grade.id}/restore`)
      }
    },
  },
}
</script>
