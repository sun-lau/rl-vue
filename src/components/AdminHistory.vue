<template>
    <div class="AdminHistory">
        <v-card>
            <v-data-table dense :headers="headers" :items="api.historys"
                :search="search">
                <template v-slot:top>
                    <v-text-field
                    v-model="search"
                    label="Search"
                    class="mx-4"
                    ></v-text-field>
                </template>
            </v-data-table>
            
        </v-card>

    </div>
</template>

<script>
	import moment from 'moment';
    import {Admin_APIService} from '@/services/Admin_APIService';
    const apiService = new Admin_APIService(process.env.VUE_APP_BASE_URL);
    export default {
    name: 'AdminHistory',
    props: {
    },
    data:function(){
        return {
            search: '',
            api:{
                historys:[],
                result_message:""
            },
            headers: [
                { text: 'Date', value: 'date' },
                { text: 'Start At', value: 'start_at' },
                { text: 'End At', value: 'end_at' },
                { text: 'Experiment', value: 'experiment' },
                { text: 'Equipment ID', value: 'equipment_id' },
                { text: 'Username', value: 'username' },
                { text: 'Has Entered', value: 'has_entered' }
            ]
        }
    },
    computed: {
    },
    methods:{
    },
    mounted:function(){
        var self = this;
        apiService.listAllHistorys()
        .then((response) => {
            self.api.historys = response.historys;
        });
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>