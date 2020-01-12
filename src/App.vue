<template>
  <v-app>
    <v-app-bar
		app
		color="primary"
		dark
    >
      <div class="d-flex align-center">
        <h4 class="mt-1">RL 2</h4>
      </div>
      <v-spacer></v-spacer>
      <v-btn 
		class="mr-2"
		color="info"
      >Time Remaining: 40 mins</v-btn>
		<v-menu offset-y>
		<template v-slot:activator="{ on }">
			<v-btn
			color="info"
			dark
			v-on="on"
			>
				<v-icon>mdi-menu</v-icon>
			</v-btn>
		</template>
		<v-list>
			<v-list-item
			v-for="(item, index) in items"
			:key="index"
			>
			<v-list-item-title>{{ item.title }}</v-list-item-title>
			</v-list-item>
		</v-list>
		</v-menu>
    </v-app-bar>
    <v-content>
      	<router-view/>
    </v-content>
  </v-app>
</template>

<script>

export default {
  name: 'App',

  data: () => ({
      items: [
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me' },
        { title: 'Click Me 2' },
      ],
  }),
};
</script>
