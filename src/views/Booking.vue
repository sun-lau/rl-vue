<template>
	<div class="booking">
        <v-card class="ma-4">
            <v-container>
            <v-row>
                <v-col cols="12" xs="12" sm="6" md="6" lg="4" class="my-2 px-1">
                <v-date-picker
                    class="ma-4"
                    ref="picker"
                    v-model="current_date"
                    full-width
                    @change="getSlotsByDate"
                ></v-date-picker>
                </v-col>
                <v-col cols="12" xs="12" sm="6" md="6" lg="8" class="my-2 px-1">
                <!-- <div class="title">{{$route.params.experiment_name}}</div> -->
                <!-- <div class="subheading">{{current_date}}</div> -->
                     <v-simple-table>
                        <template v-slot:default>
                        <thead>
                            <tr>
                            <th class="text-left">From</th>
                            <th class="text-left">To</th>
                            <th class="text-left">Room</th>
                            <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(slot, index) in api.slots" :key="index">
                                <template v-if="slot.display">
                                <td><p v-if="index==0 || api.slots[index-1].start_at!=api.slots[index].start_at">{{ slot.start_at | moment("HH:mm") }}</p></td>
                                <td><p v-if="index==0 || api.slots[index-1].end_at!=api.slots[index].end_at">{{ slot.end_at | moment("HH:mm") }}</p></td>
                                <td>{{ slot.equipment_id | roomName }}</td>
                                <td>
                                    <v-btn 
                                        v-if="slot.status=='IDLE'"
                                        @click="bookSlot(slot.id)"
                                    >Book</v-btn>
                                    <v-btn color="success"
                                        v-if="isBookedByMe(slot)"
                                        @click="enterLab(slot.id, slot.equipment_id, 'player')"
                                    >Enter Lab</v-btn>
                                    <v-btn color="info"
                                        v-if="isBookedByOthers(slot)"
                                        @click="enterLab(slot.id, slot.equipment_id, 'observer')"
                                    >Observe Lab</v-btn>
                                    <v-btn 
                                        v-if="isBookedSoon(slot)"
                                        @click="releaseSlot(slot.id)"
                                    >Cancel Booking</v-btn>
                                    <!-- <v-btn 
                                        v-if="slot.status == 'BOOKED' && slot.username != $cookies.get('username')"
                                        disabled
                                    >Not Available</v-btn> -->
                                </td>
                                </template>
                            </tr>
                        </tbody>
                        </template>
                    </v-simple-table>
                </v-col>
            </v-row>
            </v-container>
        </v-card>
	</div>
</template>
<script>
	import moment from 'moment';
    import {Booking_APIService} from '@/services/Booking_APIService';
    const apiService = new Booking_APIService(process.env.VUE_APP_BASE_URL);
	export default {
		name: 'booking',
		components: {
		},
        data: () => ({
            current_date: new Date().toISOString().substr(0, 10),
            api:{
                slots: [
                ]
            }
        }),
        filters: {
            roomName: function (value) {
                switch (value){
                    case "set_0":
                    return "Room 1"
                    case "set_1":
                    return "Room 2" 
                    case "set_2":
                    return "Room 3" 
                }
            }
        },
        mounted () {
            var self = this;
            self.assignEquipmentId();
            self.getSlotsByDate();
            console.log("username");
            console.log(self.$cookies.get("username"));
        },
        watch: {
            $route(to, from) {
                //change from one experiment to another
                var self = this;
                self.assignEquipmentId();
                self.getSlotsByDate();
            }
        },
		methods:{
            assignEquipmentId: function(){
                var self = this;
                switch(self.$route.params.experiment_name){
                    case "interference":
                        self.experiment = "INTERFERENCE";
                    break;
                    case "visible_spectrum":
                        self.experiment = "VISIBLE_SPECTRUM";
                    break;
                    case "apparent_depth":
                        self.experiment = "APPARENT_DEPTH";
                    break;
                    case "bacteria_growth":
                        self.experiment = "BACTERIA_GROWTH";
                    break;
                    case "em_induction":
                        self.experiment = "EM_INDUCTION";
                    break;
                }
            },
            isBookedByMe: function(slot){
                if(moment(slot.start_at) < moment() 
                    && slot.status == 'BOOKED' 
                    && slot.username == $cookies.get('username')){
                        return true;
                }
                else{
                    return false;
                }
            },
            isBookedByOthers: function(slot){
                if(moment(slot.start_at) < moment() 
                    && slot.status == 'BOOKED' 
                    && slot.username != $cookies.get('username')
                    && self.experiment == "BACTERIA_GROWTH"){
                        return true;
                }
                else{
                    return false;
                }
            },
            isBookedSoon: function(slot){
                if(moment(slot.start_at) > moment() 
                    && slot.status == 'BOOKED' 
                    && slot.username == $cookies.get('username')){
                        return true;
                }
                else{
                    return false;
                }
            },
            getSlotsByDate: function(){
                var self = this;
                console.log("getSlotsByDate: " + self.current_date);
                self.api.slots = [];
                apiService.getSlotsByDate(self.experiment, self.current_date)
                .then((response) => {
                    if(typeof response.slots != 'undefined'){
                        for(var slot of response.slots){
                            if(moment(slot.end_at) < moment()){
                                slot.display = false;
                            }else{
                                slot.display = true;

                            }
                        }
                        self.api.slots = response.slots;
                    }else{
                        alert("No Slots Assigned From Admin");
                    }
                });
            },
            bookSlot: function(slot_id){
                var self = this;
                apiService.bookSlot(slot_id, self.$cookies.get('auth_token'))
                .then((response) => {
                    if(response.status == "fail"){
                        self.$store.commit('showSnackBar', response.message);
                    }else{
                        self.$store.commit('showSnackBar', "Book Success");
                        self.getSlotsByDate();
                    }
                });

            },
            releaseSlot: function(slot_id){
                var self = this;
                apiService.releaseSlot(slot_id, self.$cookies.get('auth_token'))
                .then((response) => {
                    self.$store.commit('showSnackBar', "Booking Cancelled");
                    self.getSlotsByDate();
                });

            },
            enterLab: function(slot_id, equipment_id, role){
                var self = this;
                apiService.enterLab(slot_id, self.$cookies.get('auth_token'),role)
                .then((response) => {
                    if(response.status == "fail"){
                        self.$store.commit('showSnackBar', response.message);
                    }else{
                        self.$store.commit('showSnackBar', "Preparing...");
                        self.$cookies.set('session_token', response.session_token);
                        self.$cookies.set('role', role);
                        var kick_time = 3600-60-parseInt(moment().format("mm"))*60-parseInt(moment().format("ss"));    //in seconds to next hour (-1 min)
                        self.$cookies.set('kick_time', kick_time);
                        self.$cookies.set('equipment_id', equipment_id);
                        self.$router.push("/experiment?name="+self.$route.params.experiment_name);
                    }
                });
            }
		}
	}
</script>