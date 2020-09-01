<template>
  <div>
    <!-- begin #header -->
    <div id="header" class="header navbar-default">
      <!-- begin navbar-header -->
      <div class="navbar-header">
        <router-link to="/home" class="navbar-brand">
          <b>Onlyput</b> Dashboard
        </router-link>
        <button
          type="button"
          class="navbar-toggle"
          v-on:click="toggleMobileSidebar"
          v-if="!pageOptions.pageWithoutSidebar"
        >
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
      </div>
      <!-- end navbar-header -->

      <!-- begin header-nav -->
      <ul class="navbar-nav navbar-right">
        <b-nav-item-dropdown
          menu-class="media-list dropdown-menu-right"
          toggle-class="f-s-14"
          no-caret
        >
          <template slot="button-content">
            <i class="fa fa-bell"></i>
            <span class="label">0</span>
          </template>
          <b-dropdown-header>NOTIFICATIONS (0)</b-dropdown-header>
          <b-dropdown-item href="javascript:;" class="text-center width-300">No notification found</b-dropdown-item>
        </b-nav-item-dropdown>
        <b-nav-item-dropdown menu-class="dropdown-menu-right" class="dropdown navbar-user" no-caret>
          <template slot="button-content">
            <div class="image image-icon bg-black text-grey-darker">
              <i class="fa fa-user"></i>
            </div>
            <span class="d-none d-md-inline">Adam Schwartz</span>
            <b class="caret"></b>
          </template>
          <b-dropdown-item href="javascript:;">Edit Profile</b-dropdown-item>
          <b-dropdown-item href="javascript:;">
            <span class="badge badge-danger pull-right">0</span> Inbox
          </b-dropdown-item>
          <b-dropdown-item href="javascript:;">Calendar</b-dropdown-item>
          <b-dropdown-item href="javascript:;">Setting</b-dropdown-item>
          <b-dropdown-divider></b-dropdown-divider>
          <b-dropdown-item href="javascript:;">Log Out</b-dropdown-item>
        </b-nav-item-dropdown>
      </ul>
      <!-- end header navigation right -->
    </div>
    <!-- end #header -->
  </div>
</template>

<script>
import PageOptions from "@/config/PageOptions.vue";

export default {
  name: "Header",
  data() {
    return {
      pageOptions: PageOptions
    };
  },
  methods: {
    toggleMobileSidebar() {
      this.pageOptions.pageMobileSidebarToggled = !this.pageOptions
        .pageMobileSidebarToggled;
    },
    toggleMobileRightSidebar() {
      this.pageOptions.pageMobileRightSidebarToggled = !this.pageOptions
        .pageMobileRightSidebarToggled;
    },
    toggleMobileTopMenu() {
      this.pageOptions.pageMobileTopMenu = !this.pageOptions.pageMobileTopMenu;
    },
    toggleMobileMegaMenu() {
      this.pageOptions.pageMobileMegaMenu = !this.pageOptions
        .pageMobileMegaMenu;
    },
    toggleRightSidebar() {
      this.pageOptions.pageRightSidebarToggled = !this.pageOptions
        .pageRightSidebarToggled;
    },
    toggleRightSidebarCollapsed() {
      this.pageOptions.pageRightSidebarCollapsed = !this.pageOptions
        .pageRightSidebarCollapsed;
    },
    checkForm: function(e) {
      e.preventDefault();
      this.$router.push({ path: "/extra/search" });
    }
  }
};
</script>
