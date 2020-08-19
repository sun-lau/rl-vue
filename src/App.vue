<template>
  <v-app id="inspire">
    <v-navigation-drawer
      v-if="$route.query.site_mode==1"
      v-model="drawer"
      :clipped="$vuetify.breakpoint.lgAndUp"
      app
    >
      <v-list>
        <template v-for="item in side_items">
          <v-row
            v-if="item.heading"
            :key="item.heading"
            align="center"
          >
            <v-col cols="6">
              <v-subheader v-if="item.heading">
                {{ item.heading }}
              </v-subheader>
            </v-col>
            <v-col
              cols="6"
              class="text-center"
            >
              <a
                href="#!"
                class="body-2 black--text"
              >EDIT</a>
            </v-col>
          </v-row>
          <v-list-group
            v-else-if="item.children"
            :key="item.text"
            v-model="item.model"
            :prepend-icon="item.model ? item.icon : item['icon-alt']"
            append-icon=""
          >
            <template v-slot:activator>
              <v-list-item-content @click="goTo(item.link)">
                <v-list-item-title>
                  {{ item.text }}
                </v-list-item-title>
              </v-list-item-content>
            </template>
            <v-list-item
              v-for="(child, i) in item.children"
              :key="i"
              link
				@click="goTo(child.link)"
            >
              <v-list-item-action v-if="child.icon">
                <v-icon>{{ child.icon }}</v-icon>
              </v-list-item-action>
              <v-list-item-content>
                <v-list-item-title>
                  {{ child.text }}
                </v-list-item-title>
              </v-list-item-content>
            </v-list-item>
          </v-list-group>
          <v-list-item
            v-else-if="item.show"
            :key="item.text"
            link
			@click="goTo(item.link)"
          >
            <v-list-item-action>
              <v-icon>{{ item.icon }}</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                {{ item.text }}
              </v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </template>
      </v-list>
      <v-list>
		  <v-list-item v-if="!$cookies.get('username')"
		   @click="goTo('/login')"
		  >
            <v-list-item-action>
              <v-icon>mdi-key</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                Login
              </v-list-item-title>
            </v-list-item-content>
		  </v-list-item>
		  
		  <v-list-item v-if="$cookies.get('username')"
		   @click="goTo('/logout')"
		   >
            <v-list-item-action>
              <v-icon>mdi-key</v-icon>
            </v-list-item-action>
            <v-list-item-content>
              <v-list-item-title>
                Logout
              </v-list-item-title>
            </v-list-item-content>
		  </v-list-item>
      </v-list>

    </v-navigation-drawer>

    <v-app-bar
      v-if="$route.query.site_mode==1"
      :clipped-left="$vuetify.breakpoint.lgAndUp"
      app
      color="blue darken-3"
      dark
    >
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title
        style="width: 300px"
        class="ml-0 pl-4"
      >
        <span class="hidden-sm-and-down">RemoteLab</span>
      </v-toolbar-title>
      <v-spacer />


		<div class="p-2 mt-2" style="cursor:pointer" @click="changeLang('en')">ENG</div>
		<div class="p-2 mt-2" style="cursor:pointer" @click="changeLang('zh-hk')">繁</div>

    </v-app-bar>
    <v-content>
		<router-view class="ma-4"/>
    </v-content>
	<v-snackbar
      v-model="$store.getters.snackbar.modal"
    >
      {{ $store.getters.snackbar.message }}

      <template v-slot:action="{ attrs }">
        <v-btn
          color="pink"
          text
          v-bind="attrs"
          @click="snackbar = false"
        >
          Close
        </v-btn>
      </template>
    </v-snackbar>
    
		<small class="ma-4">0819.1 
      <span v-if="$cookies.get('username')" @click="goTo('/logout')">Logout</span>
    </small>
  </v-app>
</template>

<script>
  export default {
    props: {
      source: String,
    },
    data: () => ({
		auth_token:"",
		dialog: false,
		drawer: null,
		side_items: [
			{ 
				icon: 'mdi-home',
				text: 'Home',
				link: '/home',
				show: true
			},
			{ 
				icon: 'mdi-history',
				text: 'About',
				link: '/about',
				show: true
			},
			{ 
				icon: 'mdi-lightbulb-on', 
				text: 'Concept and Benefits',
				link: '/concept',
				show: true

			},
			{ 
				icon: 'mdi-bullhorn', 
				text: 'News',
				link: '/news',
				show: true
			},
			{
				icon: 'mdi-chevron-up',
				'icon-alt': 'mdi-chevron-down',
				text: 'Remote Experiments',
				model: false,
				children: [
					{ 
						// icon: 'mdi-food-apple',
						text: 'Physics',
						show: true
					},
					{ 
						icon: 'mdi-minus',
						text: 'Interference',
						link: '/booking/interference',
						show: true
					},
					{ 
						icon: 'mdi-minus',
						text: 'Apparent depth',
						link: '/booking/apparent_depth',
						show: true
					},
					{ 
						// icon: 'mdi-test-tube',
						text: 'Chemistry',
						show: true
					},
					{ 
						icon: 'mdi-minus',
						text: 'Visible Spectrum',
						link: '/booking/visible_spectrum',
						show: true
					},
					{ 
						// icon: 'mdi-human-handsdown',
						text: 'Biology',
						show: true
					},
					{ 
						icon: 'mdi-minus',
						text: 'Bacteria Growth',
						link: '/booking/bacteria_growth',
						show: true
					},
				],
			}
		],
	}),
	
	mounted:function(){
		var self = this;
	},
	methods:{
		
		goTo: function(name){
			var self = this;
			console.log("goto" + name);
			self.$router.push(name);
		},
		changeLang: function(lang){
			var self = this;
			self.$i18n.locale = lang;
		}
	}
  }
</script>