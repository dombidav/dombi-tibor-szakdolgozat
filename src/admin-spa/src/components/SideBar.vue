<template>
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link to="/" class="brand-link">
      <img src="img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">ACS Admin Panel</span>
    </router-link>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <UserPanel/>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <router-link to="/" class="nav-link active">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Home
                <span class="right badge badge-danger">New</span>
              </p>
            </router-link>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>

<script lang="ts">
import {Options, Vue} from 'vue-class-component';
import UserPanel from "@/components/UserPanel.vue";

@Options({
  props: {},
  components: {
    UserPanel
  }
})
export default class SideBar extends Vue {

}
</script>

