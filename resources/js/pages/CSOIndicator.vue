<template>
    <v-app>
        <h3 class="subheading grey--text">
            CSO² Project Indicator
            <button @click="debug">TEST</button>
        </h3>
                                        <v-dialog v-model="dialog" max-width="500px">
                                            <!-- Hello World -->
                                            <v-card>
                                                <v-card-title>
                                                    <span class="text-h5">{{
                                                        formTitle
                                                    }}</span>
                                                </v-card-title>

                                                <v-card-text>
                                                    <v-container dense>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-select
                                                                    :items="
                                                                        category_items
                                                                    "
                                                                    v-model="
                                                                        editedItem.cso_category
                                                                    "
                                                                    :rules="[
                                                                        rules.required
                                                                    ]"
                                                                    value="editedItem.cso_category"
                                                                    label="Category *"
                                                                    dense
                                                                ></v-select>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-textarea
                                                                    auto-grow
                                                                    rows="1"
                                                                    :rules="[
                                                                        rules.required
                                                                    ]"
                                                                    v-model="
                                                                        editedItem.cso_description
                                                                    "
                                                                    label="Description *"
                                                                    dense
                                                                >
                                                                </v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-select
                                                                    :items="
                                                                        lead_orgs
                                                                    "
                                                                    v-model="
                                                                        editedItem.cso_lead_organization
                                                                    "
                                                                    label="Lead Organization *"
                                                                    dense
                                                                ></v-select>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-text-field
                                                                    v-model="
                                                                        editedItem.cso_act_no
                                                                    "
                                                                    :rules="[
                                                                        rules.required
                                                                    ]"
                                                                    color="purple darken-2"
                                                                    :label="headers[0].text"
                                                                    required
                                                                    auto-grow
                                                                    rows="1"
                                                                    dense
                                                                ></v-text-field>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                                v-if="
                                                                    editedItem.created_at
                                                                "
                                                            >
                                                                <v-select
                                                                    :items="
                                                                        status_list
                                                                    "
                                                                    v-model="
                                                                        editedItem.cso_status
                                                                    "
                                                                    label="Status"
                                                                    dense
                                                                ></v-select>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row v-if="catSelectedTab === 'Output'" class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-textarea
                                                                    auto-grow
                                                                    rows="1"
                                                                    v-model="
                                                                        editedItem.cso_remarks
                                                                    "
                                                                    label="Remarks"
                                                                    dense
                                                                >
                                                                </v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row v-if="catSelectedTab ==='Output'" class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <p class="mt-4 font-weight-bold">Attatched File</p>
                                                                <div v-if='isAddingNew'>
                                                                    <p>You can't add MOV on create, You can add it later on Edit</p>
                                                                </div>
                                                                <div v-else>
                                                                    <div v-if="!isEditting">
                                                                        <div v-if="file2_name === ''">
                                                                            No MOV File
                                                                        </div>
                                                                        <div v-else>
                                                                            <a :href="getLink(file2_name)">
                                                                                {{file_name}}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div v-else>
                                                                        <!--Editing True-->
                                                                        <div v-if="file2_name.length != 0">
                                                                            <v-btn background depressed @click="removeFile2">
                                                                                {{ file2_name }}
                                                                            </v-btn>
                                                                        </div>
                                                                        <div v-else>
                                                                            <v-file-input v-model="file2_attached" @change="onFileChanged2">
                                                                            </v-file-input>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </v-col>
                                                        </v-row>
                                                    </v-container>
                                                </v-card-text>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn
                                                        color="blue darken-1"
                                                        text
                                                        @click="close"
                                                        dense
                                                    >
                                                        Cancel
                                                    </v-btn>
                                                    <v-btn
                                                        color="blue darken-1"
                                                        text
                                                        @click="save"
                                                        dense
                                                        :loading="btnLoader"
                                                    >
                                                        Save
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
                                        <v-dialog
                                            v-model="dialogDelete"
                                            max-width="500px"
                                        >
                                            <v-card>
                                                <v-card-title class="text-h5"
                                                    >Are you sure you want to
                                                    delete this
                                                    item?</v-card-title
                                                >
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <v-btn
                                                        color="blue darken-1"
                                                        text
                                                        @click="closeDelete"
                                                        >Cancel</v-btn
                                                    >
                                                    <v-btn
                                                        color="blue darken-1"
                                                        text
                                                        @click="
                                                            deleteItemConfirm
                                                        "
                                                        :loading="btnLoader"
                                                        >OK</v-btn
                                                    >
                                                    <v-spacer></v-spacer>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>

                                        
                                        <v-dialog
                                            v-model="subdialog"
                                            max-width="500px"
                                        >
                                            <v-card>
                                                <v-card-title>
                                                    <span class="text-h5">{{
                                                        formSubTitle
                                                    }}</span>
                                                </v-card-title>
                                                <v-card-text>
                                                    <v-container dense>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-text-field
                                                                    v-model="
                                                                        editedSubItem.indicator_no
                                                                    "
                                                                    :rules="[
                                                                        rules.required
                                                                    ]"
                                                                    :readonly="
                                                                        !isEditting
                                                                    "
                                                                    :label="this.subHeaders[0].text"
                                                                    dense
                                                                ></v-text-field>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-textarea
                                                                    auto-grow
                                                                    rows="1"
                                                                    :rules="[
                                                                        rules.required
                                                                    ]"
                                                                    :readonly="
                                                                        !isEditting
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.indicator
                                                                    "
                                                                    label="Description *"
                                                                    dense
                                                                ></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row
                                                            class="mt-0"
                                                        >
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-select
                                                                    :items="
                                                                        indicator_type_list
                                                                    "
                                                                    :readonly="
                                                                        !isEditting
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.indicator_type
                                                                    "
                                                                    label="Type *"
                                                                    dense
                                                                    :rules="[
                                                                        rules.required
                                                                    ]"
                                                                ></v-select>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-textarea
                                                                    auto-grow
                                                                    rows="1"
                                                                    :rules="[
                                                                        rules.required
                                                                    ]"
                                                                    :readonly="
                                                                        !isEditting
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.data_source
                                                                    "
                                                                    label="Data Source *"
                                                                    dense
                                                                ></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row class="mt-0" >
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-select
                                                                    :items="
                                                                        frequency_list
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.frequency
                                                                    "
                                                                    label="Frequency *"
                                                                    dense
                                                                    :readonly="
                                                                        !isEditting
                                                                    "
                                                                    :rules="[
                                                                        rules.required
                                                                    ]"
                                                                ></v-select>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-textarea
                                                                    auto-grow
                                                                    rows="1"
                                                                    :rules="[
                                                                        rules.required
                                                                    ]"
                                                                    :readonly="
                                                                        !isEditting
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.unit_measure
                                                                    "
                                                                    label="Unit of Measure *"
                                                                    dense
                                                                ></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row>
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-select
                                                                    :items="
                                                                        status_list
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.indicator_status
                                                                    "
                                                                    label="Status"
                                                                    :readonly="!isEditting"
                                                                    dense
                                                                ></v-select>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-textarea
                                                                    auto-grow
                                                                    rows="1"
                                                                    :readonly="
                                                                        !isEditting
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.indicator_remarks
                                                                    "
                                                                    label="Remarks"
                                                                    dense
                                                                ></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row
                                                            class="mt-0"
                                                        >
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-select
                                                                    :items="
                                                                        ppr_list
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.ppr
                                                                    "
                                                                    label="PPR *"
                                                                    dense
                                                                    :readonly="
                                                                        !isEditting
                                                                    "
                                                                    :rules="[
                                                                        rules.required
                                                                    ]"
                                                                ></v-select>
                                                            </v-col>
                                                        </v-row>
                                                        
                                                        <v-row
                                                            class="mt-0"
                                                            v-if="
                                                                detailsReadonly
                                                            "
                                                        >
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-textarea
                                                                    auto-grow
                                                                    rows="1"
                                                                    v-model="
                                                                        editedSubItem.baseline_date
                                                                    "
                                                                    label="Baseline Date"
                                                                    dense
                                                                    readonly
                                                                ></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row
                                                            class="mt-0"
                                                            v-if="
                                                                !detailsReadonly
                                                            "
                                                        >
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-menu
                                                                    ref="modelBaselineDate"
                                                                    v-model="
                                                                        modelBaselineDate
                                                                    "
                                                                    :close-on-content-click="
                                                                        false
                                                                    "
                                                                    transition="scale-transition"
                                                                    offset-y
                                                                    max-width="290px"
                                                                    min-width="auto"
                                                                    dense
                                                                >
                                                                    <template
                                                                        v-slot:activator="{
                                                                            on,
                                                                            attrs
                                                                        }"
                                                                    >
                                                                        <v-text-field
                                                                            v-model="
                                                                                editedSubItem.baseline_date
                                                                            "
                                                                            label="Baseline Date"
                                                                            readonly
                                                                            persistent-hint
                                                                            append-outer-icon="mdi-calendar"
                                                                            v-bind="
                                                                                attrs
                                                                            "
                                                                            v-on="
                                                                                on
                                                                            "
                                                                            dense
                                                                        ></v-text-field>
                                                                    </template>
                                                                    <v-date-picker
                                                                        v-model="
                                                                            editedSubItem.baseline_date
                                                                        "
                                                                        no-title
                                                                        @input="
                                                                            modelBaselineDate = false
                                                                        "
                                                                    ></v-date-picker>
                                                                </v-menu>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-textarea
                                                                    auto-grow
                                                                    rows="1"
                                                                    :readonly="
                                                                        detailsReadonly
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.baseline_value
                                                                    "
                                                                    label="Baseline Value"
                                                                    dense
                                                                ></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row
                                                            class="mt-0"
                                                            v-if="
                                                                detailsReadonly
                                                            "
                                                        >
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-textarea
                                                                    auto-grow
                                                                    rows="1"
                                                                    v-model="
                                                                        editedSubItem.target_date
                                                                    "
                                                                    label="Target Date"
                                                                    dense
                                                                    readonly
                                                                ></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row
                                                            class="mt-0"
                                                            v-if="
                                                                !detailsReadonly
                                                            "
                                                        >
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-menu
                                                                    ref="modelTargetDate"
                                                                    v-model="
                                                                        modelTargetDate
                                                                    "
                                                                    :close-on-content-click="
                                                                        false
                                                                    "
                                                                    transition="scale-transition"
                                                                    offset-y
                                                                    max-width="290px"
                                                                    min-width="auto"
                                                                    dense
                                                                >
                                                                    <template
                                                                        v-slot:activator="{
                                                                            on,
                                                                            attrs
                                                                        }"
                                                                    >
                                                                        <v-text-field
                                                                            v-model="
                                                                                editedSubItem.target_date
                                                                            "
                                                                            label="Target Date"
                                                                            readonly
                                                                            persistent-hint
                                                                            append-outer-icon="mdi-calendar"
                                                                            v-bind="
                                                                                attrs
                                                                            "
                                                                            v-on="
                                                                                on
                                                                            "
                                                                            dense
                                                                        ></v-text-field>
                                                                    </template>
                                                                    <v-date-picker
                                                                        v-model="
                                                                            editedSubItem.target_date
                                                                        "
                                                                        no-title
                                                                        @input="
                                                                            modelTargetDate = false
                                                                        "
                                                                    ></v-date-picker>
                                                                </v-menu>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-textarea
                                                                    auto-grow
                                                                    rows="1"
                                                                    :readonly="
                                                                        detailsReadonly
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.target_value
                                                                    "
                                                                    label="Target Value"
                                                                    dense
                                                                ></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row
                                                            class="mt-0"
                                                            v-if="
                                                                detailsReadonly
                                                            "
                                                        >
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-textarea
                                                                    auto-grow
                                                                    rows="1"
                                                                    v-model="
                                                                        editedSubItem.actual_date
                                                                    "
                                                                    label="Actual date"
                                                                    dense
                                                                    readonly
                                                                ></v-textarea>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row
                                                            class="mt-0"
                                                            v-if="
                                                                !detailsReadonly
                                                            "
                                                        >
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            >
                                                                <v-menu
                                                                    ref="modelTargetDate"
                                                                    v-model="
                                                                        modelActualDate
                                                                    "
                                                                    :close-on-content-click="
                                                                        false
                                                                    "
                                                                    transition="scale-transition"
                                                                    offset-y
                                                                    max-width="290px"
                                                                    min-width="auto"
                                                                    dense
                                                                >
                                                                    <template
                                                                        v-slot:activator="{
                                                                            on,
                                                                            attrs
                                                                        }"
                                                                    >
                                                                        <v-text-field
                                                                            v-model="
                                                                                editedSubItem.actual_date
                                                                            "
                                                                            label="Actual Date"
                                                                            readonly
                                                                            persistent-hint
                                                                            append-outer-icon="mdi-calendar"
                                                                            v-bind="
                                                                                attrs
                                                                            "
                                                                            v-on="
                                                                                on
                                                                            "
                                                                            dense
                                                                        ></v-text-field>
                                                                    </template>
                                                                    <v-date-picker
                                                                        v-model="
                                                                            editedSubItem.actual_date
                                                                        "
                                                                        no-title
                                                                        @input="
                                                                            modelActualDate = false
                                                                        "
                                                                    ></v-date-picker>
                                                                </v-menu>
                                                            </v-col>
                                                        </v-row>
                                                        <v-row class="mt-0">
                                                            <v-col
                                                                cols="12"
                                                                sm="12"
                                                                md="12"
                                                            ><p class="mt-4 font-weight-bold">Attatched File</p>
                                                                <!-- <div
                                                                    v-if="
                                                                        isEditting
                                                                    "
                                                                >   
                                                                    <div v-if="isAddingNew">
                                                                        <template>
                                                                            <p>No Attatched MOV (You can only attatch file on Edit after saving this)</p>
                                                                        </template>
                                                                    </div>
                                                                    <div
                                                                        v-else-if="
                                                                            isRemove
                                                                        "
                                                                    >   
                                                                        <p>Click Current MOV to replace & Upload a new MOV</p>
                                                                        <v-btn
                                                                            background
                                                                            depressed
                                                                            readonly
                                                                            @click="
                                                                                removeFile
                                                                            "
                                                                            >{{
                                                                                file_name
                                                                            }}
                                                                        </v-btn>
                                                                    </div>
                                                                    <div v-else>
                                                                        <v-file-input
                                                                            v-if="
                                                                                file_name !=
                                                                                    []
                                                                            "
                                                                            show-size
                                                                            label="Upload MOV"
																																						v-show="crud_guard.upload"
                                                                            @change="
                                                                                removeFile
                                                                            "
                                                                            v-model="
                                                                                file_name
                                                                            "
                                                                        ></v-file-input>
                                                                        <v-file-input
                                                                            v-else
                                                                            show-size
                                                                            class='filepick3'
                                                                            label="Upload MOV"
																																						v-show="crud_guard.upload"
                                                                            @change="
                                                                                onFileChanged
                                                                            "
                                                                            v-model="
                                                                                file_name
                                                                            "
                                                                        ></v-file-input>
                                                                    </div>
                                                                </div>
                                                                <div v-else>
                                                                    <template v-if="editedSubItem.mov_file != null">
                                                                        <a :href="getLink(editedSubItem.mov_file)" target="blank">
                                                                            {{editedSubItem.mov_file}}
                                                                        </a>
                                                                    </template>
                                                                    <template v-else>
                                                                        <p>No Attatched MOV </p>
                                                                    </template>
                                                                </div> -->
                                                                <div v-if='isAddingNew'>
                                                                    <p>You can't add MOV on create, You can add it later on Edit</p>
                                                                </div>
                                                                <div v-else>
                                                                    <div v-if="!isEditting">
                                                                        <div v-if="file_name === ''">
                                                                            No MOV File
                                                                        </div>
                                                                        <div v-else>
                                                                            <a :href="getLink(file_name)">
                                                                                {{file_name}}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                    <div v-else>
                                                                        <!--Editing True-->
                                                                        <div v-if="file_name.length != 0">
                                                                            <v-btn background depressed readonly @click="removeFile">
                                                                                {{ file_name }}
                                                                            </v-btn>
                                                                        </div>
                                                                        <div v-else>
                                                                            <v-file-input v-model="file_attached" @change="onFileChanged">
                                                                            </v-file-input>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </v-col>
                                                        </v-row>
                                                    </v-container>
                                                </v-card-text>
                                                <v-card-actions
                                                    v-if="isEditting"
                                                >
                                                    <v-spacer></v-spacer>
                                                    <v-btn
                                                        color="blue darken-1"
                                                        text
                                                        @click="closeSub"
                                                        dense
                                                    >
                                                        Cancel
                                                    </v-btn>
                                                    <v-btn
                                                        color="blue darken-1"
                                                        text
                                                        @click="saveSub"
                                                        dense
                                                        :loading="btnLoader"
                                                    >
                                                        Save
                                                    </v-btn>
                                                </v-card-actions>
                                            </v-card>
                                        </v-dialog>
        <div class="d-flex m-4 flex-between align-items-center">
            <p class="mb-0">
                <strong class="text-primary">Status Legends</strong>
            </p>
            <v-col
                class="mx-3"
                cols="2"
                v-for="(stats, idx) in status_list"
                :key="idx"
            >
                <v-progress-linear
                    class="rounded-top rounded-bottom text-white text-center"
                    height="35"
                    :color="getColor(stats.text)"
                    value="100"
                    >{{ stats.value }}</v-progress-linear
                >

                <v-progress-linear
                    indeterminate
                    class="rounded-bottom text-white text-center"
                    height="2"
                    :color="getColor(stats.text)"
                ></v-progress-linear>
            </v-col>
        </div>
        <br />
        <template>
            <v-card>
                <v-tabs v-model="tabCategory">
                    <v-tab
                        v-for="item in category_tabs"
                        :key="item.value"
                        @click="getIndicator(item.value)"
                    >
                        {{ item.text }}
                    </v-tab>
                </v-tabs>
                <v-tabs-items v-model="tabCategory">
                    <v-tab-item v-for="item in category_tabs" :key="item.value">
                        <v-card>
                            <v-data-table
                                v-if="catSelectedTab === 'Output'"
                                :headers="headers"
                                :items="indicators_list"
                                :single-expand="singleExpand"
                                :expanded.sync="expanded"
                                :search="searchBy"
                                item-key="cso_indicator_id"
                                :loading="loadCSOIndicator"
                                class="elevation-1"
                            >   
                            <template v-slot:item.cso_indicator_mov="{ item }">
                                <div v-if="item.cso_indicator_mov">
                                    <a :href="getLink2(item.cso_indicator_mov)" target="blank">
                                        <v-icon center color="primary">
                                            mdi-file-download-outline
                                        </v-icon>
                                    </a>
                                </div>
                            </template>
                                <template v-slot:top>
                                    <v-toolbar class='py-4' flat dense>
                                        <v-text-field
                                            v-model="searchBy"
                                            append-icon="mdi-magnify"
                                            label="Search"
                                            single-line
                                            hide-details
                                        ></v-text-field>
                                            <v-col cols="3">
                                                <v-combobox
                                                v-model="selected_filter_item"
                                                :items="filter_items"
                                                label="Filter By"
                                                @change="initFilter2Items"
                                                chips
                                                dense
                                                ></v-combobox>
                                            </v-col>
                                            <v-col v-if="selected_filter_item != 'All'" cols="4">
                                                <v-combobox
                                                v-model="selected_filter_item2"
                                                :items="filter_items2"
                                                :label="filter2_label"
                                                @change="initialize"
                                                dense
                                                chips
                                                ></v-combobox>
                                            </v-col>
                                        <v-btn v-show="crud_guard.create" color="lightgray" class="mb-2" @click="newActivity" >
                                            New
                                            <v-icon color="green"
                                                >mdi-plus-thick</v-icon
                                            >
                                        </v-btn>
                                        &nbsp;&nbsp;
                                        <v-btn v-show="crud_guard.export" color="lightgray" class="mb-2" :loading="btnLoader" @click="exportExcel( 'CSOIndicator', item.value )">
                                            Export
                                            <v-icon color="green">mdi-microsoft-excel</v-icon>
                                        </v-btn>
                                    </v-toolbar>
                                </template>
                                <template
                                    v-slot:item.cso_status="{ item }"
                                >
                                    <v-progress-linear
                                        class="rounded-top  text-white text-center"
                                        height="23"
                                        value="100"
                                        :color="getColor(item.cso_status)"
                                    ></v-progress-linear>
                                    <v-progress-linear
                                        indeterminate
                                        class="rounded-bottom text-white text-center"
                                        height="2"
                                        :color="getColor(item.cso_status)"
                                    ></v-progress-linear>
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <v-icon
										v-show="crud_guard.update"
                                        small
                                        class="mr-2"
                                        @click="editItem(item)"
                                        color="blue darken-2"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Edit CSO2 Indicator"
                                    >
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon
										v-show="crud_guard.delete"
                                        small
                                        @click="deleteItem(item)"
                                        color="red"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Delete This Item"
                                    >
                                        mdi-delete
                                    </v-icon>
                                </template>
                                <template
                                    v-slot:expanded-item="{ headers, item }"
                                >
                                    <td :colspan="headers.length">
                                        <v-data-table
                                            :headers="subHeaders"
                                            :items="item.subItems"
                                            class="elevation-1"
                                        >
                                            <template
                                                v-slot:item.indicator_status="{ item }"
                                            >
                                                <v-progress-linear
                                                    class="rounded-top  text-white text-center"
                                                    height="23"
                                                    value="100"
                                                    :color="getColor(item.indicator_status)"
                                                ></v-progress-linear>
                                                <v-progress-linear
                                                    indeterminate
                                                    class="rounded-bottom text-white text-center"
                                                    height="2"
                                                    :color="getColor(item.indicator_status)"
                                                ></v-progress-linear>
                                            </template>
                                            <template
                                                v-slot:item.actions="{ item }"
                                            >
                                                <v-icon
													v-show="crud_guard.view"
                                                    small
                                                    class="mr-2"
                                                    @click="
                                                        detailsSubItem(item)
                                                    "
                                                    color="blue"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Indicator Details"
                                                >
                                                    mdi-information-outline
                                                </v-icon>
                                                <br />
                                                <v-icon
													v-show="crud_guard.update"
                                                    small
                                                    class="mr-2"
                                                    @click="editSubItem(item)"
                                                    color="blue darken-2"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Edit Indicator Details"
                                                >
                                                    mdi-pencil
                                                </v-icon>
                                                <br />
                                                <v-icon
													v-show="crud_guard.delete"
                                                    small
                                                    @click="deleteSubItem(item)"
                                                    color="red"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Delete This Item"
                                                >
                                                    mdi-delete
                                                </v-icon>
                                            </template>
                                        </v-data-table>
                                    </td>
                                </template>
                            </v-data-table>
                            <v-data-table
                                v-else
                                :headers="headers"
                                :items="indicators_list"
                                :single-expand="singleExpand"
                                :expanded.sync="expanded"
                                :search="searchBy"
                                item-key="cso_indicator_id"
                                :loading="loadCSOIndicator"
                                show-expand
                                class="elevation-1"
                            >
                                <template v-slot:top>
                                    <v-toolbar class='py-4' flat dense>
                                        <v-text-field
                                            v-model="searchBy"
                                            append-icon="mdi-magnify"
                                            label="Search"
                                            single-line
                                            hide-details
                                        ></v-text-field>
                                            <v-col cols="3">
                                                <v-combobox
                                                v-model="selected_filter_item"
                                                :items="filter_items"
                                                label="Filter By"
                                                @change="initFilter2Items"
                                                chips
                                                dense
                                                ></v-combobox>
                                            </v-col>
                                            <v-col v-if="selected_filter_item != 'All'" cols="4">
                                                <v-combobox
                                                v-model="selected_filter_item2"
                                                :items="filter_items2"
                                                :label="filter2_label"
                                                @change="initialize"
                                                dense
                                                chips
                                                ></v-combobox>
                                            </v-col>
                                        <v-btn v-show="crud_guard.create" color="lightgray" class="mb-2" @click="newActivity" >
                                            New
                                            <v-icon color="green"
                                                >mdi-plus-thick</v-icon
                                            >
                                        </v-btn>
                                        &nbsp;&nbsp;
                                        <v-btn v-show="crud_guard.export" color="lightgray" class="mb-2" :loading="btnLoader" @click="exportExcel( 'CSOIndicator', item.value )">
                                            Export
                                            <v-icon color="green">mdi-microsoft-excel</v-icon>
                                        </v-btn>
                                    </v-toolbar>
                                </template>
                                <template
                                    v-slot:item.cso_status="{ item }"
                                >
                                    <v-progress-linear
                                        class="rounded-top  text-white text-center"
                                        height="23"
                                        value="100"
                                        :color="getColor(item.cso_status)"
                                    ></v-progress-linear>
                                    <v-progress-linear
                                        indeterminate
                                        class="rounded-bottom text-white text-center"
                                        height="2"
                                        :color="getColor(item.cso_status)"
                                    ></v-progress-linear>
                                </template>
                                <template v-slot:item.actions="{ item }">
                                    <v-icon
                                        v-show="crud_guard.create"
                                        small
                                        class="mr-2"
                                        @click="addSubItem(item)"
                                        color="green"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="New Indicator Details"
                                    >
                                        mdi-sticker-plus-outline
                                    </v-icon>
                                    <v-icon
										v-show="crud_guard.update"
                                        small
                                        class="mr-2"
                                        @click="editItem(item)"
                                        color="blue darken-2"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Edit CSO2 Indicator"
                                    >
                                        mdi-pencil
                                    </v-icon>
                                    <v-icon
										v-show="crud_guard.delete"
                                        small
                                        @click="deleteItem(item)"
                                        color="red"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Delete This Item"
                                    >
                                        mdi-delete
                                    </v-icon>
                                </template>
                                <template
                                    v-slot:expanded-item="{ headers, item }"
                                >
                                    <td :colspan="headers.length">
                                        <v-data-table
                                            :headers="subHeaders"
                                            :items="item.subItems"
                                            class="elevation-1"
                                        >
                                            <template
                                                v-slot:item.indicator_status="{ item }"
                                            >
                                                <v-progress-linear
                                                    class="rounded-top  text-white text-center"
                                                    height="23"
                                                    value="100"
                                                    :color="getColor(item.indicator_status)"
                                                ></v-progress-linear>
                                                <v-progress-linear
                                                    indeterminate
                                                    class="rounded-bottom text-white text-center"
                                                    height="2"
                                                    :color="getColor(item.indicator_status)"
                                                ></v-progress-linear>
                                            </template>
                                            <template
                                                v-slot:item.actions="{ item }"
                                            >
                                                <v-icon
													v-show="crud_guard.view"
                                                    small
                                                    class="mr-2"
                                                    @click="
                                                        detailsSubItem(item)
                                                    "
                                                    color="blue"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Indicator Details"
                                                >
                                                    mdi-information-outline
                                                </v-icon>
                                                <br />
                                                <v-icon
													v-show="crud_guard.update"
                                                    small
                                                    class="mr-2"
                                                    @click="editSubItem(item)"
                                                    color="blue darken-2"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Edit Indicator Details"
                                                >
                                                    mdi-pencil
                                                </v-icon>
                                                <br />
                                                <v-icon
													v-show="crud_guard.delete"
                                                    small
                                                    @click="deleteSubItem(item)"
                                                    color="red"
                                                    data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Delete This Item"
                                                >
                                                    mdi-delete
                                                </v-icon>
                                            </template>
                                        </v-data-table>
                                    </td>
                                </template>
                            </v-data-table>
                        </v-card>
                    </v-tab-item>
                </v-tabs-items>
            </v-card>
        </template>
    </v-app>
