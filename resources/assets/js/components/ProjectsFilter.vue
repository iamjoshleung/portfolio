<template>
    <div class="project-filters">
        <div class="level">
            <div class="level-right">
                <div @click="showFilters = !showFilters">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </div>
            </div>
        </div>

        <transition name="fade">
            <aside class="menu project-filters__controller" v-if="showFilters">
            <h1 class="menu-label project-filters__heading">Type</h1>
            <ul class="menu-list">
                <li>
                    <a href="#">Personal Projects</a>
                </li>
                <li>
                    <a href="#">Commercial Projects</a>
                </li>
            </ul>
            <h1 class="menu-label project-filters__heading">Tags</h1>
            <ul class="menu-list">
                <li>
                    <a href="#">PHP (Lavavel)</a>
                </li>
                <li>
                    <a href="#">VueJS</a>
                </li>
                <li>
                    <a href="#">Typescript</a>
                </li>
                <li>
                    <a href="#">SCSS</a>
                </li>
                <li>
                    <a href="#">PostCSS</a>
                </li>
            </ul>
        </aside>
        </transition>
    </div>
</template>

<script>
export default {
  data() {
    return {
      showFilters: false
    };
  }
};
</script>
