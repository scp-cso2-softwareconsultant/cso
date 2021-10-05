<template>
  <v-app>
    <h3 class="subheading grey--text">CSO Network Members Profile</h3>
    <br />
    <v-card>
      <v-data-table
        :headers="headers"
        :items="cso_profile_list"
        :loading="loadCSOProfile"
        :search="filters.filter_items[filters.filter_items_active].value"
        :custom-filter="filterItems"
        class="elevation-1"
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-spacer></v-spacer>
            <v-dialog v-model="dialog" max-width="1200px">
              <template v-slot:activator="{ on, attrs }">
                <v-btn
                  v-show="crud_guard.create"
                  color="lightgray"
                  class="mb-2"
                  v-bind="attrs"
                  v-on="on"
                >
                  New
                  <v-icon color="green">mdi-plus-thick</v-icon>
                </v-btn>
              </template>
              <v-card>
                <v-card-title  class="text-h5 font-weight-regular blue-grey darken-3 white--text">
                  <span class="text-h5" v-if="!detailsReadonly">{{
                    formTitle
                  }}</span>
                  <span class="text-h5" v-else>CSO Profile Details</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <h5 class="subheading font-weight-black">
                      CSO/CSO Network Basic Information
                    </h5>
                    <v-row class="mt-0" v-if="!detailsReadonly && isEditting">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.cso_id"
                          label="CSO ID"
                          dense
                          :rules="[rules.required]"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="isLRO_list"
                          v-model="editedItem.is_lro"
                          label="Is LRO? *"
                          dense
                          :rules="[rules.required]"
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.is_lro"
                          label="Is LRO? *"
                          dense
                          readonly
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="isLROSupported_list"
                          v-model="editedItem.is_lro_supported"
                          label="Is LRO Supported? *"
                          dense
                          :rules="[rules.required]"
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.is_lro_supported"
                          label="Is LRO Supported? *"
                          dense
                          readonly
                        ></v-text-field>
                      </v-col>
                    </v-row>

                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="type_of_support_list"
                          v-model="editedItem.type_of_support"
                          label="Types Of Support"
                          dense
                          :rules="[rules.required]"
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.type_of_support"
                          label="Types of support "
                          dense
                          readonly
                        ></v-text-field>
                      </v-col>
                    </v-row>

                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="proj_area_list"
                          v-model="editedItem.proj_area"
                          label="Project Area *"
                          dense
                          :rules="[rules.required]"
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.proj_area"
                          label="Project Area *"
                          dense
                          readonly
                        ></v-text-field>
                      </v-col>
                    </v-row>

                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.longitude"
                          :rules="[rules.required]"
                          label="Longitude *"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.latitude"
                          :rules="[rules.required]"
                          label="Latitude *"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_name : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_name"
                          :rules="[rules.required]"
                          label="Full name of the CSO/CSO Network *"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_type : '',-->
                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="cso_type_list"
                          v-model="editedItem.cso_type"
                          label="Type of CSO/CSO Network *"
                          dense
                          :rules="[rules.required]"
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.cso_type"
                          label="Type of CSO/CSO Network *"
                          dense
                          readonly
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_abbreviation : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_abbreviation"
                          :rules="[rules.required]"
                          label="Abbreviation of CSO/CSO Network Name *"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_year"
                          label="Year Established"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>

                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <!-- <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_registration"
                          label="Registration with/Accreditation"
                          dense
                        ></v-text-field> -->
                        <v-col cols="12">
                          <v-combobox
                            :readonly="detailsReadonly"
                            v-model="editedItem.cso_registration"
                            :items="accreditations"
                            label="Registration with/Accreditation"
                            dense
                            multiple
                          ></v-combobox>
                        </v-col>
                      </v-col> </v-row
                    >s
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-textarea
                          auto-grow
                          rows="1"
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_description"
                          label="Brief CSO/CSO Network description (Vision/Mission). "
                          dense
                        >
                        </v-textarea>
                      </v-col>
                    </v-row>
                    <!--  ================================================================ -->
                    <!--  ================================================================ -->
                    <!--  ================================================================ -->

                    <!--                                    cso_address : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-textarea
                          auto-grow
                          rows="1"
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_address"
                          label="CSO/CSO Network Address"
                          dense
                        ></v-textarea>
                      </v-col>
                    </v-row>
                    <!--                                    cso_phone : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_phone"
                          label="CSO/CSO Network Telephone"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_mobile : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_mobile"
                          label="Mobile number of CSO/CSO Network"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_email : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_email"
                          label="CSO/CSO Network Email Address"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_website : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_website"
                          label="Website/URL"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_facebook : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_facebook"
                          label="Facebook Account"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_twitter : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_twitter"
                          label="Twitter Account"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_instagram : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_instagram"
                          label="Instagram Account"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_youtube : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_youtube"
                          label="YouTube Account"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_socmed : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_socmed"
                          label="Other Social Media Account"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>

                    <h5 class="subheading font-weight-black">
                      Head of CSO/CSO Network
                    </h5>
                    <!--                                    cso_head_name : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_head_name"
                          label="Name of the Head of the CSO/CSO Network"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_head_email : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_head_email"
                          label="Email address of the head"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_head_number : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_head_number"
                          label="Contact number of the head"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>

                    <!--                                    cso_description : '',-->

                    <!--                                    cso_beneficiaries : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_beneficiaries"
                          label="Beneficiaries"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_stakeholders : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <!--STAKEHOLDER-->
                        <!-- <v-text-field :readonly="detailsReadonly"
                                                          v-model="editedItem.cso_stakeholders"
                                                          label="Which stakeholders do you primarily work with?" dense></v-text-field> -->
                        <v-col cols="12">
                          <v-combobox
                            v-model="editedItem.cso_stakeholders"
                            :items="stakeholders"
                            label="Which stakeholders do you primarily work with? (Select that applies.)"
                            multiple
                            :readonly="detailsReadonly"
                          ></v-combobox>
                        </v-col>
                      </v-col>
                    </v-row>
                    <!--                                    cso_cause : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_cause"
                          label="What is the primary cause that your CSO/CSO Network work for? "
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_membership_local : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-textarea
                          auto-grow
                          rows="1"
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_membership_local"
                          label="In what local CSO-initiated networks, consortia, alliances, or local councils/bodies is your organization a member of?"
                          dense
                        ></v-textarea>
                      </v-col>
                    </v-row>
                    <!--                                    cso_membership_govt : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-textarea
                          auto-grow
                          rows="1"
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_membership_govt"
                          label="In what gov’t-initiated local networks, consortia, alliances, or local councils/bodies is your organization a member of?"
                          dense
                        ></v-textarea>
                      </v-col>
                    </v-row>
                    <!--                                    cso_areas_precovid : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_areas_precovid"
                          label="In what three (3) areas do you frequently (at least quarterly) relate with the other CSOs? (pre-Covid 19 pandemic)"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_areas_covid : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_areas_covid"
                          label="In what three (3) areas do you frequently (at least quarterly) relate with the other CSOs? (current/Covid 19 situation)"
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>

                    <h5 class="subheading font-weight-black">
                      Relationship with LGU/LGA
                    </h5>
                    <!--                                    cso_support : '',-->
                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="isLRO_list"
                          v-model="editedItem.cso_support"
                          label="Has your CSO/CSO Network RECEIVED SUPPORT from the LGU/LGA? "
                          dense
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.cso_support"
                          label="Has your CSO/CSO Network RECEIVED SUPPORT from the LGU/LGA? "
                          dense
                          readonly
                        ></v-text-field>
                      </v-col>
                    </v-row>

                    <!--                                    cso_rsupport_type : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_rsupport_type"
                          label="In what ways? "
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_rsupport_level : '',-->
                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="level_list"
                          v-model="editedItem.cso_rsupport_level"
                          label="Level of support  your CSO/CSO Network had RECEIVED from the LGU/LGA?"
                          dense
                          hint="If no support has been provided, skip this part. From a scale of 1-5 with 1 as the lowest and 5 as the highest."
                          persistent-hint
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.cso_rsupport_level"
                          label="Level of support  your CSO/CSO Network had RECEIVED from the LGU/LGA?"
                          hint="If no support has been provided, skip this part. From a scale of 1-5 with 1 as the lowest and 5 as the highest."
                          persistent-hint
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_rsupport_changed : '',-->
                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="isLRO_list"
                          v-model="editedItem.cso_rsupport_changed"
                          label="Has the level of support changed as a result of the pandemic?"
                          dense
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.cso_rsupport_changed"
                          label="Has the level of support changed as a result of the pandemic?"
                          dense
                          readonly
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_rsupport_changed_why-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-textarea
                          auto-grow
                          rows="1"
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_rsupport_changed_why"
                          label="Why?"
                          dense
                        ></v-textarea>
                      </v-col>
                    </v-row>
                    <!--                                    cso_psupport : '',-->
                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="isLRO_list"
                          v-model="editedItem.cso_psupport"
                          label="Has your organization PROVIDED SUPPORT to the LGU/LGA?"
                          dense
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.cso_psupport"
                          label="Has your organization PROVIDED SUPPORT to the LGU/LGA?"
                          dense
                          readonly
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_psupport_type : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-textarea
                          auto-grow
                          rows="1"
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_psupport_type"
                          label="In what ways?"
                          dense
                        ></v-textarea>
                      </v-col>
                    </v-row>
                    <!--                                    cso_psupport_level : '',-->
                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="level_list"
                          v-model="editedItem.cso_psupport_level"
                          label="Please rate the level of support  your CSO/CSO Network has PROVIDED to the LGU/LGA?"
                          dense
                          hint="If no support has been provided, skip this part. From a scale of 1-5 with 1 as the lowest and 5 as the highest."
                          persistent-hint
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.cso_psupport_level"
                          label="Please rate the level of support  your CSO/CSO Network has PROVIDED to the LGU/LGA?"
                          hint="If no support has been provided, skip this part. From a scale of 1-5 with 1 as the lowest and 5 as the highest."
                          persistent-hint
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>

                    <h5 class="subheading font-weight-black">
                      Relationship with the Private Sector
                    </h5>
                    <!--                                    cso_psupport_private : '',-->
                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="isLRO_list"
                          v-model="editedItem.cso_psupport_private"
                          label="Has your organization PROVIDED support to private sector organizations?"
                          dense
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.cso_psupport_private"
                          label="Has your organization PROVIDED support to private sector organizations?"
                          dense
                          readonly
                        ></v-text-field>
                      </v-col>
                    </v-row>
                    <!--                                    cso_psupport_private_type : '',-->
                    <v-row class="mt-0">
                      <v-col cols="12" sm="12" md="12">
                        <v-textarea
                          auto-grow
                          rows="1"
                          :readonly="detailsReadonly"
                          v-model="editedItem.cso_psupport_private_type"
                          label="In what ways?"
                          dense
                        ></v-textarea>
                      </v-col>
                    </v-row>
                    <!--                                    cso_psupport_private_level : '',-->
                    <v-row class="mt-0" v-if="!detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-select
                          :items="level_list"
                          v-model="editedItem.cso_psupport_private_level"
                          label="Please rate the level of support  your CSO/CSO Network has PROVIDED to private sector organizations?"
                          dense
                          hint="If no support has been provided, skip this part. From a scale of 1-5 with 1 as the lowest and 5 as the highest."
                          persistent-hint
                        ></v-select>
                      </v-col>
                    </v-row>
                    <v-row class="mt-0" v-if="detailsReadonly">
                      <v-col cols="12" sm="12" md="12">
                        <v-text-field
                          v-model="editedItem.cso_psupport_private_level"
                          label="Please rate the level of support  your CSO/CSO Network has PROVIDED to private sector organizations?"
                          hint="If no support has been provided, skip this part. From a scale of 1-5 with 1 as the lowest and 5 as the highest."
                          persistent-hint
                          dense
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-container>
                </v-card-text>

                <v-card-actions class=" blue-grey darken-3 white--text">
                  <v-spacer></v-spacer>
                  <v-btn color="blue lighten-5" text @click="close">
                    Cancel
                  </v-btn>
                  <v-btn
                    color="blue lighten-5"
                    text
                    @click="save"
                    :loading="btnLoader"
                  >
                    Save
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
            <v-dialog v-model="dialogDelete" max-width="500px">
              <v-card color="blue-grey darken-3">
                <v-alert
                  text
                  color="red lighten-3"
                  prominent
                  type="error"
                  icon="mdi-alert"
                  >Are you sure you want to delete this item?</v-alert
                >
                <!-- <v-card-title class="text-h5 white--text">Are you sure you want to delete this item?</v-card-title> -->
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="blue lighten-5" text @click="closeDelete"
                    >No</v-btn
                  >
                  <v-btn
                    color="blue lighten-5"
                    text
                    @click="deleteItemConfirm"
                    :loading="btnLoader"
                    >Yes</v-btn
                  >
                  <v-spacer></v-spacer>
                </v-card-actions>
              </v-card>
            </v-dialog>
            &nbsp;&nbsp;
            <v-btn
              color="lightgray"
              v-show="crud_guard.export"
              class="mb-2"
              :loading="btnLoader"
              @click="exportExcel('CSOProfile', '')"
            >
              Export
              <v-icon color="green">mdi-microsoft-excel</v-icon>
            </v-btn>
          </v-toolbar>
          <v-row no-gutters style="flex-wrap: nowrap">
            <v-col cols="2" class="flex-grow-0 flex-shrink-0">
              <v-text-field
                v-model="filters.filter_items['cso_id'].value"
                :label="filters.filter_items['cso_id'].text"
                @input="changeFilterActiveValue('cso_id')"
                append-icon="mdi-magnify"
                outlined
                hide-details
              ></v-text-field>
            </v-col>
            <v-col
              cols="4"
              style="min-width: 100px; max-width: 50%"
              class="flex-grow-1 flex-shrink-0"
            >
              <v-text-field
                v-model="filters.filter_items['cso_name'].value"
                :label="filters.filter_items['cso_name'].text"
                @input="changeFilterActiveValue('cso_name')"
                append-icon="mdi-magnify"
                outlined
                hide-details
              ></v-text-field>
            </v-col>
            <v-col
              cols="1"
              style="min-width: 100px; max-width: 70%"
              class="flex-grow-1 flex-shrink-0"
            >
              <v-select
                v-model="filters.filter_items['proj_area'].value"
                :label="filters.filter_items['proj_area'].text"
                :items="filters.filter_items['proj_area'].multiple_selection"
                @input="changeFilterActiveValue('proj_area')"
                outlined
                hide-details
              ></v-select>
            </v-col>
          </v-row>
          <v-row no-gutters style="flex-wrap: nowrap" class="my-3">
            <v-col
              cols="1"
              style="min-width: 100px; max-width: 70%"
              class="flex-grow-1 flex-shrink-0"
            >
              <v-select
                v-model="filters.filter_items['cso_type'].value"
                :label="filters.filter_items['cso_type'].text"
                :items="filters.filter_items['cso_type'].multiple_selection"
                @input="changeFilterActiveValue('cso_type')"
                outlined
                hide-details
              ></v-select>
            </v-col>
            <v-col
              cols="1"
              style="min-width: 100px; max-width: 70%"
              class="flex-grow-1 flex-shrink-0"
            >
              <v-select
                v-model="filters.filter_items['is_lro'].value"
                :label="filters.filter_items['is_lro'].text"
                :items="filters.filter_items['is_lro'].multiple_selection"
                @input="changeFilterActiveValue('is_lro')"
                outlined
                hide-details
              ></v-select>
            </v-col>
            <v-col
              cols="2"
              style="min-width: 100px; max-width: 50%"
              class="flex-grow-1 flex-shrink-0"
            >
              <v-select
                v-model="filters.filter_items['is_lro_supported'].value"
                :label="filters.filter_items['is_lro_supported'].text"
                :items="
                  filters.filter_items['is_lro_supported'].multiple_selection
                "
                @input="changeFilterActiveValue('is_lro_supported')"
                outlined
                hide-details
              ></v-select>
            </v-col>
          </v-row>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            small
            class="mr-2"
            @click="detailsItem(item)"
            color="blue"
            data-toggle="tooltip"
            data-placement="top"
            title="CSO Profile Details"
            v-show="crud_guard.view"
          >
            mdi-information-outline
          </v-icon>
          <v-icon
            small
            class="mr-2"
            @click="editItem(item)"
            color="blue darken-2"
            data-toggle="tooltip"
            data-placement="top"
            title="Edit CSO Profile"
            v-show="crud_guard.update"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            small
            @click="deleteItem(item)"
            color="red"
            data-toggle="tooltip"
            data-placement="top"
            title="Delete This Item"
            v-show="crud_guard.delete"
          >
            mdi-delete
          </v-icon>
        </template>
      </v-data-table>
    </v-card>
  </v-app>
