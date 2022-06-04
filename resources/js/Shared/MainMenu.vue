<template>
  <div>
    <div class="mb-4" v-if="$page.props.auth.user?.admin">
      <Link class="group flex items-center py-3" href="/">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </Link>
    </div>
    <div class="mb-4" v-if="$page.props.auth.user?.role == 'student'">
      <Link class="group flex items-center py-3" :href="`/users/${$page.props.auth.user.id}/edit`">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl(`users/${$page.props.auth.user.id}/edit`) ? 'text-white' : 'text-indigo-300 group-hover:text-white'">My Profile</div>
      </Link>
      <Link class="group flex items-center py-3" href="/student-dashboard">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
        <div :class="isUrl('student-dashboard') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">My Dashboard</div>
      </Link>
    </div>
      <div class="mb-4" v-if="$page.props.auth.user?.admin">
        <Link class="group flex items-center py-3" href="/students">
          <icon name="students" class="mr-1 -ml-1 w-4 h-4" :class="isUrl('students') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
          <div :class="isUrl('students') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Students</div>
        </Link>
      </div>
      <div class="mb-4" v-if="['admin', 'registrar'].includes($page.props.auth.user?.role)">
        <Link class="group flex items-center py-3" href="/grades">
          <icon name="gpa" class="mr-1 -ml-1 w-4 h-4" :class="isUrl('grades') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
          <div :class="isUrl('grades') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">GPA</div>
        </Link>
      </div>
      <div class="mb-4" v-if="$page.props.auth.user?.admin">
        <Link class="group flex items-center py-3" href="/users">
          <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('users') ? 'fill-white' : 'fill-indigo-400 group-hover:fill-white'" />
          <div :class="isUrl('users') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Users</div>
        </Link>
      </div>
  </div>

</template>

<script>
import { Link } from '@inertiajs/inertia-vue3'
import Icon from '@/Shared/Icon'

export default {
  components: {
    Icon,
    Link,
  },
  methods: {
    isUrl(...urls) {
      let currentUrl = this.$page.url.substr(1)
      if (urls[0] === '') {
        return currentUrl === ''
      }
      return urls.filter((url) => currentUrl.startsWith(url)).length
    },
  },
}
</script>
