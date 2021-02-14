<template>
    <div class="adminBacteria">
        <v-card>
            <v-container>
                <v-row>
                    <v-col>
                        <v-btn @click="downloadAllPhotos">Download All Photos</v-btn>
                    </v-col>
                    <v-col>
                        <v-btn @click="removeAllPhotos" color="error">Remove All Photos</v-btn>
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
    name: 'AdminBacteria',
    props: {
    },
    data:function(){
        return {
            
        }
    },
    computed: {
    },
    methods:{
        downloadAllPhotos(){
            var self = this;
            apiService.downloadAllBacteriaPhotos(
                'BACTERIA_GROWTH',
                'set_0',
                function () {
                window.open(
                    process.env.VUE_APP_BASE_URL +
                    "/api/experiment/storage/" +
                    self.experiment_name +
                    "-" +
                    self.$route.params.equipment_name +
                    "-archive.zip"
                );
                }
            );
        },
        removeAllPhotos(){
            var self = this;
            apiService.removeAllBacteriaPhotos(
                'BACTERIA_GROWTH',
                'set_0',
                function () {
                    alert('Removed All photos');
                }
            );
        }

    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>