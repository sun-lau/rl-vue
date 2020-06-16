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
                <v-btn @click="enterLab">Demo Enter</v-btn>
                <v-btn @click="observeLab">Observe Laboratory</v-btn>
                </v-col>
                <v-col cols="12" xs="12" sm="6" md="6" lg="8" class="my-2 px-1">
                <!-- <div class="title">{{$route.params.experiment_name}}</div> -->
                <div class="subheading">{{current_date}}</div>
                     <v-simple-table height="300px">
                        <template v-slot:default>
                        <thead>
                            <tr>
                            <th class="text-left">From</th>
                            <th class="text-left">To</th>
                            <th class="text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="slot in api.slots" :key="slot.id">
                                <template v-if="slot.display">
                                <td>{{ slot.start_at | moment("HH:mm") }}</td>
                                <td>{{ slot.end_at | moment("HH:mm") }}</td>
                                <td>
                                    <v-btn 
                                        v-if="slot.status=='IDLE'"
                                        @click="bookSlot(slot.id)"
                                    >Book</v-btn>
                                    <v-btn color="success"
                                        v-if="isBookedNow(slot)"
                                        @click="enterLab(slot.id)"
                                    >Enter Lab</v-btn>
                                    <v-btn 
                                        v-if="isBookedSoon(slot)"
                                        @click="releaseSlot(slot.id)"
                                    >Cancel Booking</v-btn>
                                    <v-btn 
                                        v-if="slot.status == 'BOOKED' && slot.username != $cookies.get('username')"
                                        disabled
                                    >Not Available</v-btn>
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
        
        mounted () {
            var self = this;
            self.assignEquipmentId();
            self.getSlotsByDate();
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
                    case "visible_spectrum":
                        self.equipment_id = "xcvbnm";
                    break;
                    case "apparent_depth":
                        self.equipment_id = "zxcvbn";
                    break;
                }
            },
            isBookedNow: function(slot){
                if(moment(slot.start_at) < moment() 
                    && slot.status == 'BOOKED' 
                    && slot.username == $cookies.get('username')){
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
                apiService.getSlotsByDate(self.equipment_id, self.current_date)
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
                apiService.bookSlot(slot_id, self.$cookies.get('username'))
                .then((response) => {
                    alert("Book Success");
                    self.getSlotsByDate();
                });

            },
            releaseSlot: function(slot_id){
                var self = this;
                apiService.releaseSlot(slot_id, self.$cookies.get('username'))
                .then((response) => {
                    alert("Booking Canceled");
                    self.getSlotsByDate();
                });

            },
            enterLab: function(slot_id){
                var self = this;
                console.log("enter lab");
                console.log(slot_id);
                var kick_time = 3600-60-parseInt(moment().format("mm"))*60-parseInt(moment().format("ss"));    //in seconds to next hour (-1 min)
                self.$cookies.set('kick_time', kick_time);
                self.$store.dispatch('getToken', {
                    username: self.$cookies.get('username'), 
                    slot_id: slot_id
                    }).then(() => {
                    // console.log(self.$store.getters.role );
                    self.$cookies.set('equipment_id', "set_0");
                    self.$router.push("/experiment?name="+self.$route.params.experiment_name);
                });
                // self.$cookies.set('equipment_id', "set_0");
                // self.$cookies.set('token', "aaaaaa");
                // self.$router.push("/experiment?name="+self.$route.params.experiment_name);
            },
            observeLab: function(){
                var self = this;
                var kick_time = 3600-60-parseInt(moment().format("mm"))*60-parseInt(moment().format("ss"));    //in seconds to next hour (-1 min)
                self.$cookies.set('kick_time', kick_time);
                self.$cookies.set('equipment_id', "set_0");
                self.$cookies.set('token', "bbbbbb");
                self.$router.push("/experiment?name="+self.$route.params.experiment_name);
            }
		}
	}
</script>