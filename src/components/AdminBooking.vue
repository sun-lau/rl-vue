<template>
    <div class="adminBooking">
        <v-card>
            <v-container>
                <v-row>
                    <v-col cols="12" xs="12" sm="6" md="6" lg="4" class="my-2 px-1">
                        <v-date-picker 
                        full-width v-model="dates" range></v-date-picker>
                        </v-col>
                    <v-col cols="12" xs="12" sm="6" md="6" lg="8" class="my-2 px-1">
                        <v-text-field v-model="dateRangeText" label="Date range" readonly></v-text-field>
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
                        <v-btn class="ma-4" color="error" @click="dialog=true">Remove All Slots in Date range</v-btn>
                    </v-col>
                </v-row>
            </v-container>
        </v-card>
         <v-dialog
            v-model="dialog"
            width="500"
        >
            <v-card>
                <v-card-title
                class="headline grey lighten-2"
                primary-title
                >
                Confirm Remove all slots in range? This will affect booked cases.
                </v-card-title>

                <v-card-text>
                    <v-simple-table>
                        <tr>
                            <td>
                                Experiment
                            </td>
                            <td>
                                {{ form.experiment }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Equipment ID
                            </td>
                            <td>
                                {{ form.equipment_id }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                From
                            </td>
                            <td>
                                {{ dates[0] }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                To
                            </td>
                            <td>
                                {{ dates[1] }}
                            </td>
                        </tr>
                    </v-simple-table>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    color="red"
                    text
                    @click="confirmRemove"
                >
                    Confirm
                </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
	import moment from 'moment';
    import {Admin_APIService} from '@/services/Admin_APIService';
    const apiService = new Admin_APIService(process.env.VUE_APP_BASE_URL);
    export default {
    name: 'AdminBooking',
    props: {
    },
    data:function(){
        return {
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
                },
                {
                    text:"BACTERIA_GROWTH",
                    value:"BACTERIA_GROWTH"
                },
                {
                    text:"EM_INDUCTION",
                    value:"EM_INDUCTION"
                },
                {
                    text:"GREEN_HOUSE",
                    value:"GREEN_HOUSE"
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
                {
                    text:"Set 2",
                    value:"set_2"
                },
                {
                    text:"Set 3",
                    value:"set_3"
                },
            ],
            form:{
                start_from:"00:00",
                duration:"55",
                rest:"5",
                experiment:"",
                equipment_id:""
            },
            dialog: false,
        }
    },
    computed: {
        dateRangeText () {
            return this.dates.join(' ~ ')
        },
        calculated_no_of_slots(){
            var self = this;
            return 1440/ (parseInt(self.form.duration) + parseInt(self.form.rest));
        }
    },
    methods:{
            assignSlots: function(){
                var self = this;
                
                if(self.isValid()){
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
            },
            confirmRemove: function(){
                var self = this;
                if(self.isValid()){
                    apiService.removeSlotsWithinDates(
                        self.dates[0], 
                        self.dates[1], 
                        self.form.experiment,
                        self.form.equipment_id
                    )
                    .then((response) => {
                        if(response.status == "success"){
                            alert("Remove "+response.updated_rows+" slots successfully");
                        }else{
                            
                        }
                    });

                }
            },
            isValid: function(){
                var self = this;
                if(self.dates[0]==null){
                    alert("missing Start date");
                    return false;
                }
                if(self.dates[1]==null){
                    alert("missing End date");
                    return false;
                }
                if(self.dates[0] > self.dates[1]){
                    alert("End date should be larger than Start date");
                    return false;
                }
                if(self.form.equipment_id==null){
                    alert("missing Experiment");
                    return false;
                }
                if(self.form.equipment_id==null){
                    alert("missing Equipment ID");
                    return false;
                }
                return true;
            }

    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
</style>