<template>
	<div class="admin">
        <v-card class="ma-4">
            <v-container>
                <v-row>
                    <v-col cols="12" xs="12" sm="6" md="6" lg="4" class="my-2 px-1">
                        <v-date-picker 
                        full-width v-model="dates" range></v-date-picker>
                        </v-col>
                    <v-col cols="12" xs="12" sm="6" md="6" lg="8" class="my-2 px-1">
                        <v-text-field v-model="dateRangeText" label="Date range" readonly></v-text-field>
                        <v-btn class="ma-4" @click="checkSlots">Check Booking Slots</v-btn>
                        <hr>
                        <v-row>
                            <v-col>
                                <v-select
                                :items="experiments"
                                item-text="text"
                                item-value="value"
                                v-model="form.experiment"
                                label="Experiment"
                                ></v-select>
                            </v-col>
                            <v-col>
                                <v-select
                                :items="equipment_ids"
                                item-text="text"
                                item-value="value"
                                v-model="form.equipment_id"
                                label="Equipment ID"
                                ></v-select>
                            </v-col>
                        </v-row>
                        <v-row>
                            <v-col>
                                <v-text-field v-model="form.start_from" light="light" label="Start From"></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field v-model="form.duration" light="light" label="Duration (mins)"></v-text-field>
                            </v-col>
                            <v-col>
                                <v-text-field v-model="form.rest" light="light" label="Rest (mins)"></v-text-field>
                            </v-col>
                        </v-row>
                        <v-btn class="ma-4" @click="assignSlots">Assign {{ calculated_no_of_slots }} Slots To Each of Selected Date Range</v-btn>
                        <hr>
                        <!-- <v-btn class="ma-4" color="error">Remove Selected Booking Slots</v-btn> -->
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
		name: 'admin',
		components: {
		},
        data: () => ({
            dates: [],
            experiments:[
                {
                    text:"INTERFERENCE",
                    value:"INTERFERENCE"
                },
                {
                    text:"APPARENT_DEPTH",
                    value:"APPARENT_DEPTH"
                },
                {
                    text:"VISIBLE_SPECTRUM",
                    value:"VISIBLE_SPECTRUM"
                }
            ],
            equipment_ids:[
                {
                    text:"Set 0",
                    value:"set_0"
                },
                {
                    text:"Set 1",
                    value:"set_1"
                },
            ],
            form:{
                start_from:"00:00",
                duration:"55",
                rest:"5",
                experiment:"",
                equipment_id:""
            }
        }),
        computed: {
            dateRangeText () {
                return this.dates.join(' ~ ')
            },
            calculated_no_of_slots(){
                var self = this;
                return 1440/ (parseInt(self.form.duration) + parseInt(self.form.rest));
            }
        },
        mounted () {
            var self = this;
        },
		methods:{
            checkSlots: function(){
                var self = this;
                apiService.getSlotsByDates(self.form.experiment, self.form.equipment_id, self.dates[0], self.dates[1])
                .then((response) => {
                    alert("There are "+response.slots.length +" slots exist in this range");
                });
            },
            assignSlots: function(){
                var self = this;
                apiService.assignSlotsToDates(
                    self.dates[0], 
                    self.dates[1], 
                    self.form.start_from,
                    self.form.duration,
                    self.form.rest,
                    self.form.experiment,
                    self.form.equipment_id
                )
                .then((response) => {
                    if(response.status == "success"){
                        alert("Assigned "+response.count+" slots successfully");
                    }else{
                        alert(response.message);
                    }
                });
            }
		}
	}
</script>