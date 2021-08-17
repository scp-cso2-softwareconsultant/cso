<template>
    <v-app>
        <h3 class="subheading grey--text">LMS</h3>
        <br>
        <v-card>
            <v-tabs v-model="LMSTab" >
                <v-tab href="#ParticipantsProfile">
                    Participant's Profile
                </v-tab>
                <v-tab href="#Courses">
                    Courses
                </v-tab>
                <v-tab href="#TrainingAttendees">
                    Training Attendees
                </v-tab>
            </v-tabs>

            <v-tabs-items v-model="LMSTab">
                <v-tab-item :key="1" value="ParticipantsProfile">
                    <ParticipantProfile></ParticipantProfile>
                </v-tab-item>
                <v-tab-item :key="2" value="Courses">
                    <Courses></Courses>
                </v-tab-item>
                <v-tab-item :key="3" value="TrainingAttendees">
                    <TrainingAttendees></TrainingAttendees>
                </v-tab-item>
            </v-tabs-items>
        </v-card>
    </v-app>
</template>
<script>
import ParticipantProfile from './ParticipantsProfile';
import Courses from './Courses';
import TrainingAttendees from './TrainingAttendees';

export default {
    components: {
        ParticipantProfile,
        Courses,
        TrainingAttendees
    },

    data: vm => ({
        LMSTab: null,


    })

}
</script>

