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
                </v-col>
                <v-col cols="12" xs="12" sm="6" md="6" lg="8" class="my-2 px-1">
                <div class="title">{{$route.params.experiment_name}}</div>
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
                                        @click="enterLab"
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
            self.getSlotsByDate();
        },
		methods:{
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
                apiService.getSlotsByDate(self.current_date)
                .then((response) => {
                    for(var slot of response.slots){
                        if(moment(slot.end_at) < moment()){
                            slot.display = false;
                        }else{
                            slot.display = true;

                        }
                    }
                    self.api.slots = response.slots;
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
            enterLab: function(){
                var self = this;
                self.$router.push("/experiment");

            }
		}
	}
</script>