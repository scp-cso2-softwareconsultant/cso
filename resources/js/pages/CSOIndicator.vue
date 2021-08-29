<template>
    <v-app>
        <h3 class="subheading grey--text"> CSO2 (supercript) Project Indicator </h3>
        <div class="d-flex m-4 flex-between align-items-center">
            <p class="mb-0">
                <strong class="text-primary">Status Legends</strong>
            </p>
            <v-col class="mx-3" cols="2" v-for="(stats, idx) in status_list" :key="idx">
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
                                    <v-toolbar flat dense>
                                        <v-text-field
                                            v-model="searchBy"
                                            append-icon="mdi-magnify"
                                            label="Search"
                                            single-line
                                            hide-details
                                        ></v-text-field>
                                        <v-spacer></v-spacer>
                                        <v-dialog
                                            v-model="dialog"
                                            max-width="500px"
                                        >
                                            <template
                                                v-slot:activator="{ on, attrs }"
                                            >
                                                <v-btn
                                                    color="lightgray"
                                                    class="mb-2"
                                                    v-bind="attrs"
                                                    v-on="on"
                                                >
                                                    New
                                                    <v-icon color="green"
                                                        >mdi-plus-thick</v-icon
                                                    >
                                                </v-btn>
                                            </template>
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
                                                                        detailsReadonly
                                                                    "
                                                                    label="Indicator No. *"
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
                                                                        detailsReadonly
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.indicator
                                                                    "
                                                                    label="Indicator *"
                                                                    dense
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
                                                                <v-select
                                                                    :items="
                                                                        indicator_type_list
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
                                                                <v-text-field
                                                                    v-model="
                                                                        editedSubItem.indicator_type
                                                                    "
                                                                    label="Type *"
                                                                    dense
                                                                    readonly
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
                                                                        detailsReadonly
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.data_source
                                                                    "
                                                                    label="Data Source *"
                                                                    dense
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
                                                                <v-select
                                                                    :items="
                                                                        frequency_list
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.frequency
                                                                    "
                                                                    label="Frequency *"
                                                                    dense
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
                                                                <v-text-field
                                                                    v-model="
                                                                        editedSubItem.frequency
                                                                    "
                                                                    label="Frequency *"
                                                                    dense
                                                                    readonly
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
                                                                        detailsReadonly
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.unit_measure
                                                                    "
                                                                    label="Unit of Measure *"
                                                                    dense
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
                                                                <v-select
                                                                    :items="
                                                                        ppr_list
                                                                    "
                                                                    v-model="
                                                                        editedSubItem.ppr
                                                                    "
                                                                    label="PPR *"
                                                                    dense
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
                                                                <v-text-field
                                                                    v-model="
                                                                        editedSubItem.ppr
                                                                    "
                                                                    label="PPR *"
                                                                    dense
                                                                    readonly
                                                                ></v-text-field>
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
                                                            >
                                                                <!--                                            <v-file-input-->
                                                                <!--                                                label="MOV"-->
                                                                <!--                                                v-model="editedSubItem.mov_file"-->
                                                                <!--                                                append-outer-icon="mdi-paperclip"-->
                                                                <!--                                            ></v-file-input>-->
                                                                <div
                                                                    v-if="
                                                                        isRemove
                                                                    "
                                                                >
                                                                    <v-btn
                                                                        background
                                                                        depressed
                                                                        @click="
                                                                            removeFile
                                                                        "
                                                                        >{{
                                                                            file_name
                                                                        }}
                                                                    </v-btn>
                                                                </div>
                                                                <div v-else>
                                                                    <v-btn
                                                                        text
                                                                        small
                                                                        :loading="
                                                                            isSelecting
                                                                        "
                                                                        color="blue darken-1"
                                                                        @click="
                                                                            onButtonClick
                                                                        "
                                                                    >
                                                                        Upload
                                                                        MOV
                                                                    </v-btn>
                                                                    <input
                                                                        ref="uploader"
                                                                        class="d-none"
                                                                        type="file"
                                                                        @change="
                                                                            onFileChanged
                                                                        "
                                                                    />
                                                                </div>
                                                            </v-col>
                                                        </v-row>
                                                    </v-container>
                                                </v-card-text>
                                                <v-card-actions
                                                    v-if="!detailsReadonly"
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
                                        &nbsp;&nbsp;
                                        <v-btn
                                            color="lightgray"
                                            class="mb-2"
                                            :loading="btnLoader"
                                            @click="
                                                exportExcel(
                                                    'CSO2 Indicator',
                                                    item.value
                                                )
                                            "
                                        >
                                            Export
                                            <v-icon color="green"
                                                >mdi-microsoft-excel</v-icon
                                            >
                                        </v-btn>
                                    </v-toolbar>
                                </template>
                                <template v-slot:item.cso_status="{ item }">
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
                                        small
                                        @click="deleteItem(item)"
                                        color="red"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        title="Delete"
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
                                                v-slot:item.actions="{ item }"
                                            >
                                                <v-icon
                                                    small
                                                    class="mr-2"
                                                    @click="
                                                        detailsSubItem(item)
                                                    "
                                                    color="blue"
                                                >
                                                    mdi-information-outline
                                                </v-icon>
                                                <br />
                                                <v-icon
                                                    small
                                                    class="mr-2"
                                                    @click="editSubItem(item)"
                                                    color="blue darken-2"
                                                >
                                                    mdi-pencil
                                                </v-icon>
                                                <br />
                                                <v-icon
                                                    small
                                                    @click="deleteSubItem(item)"
                                                    color="red"
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
        tabCategory: null,
        btnLoader: false,
        detailsReadonly: false,
        category_tabs: [
            { text: "Activity", value: "Activity" },
            { text: "Output", value: "Output" },
            { text: "Outcome", value: "Outcome" },
            { text: "Impact", value: "Impact" }
        ],
        category_items: [],
        indicator_type_list: [],
        frequency_list: [],
        status_list: [],
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
                text: "Indicator No.",
                value: "indicator_no",
                width: "12%",
                sortable: false
            },
            {
                text: "Indicator",
                value: "indicator",
                width: "20%",
                sortable: false
            },
            {
                text: "Type",
                value: "indicator_type",
                width: "15%",
                sortable: false
            },
            {
                text: "Data Source",
                value: "data_source",
                width: "20%",
                sortable: false
            },
            {
                text: "Frequency",
                value: "frequency",
                width: "15%",
                sortable: false
            },
            {
                text: "Unit of Measure",
                value: "unit_measure",
                width: "15%",
                sortable: false
            },
            { text: "PPR", value: "ppr", width: "3%", sortable: false },
            {
                text: "Action",
                value: "actions",
                width: "5%",
                align: "center",
                sortable: false
            }
        ],
        headers: [
            {
                text: "Category",
                align: "start",
                sortable: false,
                value: "cso_category",
                width: "15%"
            },
            {
                text: "Description",
                align: "start",
                sortable: false,
                value: "cso_description"
            },
            {
                text: "Status",
                value: "cso_status",
                width: "10%",
                sortable: false
            },
            {
                text: "Action",
                value: "actions",
                width: "10%",
                align: "right",
                sortable: false
            },
            { text: "", value: "data-table-expand" }
        ],
        indicators_list: [],
        editedIndex: -1,
        editedItem: {
            cso_category: "",
            cso_description: ""
        },
        defaultItem: {
            cso_category: "",
            cso_description: ""
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
            ppr: "",
            baseline_date: "",
            baseline_value: "",
            target_date: "",
            target_value: "",
            actual_date: "",
            mov_file: ""
        },
        defaultSubItem: {
            indicator_no: "",
            indicator: "",
            indicator_type: "",
            data_source: "",
            frequency: "",
            unit_measure: "",
            ppr: "",
            baseline_date: "",
            baseline_value: "",
            target_date: "",
            target_value: "",
            actual_date: "",
            mov_file: ""
        },
        delete_indicator: "",
        delete_cso: "",
        rules: {
            required: v => !!v || "This field is required",
            number: v => {
                if (!v.trim()) return true;
                if (!isNaN(parseFloat(v)) && v >= 0) return true;
                return "The value entered was not valid.";
            }
        },
        isSelecting: false,
        file_name: "",
        file_attached: "",
        isRemove: false
    }),

    computed: {
        formTitle() {
            return this.editedIndex === -1
                ? "New CSO2 Indicator"
                : "Edit CSO2 Indicator";
        }
    },

    watch: {
        dialog(val) {
            val || this.close();
        },
        dialogDelete(val) {
            val || this.closeDelete();
        }
    },

    created() {
        this.initialize();
    },

    methods: {
        initialize() {
            document.title = "CSO2 | (supercript) Project Indicator"
            category_items: ["Impact", "Outcome", "Activity"],
                (this.loadCSOIndicator = true);
            axios.get("/get-categories").then(response => {
                this.category_items = response.data;
                
            });
            //     indicator_type_list: ['Performance/Custom'],
            this.loadCSOIndicator = true;
            axios.get("/get-indicator-type").then(response => {
                this.indicator_type_list = response.data;
               
            });
            //     frequency_list:['Annually','Yearly','Bi-Annual'],
            this.loadCSOIndicator = true;
            axios.get("/get-frequencies").then(response => {
                this.frequency_list = response.data;
               
            });
            //     status_list: ['Entry', 'In Progress', 'Completed', 'Delayed'],
            this.loadCSOIndicator = true;
            axios.get("/get-indicator-status").then(response => {
                console.log( response.data )
                this.status_list = response.data;
                
            });


            axios.get("/cso-indicator").then(response => {
                console.log( response.data )
                this.indicators_list = response.data;
                this.loadCSOIndicator = false;
            });
        },
        getIndicator: function(categorySelected) {
            this.indicators_list = [];
            this.loadCSOIndicator = true;
            axios
                .post("/cso-indicator-list", { category: categorySelected })
                .then(response => {
                    this.indicators_list = response.data;
                    this.loadCSOIndicator = false;
                });
        },
        editItem(item) {
            this.editedIndex = this.indicators_list.indexOf(item);
            this.editedItem = Object.assign({}, item);
            this.dialog = true;
        },

        deleteItem(item) {
            this.delete_cso = item.cso_indicator_id;
            this.dialogDelete = true;
        },

        addSubItem(item) {
            this.cso_id = item.cso_indicator_id;
            this.formSubTitle = "New Indicator Details";
            this.editedSubItem = Object.assign({}, item);
            this.subdialog = true;
        },

        detailsSubItem(item) {
            this.formSubTitle = "Indicator Details";
            this.editedSubItem = Object.assign({}, item);
            this.detailsReadonly = true;
            this.subdialog = true;
        },

        editSubItem(item) {
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
                        delete_id: this.delete_cso
                    })
                    .then(response => {
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
                        delete_id: this.delete_indicator
                    })
                    .then(response => {
                        if (response.data.success) {
                            this.initialize();
                            this.close();
                            this.$noty.success("Successfully deleted.");
                        }
                    });
            }
            this.closeDelete();
        },

        close() {
            this.detailsReadonly = false;
            this.btnLoader = false;
            this.dialog = false;
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem);
                this.editedIndex = -1;
            });
        },

        closeSub() {
            this.cso_id = "";
            this.detailsReadonly = false;
            this.btnLoader = false;
            this.editedIndex = -1;
            this.subdialog = false;
            this.removeFile();
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
                axios
                    .post("/save-cso-indicator", {
                        data: JSON.stringify(this.editedItem),
                        form_mode: this.editedIndex
                    })
                    .then(response => {
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
                formData.append("data", JSON.stringify(this.editedSubItem));
                formData.append("form_mode", this.editedIndex);
                formData.append("cso_id", this.cso_id);
                formData.append("upload_file", this.file_attached);
                formData.append("file_name", this.file_name);
                axios
                    .post("/save-cso-indicator-details", formData)
                    .then(response => {
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
                            this.removeFile();
                            this.closeSub();
                        }
                    });
            } else {
                this.btnLoader = false;
            }
        },
        getColor(status) {
<<<<<<< HEAD
            if (status === "In Progress/Delayed" || status === "Delay")
=======
            // console.log(status);
            if (status === "In Progress/delayed" || status === "Delay")
>>>>>>> 26c8c0e514429ec2794eac00113817674e241740
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

        onButtonClick: function() {
            this.isSelecting = true;
            window.addEventListener(
                "focus",
                () => {
                    this.isSelecting = false;
                },
                { once: true }
            );

            this.$refs.uploader.click();
        },
        onFileChanged: function(e) {
            var files = e.target.files || e.dataTransfer.files;
            this.file_attached = files[0];
            this.file_name = files[0].name;
            this.isRemove = true;
        },
        removeFile: function(item) {
            this.file_name = "";
            this.isRemove = false;
            this.file_attached = "";
        },

        exportExcel: function(tableName, value) {
            // console.log(tableName, value);
            this.btnLoader = true;
            let filename = tableName + ".xlsx";
            var formData = new FormData();
            formData.append("tableName", tableName);
            formData.append("category", value);
            axios
                .post("/export-excel", formData, { responseType: "blob" })
                .then(response => {
                    const url = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", filename);
                    document.body.appendChild(link);
                    link.click();
                    this.btnLoader = false;
                });
        }
    }
};
</script>