</template>
<script>
import Vue from "vue";
import VueNoty from "vuejs-noty";
Vue.use(VueNoty);
export default {
  data: () => ({
    //filter
    selected_filter_item : ["All"],
    filter_items:["All","Lead Organization","Status"],

    selected_filter_item2:[],
    filter_items2:[],
    filter2_label:"",
    //
    crud_guard : {
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
    catSelectedTab: "Activity",
    tabCategory: null,
    isEditting: false,
    btnLoader: false,
    detailsReadonly: false,
    category_tabs: [
      { text: "Activity", value: "Activity" },
      { text: "Output", value: "Output" },
      { text: "Outcome", value: "Outcome" },
      { text: "Impact", value: "Impact" },
    ],
    category_items: [],
    indicator_type_list: [],
    frequency_list: [],
    status_list: [],
    lead_orgs: [],
    ppr_list: ["Yes", "No"],
    modelBaselineDate: false,
    modelTargetDate: false,
    modelActualDate: false,
    dialog: false,
    subdialog: false,
    dialogDelete: false,
    searchBy: "",
    loadCSOIndicator: false,
    expanded: [],
    singleExpand: false,
    subHeaders: [
      {
        text: "Sub-Activity #",
        value: "indicator_no",
        width: "12%",
        sortable: true,
      },
      {
        text: "Description",
        value: "indicator",
        width: "20%",
        sortable: true,
      },
      {
        text: "Type",
        value: "indicator_type",
        width: "15%",
        sortable: true,
      },
      {
        text: "Data Source",
        value: "data_source",
        width: "20%",
        sortable: true,
      },
      {
        text: "Frequency",
        value: "frequency",
        width: "10%",
        sortable: true,
      },
      {
        text: "Unit of Measure",
        value: "unit_measure",
        width: "10%",
        sortable: true,
      },
      //{ text: "PPR", value: "ppr", width: "3%", sortable: false },
      {
        text: "Status",
        value: "indicator_status",
        width: "8%",
        sortable: true,
      },
      {
        text: "Remarks",
        value: "indicator_remarks",
        width: "8%",
        sortable: true,
      },
      {
        text: "Action",
        value: "actions",
        width: "8%",
        align: "right",
        sortable: false,
      },
    ],
    headers: [
      {
        text: "Activity #",
        width: "8%",
        align: "start",
        sortable: true,
        value: "cso_act_no",
      },
      {
        text: "Description",
        align: "start",
        sortable: true,
        value: "cso_description",
      },
      {
        text: "Lead Organization",
        align: "start",
        sortable: true,
        width: "15%",
        value: "cso_lead_organization",
      },
      {
        text: "Status",
        value: "cso_status",
        width: "10%",
        sortable: true,
      },
      {
        text: "Action",
        value: "actions",
        width: "10%",
        align: "right",
        sortable: false,
      },
      { text: "", value: "data-table-expand" },
    ],
    indicators_list: [],
    editedIndex: -1,
    editedItem: {
      cso_category: "",
      cso_description: "",
      cso_act_no: "",
      cso_lead_organization: "",
      cso_indicator_mov : "",
      cso_remarks : "",
      cso_status: "",
    },
    defaultItem: {
      cso_category: "",
      cso_description: "",
      cso_act_no: "",
      cso_lead_organization: "",
      cso_indicator_mov : "",
      cso_remarks : "",
      cso_status: "",
    },
    cso_id: "",
    formSubTitle: "",
    editedSubIndex: -1,
    editedSubItem: {
      indicator_no: "",
      indicator: "",
      indicator_type: "",
      data_source: "",
      frequency: "",
      unit_measure: "",
      indicator_remarks: "-",
      indicator_status: "Not Yet Started",
      ppr: "",
      baseline_date: "",
      baseline_value: "",
      target_date: "",
      target_value: "",
      actual_date: "",
      mov_file: "",
    },
    defaultSubItem: {
      indicator_no: "",
      indicator: "",
      indicator_type: "",
      data_source: "",
      frequency: "",
      unit_measure: "",
      indicator_remarks: "-",
      indicator_status: "Not Yet Started",
      ppr: "",
      baseline_date: "",
      baseline_value: "",
      target_date: "",
      target_value: "",
      actual_date: "",
      mov_file: "",
    },
    delete_indicator: "",
    delete_cso: "",
    rules: {
      required: (v) => !!v || "This field is required",
      number: (v) => {
        if (!v.trim()) return true;
        if (!isNaN(parseFloat(v)) && v >= 0) return true;
        return "The value entered was not valid.";
      },
    },
    isSelecting: false,
    file_name: [],
    file_attached: [],
    file2_name: [],
    file2_attached: [],
    isRemove: false,
    isAddingNew: true,
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1
        ? "New CSO2 Indicator"
        : "Edit CSO2 Indicator";
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
      debug(){
      },
    initialize() {
      document.title = "CSO² | Project Indicator";
			axios.get('/user-roles-permission').then( response => {
        const moduleName = 'CSOIndicator';
        const data = response.data; 
        for (const key in  data ){
          if( data[key].name == moduleName ){
            const crud_guard = data[key].crud_guard[0];
            if( crud_guard.view == 0 ) this.$router.push("dashboard");
            else this.crud_guard =  crud_guard ;
            break;
          }
        }
      })
      category_items: ["Impact", "Outcome", "Activity"],
        (this.loadCSOIndicator = true);
      // getLead organization list
      axios.get("/get-lead-organization").then((res)=>{
          this.lead_orgs = res.data
      })
      //
      axios.get("/get-categories").then((response) => {
        this.category_items = response.data;
      });
      //     indicator_type_list: ['Performance/Custom'],
      this.loadCSOIndicator = true;
      axios.get("/get-indicator-type").then((response) => {
        this.indicator_type_list = response.data;
      });
      //     frequency_list:['Annually','Yearly','Bi-Annual'],
      this.loadCSOIndicator = true;
      axios.get("/get-frequencies").then((response) => {
        this.frequency_list = response.data;
      });
      //     status_list: ['Entry', 'In Progress', 'Completed', 'Delayed'],
      this.loadCSOIndicator = true;
      axios.get("/get-indicator-status").then((response) => {
        // console.log( response.data )
        this.status_list = response.data;
      });

      if (this.catSelectedTab === "Activity")
        axios.get("/cso-indicator").then((response) => {
          
          //console.log(this.indicators_list);
          // this.indicators_list.map(function(item) {
          //     delete item.cso_category;
          //     return item;
          // });
          this.indicators_list = this.filterData(response);

          this.loadCSOIndicator = false;
        });
      else this.getFilteredIndicator();
    },
    //filter response before displaying to table
    filterData(response){
        var m_filter_value = this.selected_filter_item;
          var filter_value = '';

          if(this.selected_filter_item2.text) filter_value = this.selected_filter_item2.text
          else filter_value = this.selected_filter_item2

          if( m_filter_value === "Lead Organization" && !(this.selected_filter_item === "All" || filter_value.length === 0))
            return response.data.filter(item => (item.cso_lead_organization == filter_value))
          else if( m_filter_value === "Status")
            return response.data.filter(item => (item.cso_status == filter_value ))
          else
            return response.data;
    },
    initFilter2Items(){
        this.selected_filter_item2 = ''
        this.filter2_label = `Select ${this.selected_filter_item}`
        if(this.selected_filter_item === "Lead Organization")
            this.filter_items2 = this.lead_orgs;
        else if(this.selected_filter_item === "Status")
            this.filter_items2 = this.status_list
        else{
            this.selected_filter_item = 'All'
            this.selected_filter_item2 = ''
        }

        this.initialize()
    },
    getIndicator: function (categorySelected) {
      this.catSelectedTab = categorySelected;
      this.headers = this.resetHeaders()
      if (categorySelected === "Output") {
        // todo
        this.subHeaders[0].text = "Indicator #";
        this.headers.splice(3,0,{
            text: "MOV",
            width: "8%",
            align: "start",
            sortable: true,
            value: "cso_indicator_mov",
        }),
        this.headers.splice(5,0,{
            text: "Remarks",
            width: "10%",
            align: "start",
            sortable: true,
            value: "cso_remarks",
        })  
      } else if (categorySelected === "Activity") {
        // todor
        this.subHeaders[0].text = "Sub-Activity #";
      }

      console.log(this.indicators_list);

      this.headers[0].text = categorySelected + " #";

      this.indicators_list = [];
      this.loadCSOIndicator = true;
      this.getFilteredIndicator();
    },
    resetHeaders(){
        return [
      {
        text: "Activity #",
        width: "10%",
        align: "start",
        sortable: true,
        value: "cso_act_no",
      },
      {
        text: "Description",
        align: "start",
        sortable: true,
        value: "cso_description",
      },
      {
        text: "Lead Organization",
        align: "start",
        sortable: true,
        width: "15%",
        value: "cso_lead_organization",
      },
      {
        text: "Status",
        value: "cso_status",
        width: "10%",
        sortable: true,
      },
      {
        text: "Action",
        value: "actions",
        width: "10%",
        align: "right",
        sortable: false,
      },{ text: "", value: "data-table-expand" }
    ]
    },
    getFilteredIndicator() {
      axios
        .post("/cso-indicator-list", { category: this.catSelectedTab })
        .then((response) => {
          this.indicators_list = this.filterData(response);
          this.loadCSOIndicator = false;
        });
    },
    editItem(item) {
      this.isEditting = true;
      this.isAddingNew = false;
      console.log(this.isAddingNew, this.isEditting)
      this.editedIndex = this.indicators_list.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.file2_name = item.cso_indicator_mov;
      this.file2_attached = item.cso_indicator_mov;
      this.dialog = true;
    },

    deleteItem(item) {
      this.delete_cso = item.cso_indicator_id;
      this.dialogDelete = true;
    },

    addSubItem(item) {
      this.isEditting = true;
      this.isAddingNew = true;
      this.isRemove = false;
      this.editedIndex = -1;
      this.cso_id = item.cso_indicator_id;
      this.formSubTitle = "New Indicator Details";
      this.removeFile();
      this.editedSubItem = Object.assign({}, item);
      this.subdialog = true;
    },

    detailsSubItem(item) {
      this.isAddingNew = false;
      this.isEditting = false;
      this.file_name = '';

      this.formSubTitle = "Indicator Details";
      this.editedSubItem = Object.assign({}, item);
      console.log('SUB HAS FILE',this.editedSubItem.mov_file);
      if(this.editedSubItem.mov_file)
        this.file_name = this.editedSubItem.mov_file;
      this.detailsReadonly = true;
      this.subdialog = true;
    },

    editSubItem(item) {
      this.isEditting = true;
      this.isAddingNew = false;
      this.removeFile();
      this.editedIndex = 1;
      this.formSubTitle = "Edit Indicator Details";
      this.editedSubItem = Object.assign({}, item);

      if (item.mov_file) {
        this.file_name = item.mov_file;
        this.isRemove = true;
      }
      this.subdialog = true;
    },

    deleteSubItem(item) {
      this.delete_indicator = item.indicator_id;
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      this.btnLoader = true;
      this.indicators_list.splice(this.editedIndex, 1);
      if (this.delete_cso) {
        axios
          .post("/delete-cso-indicator", {
            delete_id: this.delete_cso,
          })
          .then((response) => {
            if (response.data.success) {
              this.initialize();
              this.$noty.success("Successfully deleted.");
              this.close();
            }
          });
      }

      if (this.delete_indicator) {
        axios
          .post("/delete-cso-indicator-details", {
            delete_id: this.delete_indicator,
          })
          .then((response) => {
            if (response.data.success) {
              this.initialize();
              this.close();
              this.$noty.success("Successfully deleted.");
            }
          });
      }
      this.closeDelete();
    },
    newActivity() {
      this.dialog = true;
      this.isAddingNew = true;
      this.isEditting = false;
    },
    close() {
      this.detailsReadonly = false;
      this.btnLoader = false;
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
      this.file_name = [];
      this.isEditting = false;
    },

    closeSub() {
      this.cso_id = "";
      this.detailsReadonly = false;
      this.btnLoader = false;
      this.editedIndex = -1;
      this.subdialog = false;
      this.removeFile();
      this.isEditting = false;
      this.isAddingNew = false;
    },

    closeDelete() {
      this.dialogDelete = false;
      this.btnLoader = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },

    save() {
      this.btnLoader = true;
      let validate = true;
      
      if (!this.editedItem.cso_category) {
        this.$noty.error("Category is empty!");
        validate = false;
      }

      if (!this.editedItem.cso_description) {
        this.$noty.error("Description is empty!");
        validate = false;
      }

      if (validate) {
        var formData = new FormData();

        formData.append("data", JSON.stringify(this.editedItem));
        formData.append("form_mode", this.editedIndex);
        formData.append("upload_file", this.file2_attached);
        formData.append("file_name", this.file2_name);

        axios
          .post("/save-cso-indicator", formData)
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
          });
      } else {
        this.btnLoader = false;
      }
    },

    saveSub() {
      this.btnLoader = true;
      let validate = true;
      if (!this.editedSubItem.indicator_no) {
        this.$noty.error("Indicator No is empty!");
        validate = false;
      }
      if (!this.editedSubItem.indicator) {
        this.$noty.error("Indicator is empty!");
        validate = false;
      }
      if (!this.editedSubItem.indicator_type) {
        this.$noty.error("Indicator Type is empty!");
        validate = false;
      }
      if (!this.editedSubItem.data_source) {
        this.$noty.error("Data Source is empty!");
        validate = false;
      }
      if (!this.editedSubItem.frequency) {
        this.$noty.error("Frequency is empty!");
        validate = false;
      }
      if (!this.editedSubItem.unit_measure) {
        this.$noty.error("Unit of Measure is empty!");
        validate = false;
      }
      if (!this.editedSubItem.ppr) {
        this.$noty.error("PPR is empty!");
        validate = false;
      }
      if (validate) {
        var formData = new FormData();
    
        if(!this.editedSubItem.indicator_remarks)
            this.editedSubItem.indicator_remarks = '';

        formData.append("data", JSON.stringify(this.editedSubItem));
        formData.append("form_mode", this.editedIndex);
        formData.append("cso_id", this.cso_id);
        formData.append("upload_file", this.file_attached);
        formData.append("file_name", this.file_name);
        axios.post("/save-cso-indicator-details", formData).then((response) => {
          if (response.data.success) {
            this.initialize();
            if (this.editedIndex < 0) {
              this.$noty.success("Successfully Added.");
            } else {
              this.$noty.success("Successfully Updated.");
            }
            this.closeSub();
            this.removeFile();
          } else {
            console.log("NOT SUCCESSS",response.data.success)
            this.removeFile();
            this.closeSub();
          }
        });
      } else {
        this.btnLoader = false;
      }
    },
    getColor(status) {
      if (status === "In Progress/Delayed" || status === "Delayed")
        return "red";
      else if (status === "In Progress") return "blue";
      else if (status === "Completed") return "green";
      else if (status === "Cancelled") return "grey";
      else if (status === "Not Yet Started") return "orange";
      else return "white";
    },

    getValue(value) {
      return value;
    },

    onButtonClick: function () {
      this.isSelecting = true;
      window.addEventListener(
        "focus",
        () => {
          this.isSelecting = false;
        },
        { once: true }
      );

      this.$refs.uploader.input.click();
    },
    onFileChanged: function (e) {
      var files = e;
      this.file_attached = files;
      this.file_name = files.name;
      this.isRemove = true;
    },
    removeFile: function (item) {
      this.file_name = [];
      this.isRemove = true;
      this.file_attached = [];
    },onFileChanged2: function (e) {
      var files = e;
      this.file2_attached = files;
      this.file2_name = files.name;
      this.isRemove = true;
    },
    removeFile2: function (item) {
      this.file2_name = '';
      this.file2_attached = '';
      this.isRemove = true;
    },

    exportExcel: function (tableName, value) {
      // console.log(tableName, value);
      this.btnLoader = true;
      let filename = tableName + ".xlsx";
      var formData = new FormData();
      formData.append("tableName", tableName);
      formData.append("category", value);
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
    // Generate Link for downloading MOV FileDesu
    getLink(file) {
      return `/downloadMov/?file_name=${file}`;
    },
    getLink2(file) {
      return `/downloadCSOMov/?file_name=${file}`;
    },
  },
};
</script>
