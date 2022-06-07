<template>
  <div>
    <Head :title="`${form.name}`" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/students">Students</Link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }} #{{ form.number }}
    </h1>
    <trashed-message v-if="student.deleted_at" class="mb-6" @restore="restore"> This student has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.number" :error="form.errors.number" class="pb-8 pr-6 w-full lg:w-1/2" label="Student Number" />
          <text-input v-model="form.name" :error="form.errors.name" class="pb-8 pr-6 w-full lg:w-1/2" label="Name" />
          <select-input v-model="form.course_id" :error="form.errors.course_id" class="pb-8 pr-6 w-full lg:w-1/2" label="Major">
            <option v-for="course in courses" :key="course.id" :value="course.id">{{ course.name }}</option>
          </select-input>
          <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
          <text-input type="password" v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2" label="Password" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!student.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Student</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Student</loading-button>
        </div>
      </form>
    </div>
    <div class="w-1/2 ml-10 bg-white rounded-md shadow overflow-hidden"  v-if="user?.grades?.length">
      <grade-list :grades="user.grades"/>
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
import GradeList from '@/Shared/GradeList'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
    GradeList
  },
  layout: Layout,
  props: {
    student: Object,
    courses: Array,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        number: this.student.number,
        name: this.student.name,
        email: this.student?.user?.email,
        password: '',
        course_id: this.student.course_id,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/students/${this.student.id}`)
    },
    destroy() {
      if (confirm('Are you sure you want to delete this student?')) {
        this.$inertia.delete(`/students/${this.student.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this student?')) {
        this.$inertia.put(`/students/${this.student.id}/restore`)
      }
    },
  },
}
</script>