</template>
<script>
export default {
  data: () => ({
    btnLoader: false,
    dialog: false,
    detailsReadonly: false,
    dialogDelete: false,
    loadCSOProfile: false,
    searchBy: "",
    isEditting: false,
    isAddingNew: false,
    editedItemCopy: {},
    crud_guard: {
      create: 0,
      delete: 0,
      download: 0,
      export: 0,
      print: 0,
      read: 0,
      update: 0,
      upload: 0,
      view: 0,
    },
    stakeholders: [],
    accreditations: [],
    isLRO_list: [
      { value: "Yes", text: "Yes" },
      { value: "No", text: "No" },
    ],
    isLROSupported_list: [
      { value: "Yes", text: "Yes" },
      { value: "No", text: "No" },
    ],
    type_of_support_list: [],
    proj_area_list: [
      { value: "Iloilo City", text: "Iloilo City" },
      { value: "Cagayan De Oro City", text: "Cagayan De Oro City" },
    ],
    cso_type_list: [
      { value: "Stand alone", text: "Stand alone" },
      {
        value: "Member-based (Individuals)",
        text: "Member-based (Individuals)",
      },
      {
        value: "Member-based (Organization)",
        text: "Member-based (Organization)",
      },
    ],
    level_list: [
      { value: "1", text: "1" },
      { value: "2", text: "2" },
      { value: "3", text: "3" },
      { value: "4", text: "4" },
      { value: "5", text: "5" },
    ],
    filters: {
      filter_items_active: "cso_id",
      filter_items: {
        cso_id: {
          value: "",
          text: "Id",
          data_value: "cso_id",
          specific: true,
        },
        cso_name: {
          value: "",
          text: "Name",
          data_value: "cso_name",
        },
        proj_area: {
          value: "",
          text: "Project Area",
          data_value: "proj_area",
          multiple_selection: [
            { text: "None", value: "" },
            { value: "Iloilo City", text: "Iloilo City" },
            { value: "Cagayan De Oro City", text: "Cagayan De Oro City" },
          ],
        },
        cso_type: {
          value: "",
          text: "CSO Type",
          data_value: "cso_type",
          multiple_selection: [
            { text: "None", value: "" },
            { value: "Stand alone", text: "Stand alone" },
            {
              value: "Member-based (Individuals)",
              text: "Member-based (Individuals)",
            },
            {
              value: "Member-based (Organization)",
              text: "Member-based (Organization)",
            },
          ],
        },
        is_lro: {
          value: "",
          text: "Is LRO",
          data_value: "is_lro",
          multiple_selection: [
            { text: "None", value: "" },
            { value: "Yes", text: "Yes" },
            { value: "No", text: "No" },
          ],
        },
        is_lro_supported: {
          value: "",
          text: "Is LRO supported",
          data_value: "is_lro_supported",
          multiple_selection: [
            { text: "None", value: "" },
            { value: "Yes", text: "Yes" },
            { value: "No", text: "No" },
          ],
        },
      },
    },
    headers: [
      {
        text: "CSO ID",
        align: "start",
        sortable: false,
        value: "cso_id",
        width: "10%",
      },
      {
        text: "Name",
        align: "start",
        sortable: false,
        value: "cso_name",
        width: "25%",
      },
      {
        text: "Project Area",
        value: "proj_area",
        width: "15%",
        sortable: false,
      },
      { text: "Type of CSO", value: "cso_type", width: "10%", sortable: false },
      { text: "Is LRO?", value: "is_lro", width: "10%", sortable: false },
      {
        text: "Is LRO Supported?",
        value: "is_lro_supported",
        width: "10%",
        sortable: false,
      },
      { text: "Actions", value: "actions", width: "10%", sortable: false },
    ],
    cso_profile_list: [],
    editedIndex: -1,
    editedItem: {
      cso_id: "",
      is_lro: "",
      is_lro_supported: "",
      type_of_support: "",
      longitude: "",
      latitude: "",
      proj_area: "",
      cso_name: "",
      cso_type: "",
      cso_abbreviation: "",
      cso_address: "",
      cso_phone: "",
      cso_mobile: "",
      cso_email: "",
      cso_website: "",
      cso_facebook: "",
      cso_twitter: "",
      cso_instagram: "",
      cso_youtube: "",
      cso_socmed: "",
      cso_head_name: "",
      cso_head_email: "",
      cso_head_number: "",
      cso_year: "",
      cso_registration: "",
      cso_description: "",
      cso_beneficiaries: "",
      cso_stakeholders: "",
      cso_cause: "",
      cso_membership_local: "",
      cso_membership_govt: "",
      cso_areas_precovid: "",
      cso_areas_covid: "",
      cso_support: "",
      cso_rsupport_type: "",
      cso_rsupport_level: "",
      cso_rsupport_changed: "",
      cso_rsupport_changed_why: "",
      cso_psupport: "",
      cso_psupport_type: "",
      cso_psupport_level: "",
      cso_psupport_private: "",
      cso_psupport_private_type: "",
      cso_psupport_private_level: "",
    },
    defaultItem: {
      is_lro: "",
      is_lro_supported: "",
      type_of_support: "",
      longitude: "",
      latitude: "",
      proj_area: "",
      cso_name: "",
      cso_type: "",
      cso_abbreviation: "",
      cso_address: "",
      cso_phone: "",
      cso_mobile: "",
      cso_email: "",
      cso_website: "",
      cso_facebook: "",
      cso_twitter: "",
      cso_instagram: "",
      cso_youtube: "",
      cso_socmed: "",
      cso_head_name: "",
      cso_head_email: "",
      cso_head_number: "",
      cso_year: "",
      cso_registration: "",
      cso_description: "",
      cso_beneficiaries: "",
      cso_stakeholders: "",
      cso_cause: "",
      cso_membership_local: "",
      cso_membership_govt: "",
      cso_areas_precovid: "",
      cso_areas_covid: "",
      cso_support: "",
      cso_rsupport_type: "",
      cso_rsupport_level: "",
      cso_rsupport_changed: "",
      cso_rsupport_changed_why: "",
      cso_psupport: "",
      cso_psupport_type: "",
      cso_psupport_level: "",
      cso_psupport_private: "",
      cso_psupport_private_type: "",
      cso_psupport_private_level: "",
    },

    rules: {
      required: (v) => !!v || "This field is required",
      number: (v) => {
        if (!isNaN(v)) return true;
        if (!isNaN(v) && v.toString().indexOf(".") != -1)
          return "The value entered was not valid.";
        if (!isNaN(parseFloat(v)) && v >= 0) return true;
        return "The value entered was not valid.";
      },
    },
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New CSO Profile" : "Edit CSO Profile";
    },
  },

  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },

  created() {
    this.initialize();
  },

  methods: {
    initialize() {
      document.title = "SCP: CSO² Project | CSO Network Members Profile";
      this.loadCSOProfile = true;
      axios.get("/user-roles-permission").then((response) => {
        const moduleName = "CSOProfile";
        const data = response.data;
        for (const key in data) {
          if (data[key].name == moduleName) {
            const crud_guard = data[key].crud_guard[0];
            if (crud_guard.view == 0) this.$router.push("dashboard");
            else this.crud_guard = crud_guard;
            break;
          }
        }
      });
      axios.get("/getStakeHolders").then((response) => {
        this.stakeholders = response.data;
      });
      axios.get("/getAccreditations").then((response) => {
        this.accreditations = response.data;
      });
      axios.get("/cso-profile").then((response) => {
        var toParse = response.data;
        toParse.forEach((i) => {
          var parsed = i.cso_stakeholders.split("^^");
          var parsed2 = i.cso_registration.split("^^");

          var constructed = [];
          var constructed2 = [];

          parsed.forEach((item) => {
            if (item.length === 0) return;
            constructed.push({ value: item, text: item });
          });

          parsed2.forEach((item) => {
            if (item.length === 0) return;
            constructed2.push({ value: item, text: item });
          });

          i.cso_stakeholders = constructed;
          i.cso_registration = constructed2;
        });

        this.cso_profile_list = toParse;
        this.loadCSOProfile = false;
      });
      axios.get("/types-of-support").then((response) => {
        const data = response.data;
        var category = [];
        for (const value in data)
          category.push({ text: data[value].name, value: data[value].name });
        this.type_of_support_list = category;
      });
    },
    filterItems(items, search, filter) {
      return new this.$MultiFilters(
        items,
        search,
        filter,
        this.filters.filter_items
      ).custom_filter();
    },
    changeFilterActiveValue(key) {
      const filter = this.filters.filter_items;
      const active_key = this.filters.filter_items_active;
      const active_value = filter[active_key].value;
      this.filters.filter_items_active =
        this.$MultiFilters.changeFilterActiveValue(
          key,
          filter,
          active_key,
          active_value
        );
    },
    editItem(item) {
      this.editedItemCopy = item;
      this.editedIndex = this.cso_profile_list.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
      this.isEditting = true;
    },

    detailsItem(item) {
      this.detailsReadonly = true;
      this.editedIndex = this.cso_profile_list.indexOf(item);
      this.editedItem = Object.assign({}, item);
      // this.hideProjArea = false;
      this.dialog = true;
    },

    deleteItem(item) {
      this.delete_lro = item.cso_profile_id;
      this.editedIndex = this.cso_profile_list.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.btnLoader = true;
      this.cso_profile_list.splice(this.editedIndex, 1);
      axios
        .post("/delete-cso-profile", {
          delete_id: this.delete_lro,
        })
        .then((response) => {
          if (response.data.success) {
            this.initialize();
            this.$noty.success("Successfully deleted.");
            this.closeDelete();
          }
        });
    },

    close() {
      this.dialog = false;
      this.detailsReadonly = false;
      this.isEditting = false;
      this.btnLoader = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedItemCopy = {};
        this.editedIndex = -1;
      });
    },

    closeDelete() {
      this.btnLoader = false;
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    async checkNoExistCSOProfileID(url, id) {
      try {
        //console.log(`/${url}/?cso_id=${id}`)
        const response = await axios.get(`/${url}/?cso_id=${id}`);
        //console.log(response)
        const arr = [];

        for (let x = 0; x < response.data.length; x++) {
          //console.log(id.replace(/[^\d.-]/g,''),response.data[x].cso_act_no.replace(/[^\d.-]/g,''))
          if (response.data[x].cso_id)
            arr[arr.length] = response.data[x].cso_id;
        }
        //console.log(arr);

        if (arr.length !== 0) {
          //console.log(arr.length, "returning true")
          return true;
        } else {
          //console.log(arr.length, "returning false")
          return false;
        }
      } catch (error) {
        console.log(error);
      }
    },
    async save() {
      this.btnLoader = true;
      let validate = true;

      if (this.isEditting) {
        let check = await this.checkNoExistCSOProfileID(
          "checkNoExistCSOProfileID",
          this.editedItem.cso_id
        );
        if (check && this.editedItemCopy.cso_id != this.editedItem.cso_id) {
          validate = false;
          this.$noty.error("CSO ID already exist");
        }
      }

      if (!this.editedItem.is_lro) {
        this.$noty.error("Is LRO is empty!");
        validate = false;
      }
      if (!this.editedItem.is_lro_supported) {
        this.$noty.error("Is LRO Supported is empty!");
        validate = false;
      }
      if (!this.editedItem.type_of_support) {
        this.$noty.error("type of support is empty!");
        validate = false;
      }
      if (!this.editedItem.longitude) {
        this.$noty.error("Longitude is empty!");
        validate = false;
      }
      if (!this.editedItem.latitude) {
        this.$noty.error("Longitude is empty!");
        validate = false;
      }

      if (!this.editedItem.proj_area) {
        this.$noty.error("Project Area is empty!");
        validate = false;
      }

      if (!this.editedItem.cso_name) {
        this.$noty.error("Full Name of the CSO/CSO Network is empty!");
        validate = false;
      }
      if (!this.editedItem.cso_type) {
        this.$noty.error("Type of CSO/CSO Network is empty!");
        validate = false;
      }
      if (!this.editedItem.cso_abbreviation) {
        this.$noty.error("Abbreviation of CSO/CSO Network Name is empty!");
        validate = false;
      }
      if (validate) {
        // we cant edit editedItem directly because it is bind to combobox which require
        // an array, so we made a copy
        var editedITEM = Object.assign({}, this.editedItem);
        var t = "",
          t2 = "";

        editedITEM.cso_stakeholders.forEach((stakeholder) => {
          t += "^^" + stakeholder.text;
        });
        editedITEM.cso_registration.forEach((registration) => {
          t2 += "^^" + registration.text;
        });

        editedITEM.cso_stakeholders = t.substring(2);
        editedITEM.cso_registration = t2.substring(2);

        axios
          .post("/save-cso-profile", {
            data: JSON.stringify(editedITEM),
            form_mode: this.editedIndex,
          })
          .then((response) => {
            if (response.data.success) {
              this.initialize();
              if (this.editedIndex < 0) {
                this.$noty.success("Successfully Added.");
              } else {
                this.$noty.success("Successfully Updated.");
              }
              this.close();
            } else {
              this.close();
            }
            this.btnLoader = false;
          });
      } else {
        this.btnLoader = false;
      }
    },
    exportExcel: function (tableName, value) {
      //console.log(tableName)
      this.btnLoader = true;
      let filename = tableName + ".xlsx";
      var formData = new FormData();
      formData.append("tableName", tableName);
      axios
        .post("/export-excel", formData, { responseType: "blob" })
        .then((response) => {
          const url = window.URL.createObjectURL(new Blob([response.data]));
          const link = document.createElement("a");
          link.href = url;
          link.setAttribute("download", filename);
          document.body.appendChild(link);
          link.click();
          this.btnLoader = false;
        });
    },
  },
};
</script>
