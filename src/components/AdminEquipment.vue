<template>
    <div class="adminEquipment">
        <v-card>
            <v-data-table dense 
                group-by="experiment"
                :headers="headers" 
                :items="api.equipments" 
                item-key="id">
                <template v-slot:item.command_set_at="{ item }">
                    {{ formatDate(item.command_set_at) }}
                </template>
                <template v-slot:item.command_got_at="{ item }">
                    
                    <v-icon v-if="isOverOneDay(item.command_got_at)" color="red">mdi-alert</v-icon>{{ formatDate(item.command_got_at) }}
                </template>
                <template v-slot:item.value_set_at="{ item }">
                    {{ formatDate(item.value_set_at) }}
                </template>
                <template v-slot:item.value_got_at="{ item }">
                    {{ formatDate(item.value_got_at) }}
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
    name: 'AdminEquipment',
    props: {
    },
    data:function(){
        return {
            api:{
                equipments:[],
            },
            headers: [
                { text: 'Experiment', value: 'experiment' },
                { text: 'Set', value: 'equipment_id' },
                { text: 'Device ID', value: 'device_id' },
                { text: 'Command', value: 'command' },
                { text: 'Value', value: 'value' },
                { text: 'Last Command time set by client', value: 'command_set_at' },
                { text: 'Last Value time got by client', value: 'value_got_at' },
                { text: 'Last Command time got by Hardware', value: 'command_got_at' },
                { text: 'Last Value time set by Hardware', value: 'value_set_at' },
            ]
        }
    },
    computed: {
    },
    methods:{
        formatDate(value) {
            if(value == 0){
                return "";
            }else{
                return moment(value*1000).fromNow();
            }
        },
        isOverOneDay(target){
            var d = Math.floor(Date.now() / 1000);
            console.log("d-target");
            console.log(d-parseInt(target));
            if(((d-parseInt(target)) > 60*60*24)&&target!=0){
                return true;
            }else{
                return false;
            }
        }
    },
    mounted:function(){
        var self = this;
        apiService.listAllEquipments()
        .then((response) => {
            self.api.equipments = response.equipments;
        });
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>