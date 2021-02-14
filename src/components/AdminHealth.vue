<template>
    <div class="adminHealth">
        <v-card>
            <v-container>
                <v-row>
                    <v-col>
                        <v-btn @click="showCurrent">Scan</v-btn>
                    </v-col>
                    <v-col>
                        <v-btn @click="turnOn">Turn On Notification!</v-btn>
                    </v-col>
                    <v-col>
                        <v-btn @click="turnOff" color="error">Turn Off Notification!</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
    </div>
</template>

<script>
	import moment from 'moment';
    import {Admin_APIService} from '@/services/Admin_APIService';
    const apiService = new Admin_APIService(process.env.VUE_APP_BASE_URL);
    export default {
    name: 'AdminHealth',
    props: {
    },
    data:function(){
        return {
            
        }
    },
    computed: {
    },
    methods:{
        showCurrent(){
            window.open(
                process.env.VUE_APP_BASE_URL +
                "/api/health/scan.php"
            );
        },
        turnOn(){
            window.open(
                process.env.VUE_APP_BASE_URL +
                "/api/health/on_off.php?to=1"
            );
        },
        turnOff(){
            window.open(
                process.env.VUE_APP_BASE_URL +
                "/api/health/on_off.php?to=0"
            );
        }

    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>