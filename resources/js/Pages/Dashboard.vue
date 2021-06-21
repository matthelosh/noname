<template>
    <div id="app">
        <v-app>
            <v-app-bar dense dark color="primary">
                <v-app-bar-nav-icon>
                    NN
                </v-app-bar-nav-icon>
                <v-app-bar-title>No Name</v-app-bar-title>
                <v-spacer></v-spacer>
                <v-btn icon>
                    <v-icon>mdi-bell</v-icon>
                </v-btn>
                <v-avatar>
                        <img
                            src="https://cdn.vuetifyjs.com/images/john.jpg"
                            alt="John"
                        >
                </v-avatar>
                <v-app-bar-nav-icon @click.stop="drawer = !drawer">
                </v-app-bar-nav-icon>
            </v-app-bar>
            <v-container class="fill-height">
                <slot />
            </v-container>

            <v-navigation-drawer
            v-model="drawer"
            class="fill-height"
            :permanent="$vuetify.breakpoint.mdAndUp"
            absolute
            >
            <v-list-item>
                <v-list-item-avatar>
                <v-img src="https://randomuser.me/api/portraits/men/78.jpg"></v-img>
                </v-list-item-avatar>

                <v-list-item-content>
                <v-list-item-title>John Leider</v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-divider></v-divider>

            <v-list dense>
                <v-list-item
                v-for="item in items"
                :key="item.title"
                link
                :href="item.url"
                >
                <!-- <inertia-link :href="item.url"> -->
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                <!-- </inertia-link> -->
                </v-list-item>
            </v-list>
            </v-navigation-drawer>
        </v-app>
    </div>
    
</template>

<script>
export default {
    data () {
      return {
        drawer: true,
        items: [
          { title: 'Home', icon: 'mdi-view-dashboard', url: '/dashboard' },
          { title: 'About', icon: 'mdi-forum', url: "/forum" },
        ],
      }
    },
}
</script>

<style scoped>

</style>