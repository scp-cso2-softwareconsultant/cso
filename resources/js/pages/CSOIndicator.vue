<template>
  <v-app>
    <h3 class="subheading grey--text">
      CSO² Project Indicator
      <!-- <button @click="debug">TEST</button> -->
    </h3>
    <v-dialog v-model="dialog" max-width="500px">
      <!-- Hello World -->
      <v-card>
        <v-card-title>
          <span class="text-h5">{{ formTitle }}</span>
        </v-card-title>

        <v-card-text>
          <v-container dense>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-select
                  :items="category_items"
                  v-model="editedItem.cso_category"
                  :rules="[rules.required]"
                  value="editedItem.cso_category"
                  label="Category *"
                  dense
                ></v-select>
              </v-col>
              <v-col cols="12" v-show="catSelectedTab === 'Activity'">
                <v-combobox
                  :readonly="detailsReadonly"
                  v-model="cso_objective"
                  :items="cso_objectives"
                  label="Objectives"
                  dense
                  multiple
                ></v-combobox>
              </v-col>
            </v-row>

            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  :rules="[rules.required]"
                  v-model="editedItem.cso_description"
                  label="Description *"
                  dense
                >
                </v-textarea>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-select
                  :items="lead_orgs"
                  v-model="editedItem.cso_lead_organization"
                  :rules="[rules.required]"
                  label="Lead Organization *"
                  dense
                ></v-select>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  v-model="editedItem.cso_act_no"
                  :rules="[rules.required]"
                  color="purple darken-2"
                  :label="headers[0].text"
                  required
                  auto-grow
                  rows="1"
                  dense
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="12" md="12" v-if="editedItem.created_at">
                <v-select
                  :items="status_list"
                  v-model="editedItem.cso_status"
                  label="Status"
                  dense
                ></v-select>
              </v-col>
            </v-row>
            <v-row v-if="catSelectedTab === 'Output'" class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  v-model="editedItem.cso_remarks"
                  label="Remarks"
                  dense
                >
                </v-textarea>
              </v-col>
            </v-row>
            <v-row v-if="catSelectedTab === 'Output'" class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <p class="mt-4 font-weight-bold">Attached File</p>
                <div v-if="isEditting">
                  <div v-if="file_name.length !== 0">
                    <v-chip
                      class="ma-2"
                      close
                      color="indigo darken-3"
                      outlined
                      @click:close="removeFile"
                    >
                      <v-icon left> mdi-file </v-icon>
                      {{ limitChipName(file_name) }}
                    </v-chip>
                  </div>
                  <div v-else>
                    <v-file-input v-model="file_name" @change="onFileChanged">
                    </v-file-input>
                  </div>
                </div>
                <div v-else>
                  <div v-if="file_name.length !== 0">
                    <v-tooltip top>
                      <template>
                        <v-chip class="ma-2" color="indigo darken-3" outlined>
                          <v-icon left> mdi-file </v-icon>
                          {{ limitChipName(file_name) }}
                        </v-chip>
                      </template>

                      <span>Download {{ file_name }}</span>
                    </v-tooltip>
                  </div>
                  <div v-else>
                    <v-chip class="ma-2" color="indigo darken-3" outlined>
                      <v-icon left> mdi-file-remove-outline</v-icon>
                      No Attached File
                    </v-chip>
                  </div>
                </div>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close" dense>
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
    <v-dialog v-model="dialogDelete" max-width="500px">
      <v-card class="text-center">
        <h6 class="text-center text-xl pt-4">
          Are you sure you want to delete this item?
        </h6>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeDelete">Cancel</v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="deleteItemConfirm"
            :loading="btnLoader"
            >OK</v-btn
          >
          <v-spacer></v-spacer>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <v-dialog v-model="subdialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="text-h5">{{ formSubTitle }}</span>
        </v-card-title>
        <v-card-text>
          <v-container dense>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  v-model="editedSubItem.indicator_no"
                  :rules="[rules.required]"
                  :readonly="!isEditting"
                  :label="this.subHeaders[0].text"
                  dense
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  :rules="[rules.required]"
                  :readonly="!isEditting"
                  v-model="editedSubItem.indicator"
                  label="Description *"
                  dense
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-select
                  :items="indicator_type_list"
                  :readonly="!isEditting"
                  v-model="editedSubItem.indicator_type"
                  label="Type *"
                  dense
                  :rules="[rules.required]"
                ></v-select>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  :rules="[rules.required]"
                  :readonly="!isEditting"
                  v-model="editedSubItem.data_source"
                  label="Data Source *"
                  dense
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-select
                  :items="frequency_list"
                  v-model="editedSubItem.frequency"
                  label="Frequency *"
                  dense
                  :readonly="!isEditting"
                  :rules="[rules.required]"
                ></v-select>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  :rules="[rules.required]"
                  :readonly="!isEditting"
                  v-model="editedSubItem.unit_measure"
                  label="Unit of Measure *"
                  dense
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row>
              <v-col cols="12" sm="12" md="12">
                <v-select
                  :items="status_list"
                  v-model="editedSubItem.indicator_status"
                  label="Status"
                  :readonly="!isEditting"
                  dense
                ></v-select>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  :readonly="!isEditting"
                  v-model="editedSubItem.indicator_remarks"
                  label="Remarks"
                  dense
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-select
                  :items="ppr_list"
                  v-model="editedSubItem.ppr"
                  label="PPR *"
                  dense
                  :readonly="!isEditting"
                  :rules="[rules.required]"
                ></v-select>
              </v-col>
            </v-row>

            <v-row class="mt-0" v-if="detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  v-model="editedSubItem.baseline_date"
                  label="Baseline Date"
                  dense
                  readonly
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="!detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-menu
                  ref="modelBaselineDate"
                  v-model="modelBaselineDate"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="auto"
                  dense
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="editedSubItem.baseline_date"
                      label="Baseline Date"
                      readonly
                      persistent-hint
                      append-outer-icon="mdi-calendar"
                      v-bind="attrs"
                      v-on="on"
                      dense
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="editedSubItem.baseline_date"
                    no-title
                    @input="modelBaselineDate = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  :readonly="detailsReadonly"
                  v-model="editedSubItem.baseline_value"
                  label="Baseline Value"
                  dense
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  v-model="editedSubItem.target_date"
                  label="Target Date"
                  dense
                  readonly
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="!detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-menu
                  ref="modelTargetDate"
                  v-model="modelTargetDate"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="auto"
                  dense
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="editedSubItem.target_date"
                      label="Target Date"
                      readonly
                      persistent-hint
                      append-outer-icon="mdi-calendar"
                      v-bind="attrs"
                      v-on="on"
                      dense
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="editedSubItem.target_date"
                    no-title
                    @input="modelTargetDate = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  :readonly="detailsReadonly"
                  v-model="editedSubItem.target_value"
                  label="Target Value"
                  dense
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  v-model="editedSubItem.actual_date"
                  label="Actual date"
                  dense
                  readonly
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="!detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-menu
                  ref="modelTargetDate"
                  v-model="modelActualDate"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="auto"
                  dense
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="editedSubItem.actual_date"
                      label="Actual Date"
                      readonly
                      persistent-hint
                      append-outer-icon="mdi-calendar"
                      v-bind="attrs"
                      v-on="on"
                      dense
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="editedSubItem.actual_date"
                    no-title
                    @input="modelActualDate = false"
                  ></v-date-picker>
                </v-menu>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12"
                ><p class="mt-4 font-weight-bold">Attached File</p>
                <div v-if="isEditting">
                  <div v-if="file_name.length !== 0">
                    <v-chip
                      class="ma-2"
                      close
                      color="indigo darken-3"
                      outlined
                      @click:close="removeFile"
                    >
                      <v-icon left> mdi-file </v-icon>
                      {{ limitChipName(file_name) }}
                    </v-chip>
                  </div>
                  <div v-else>
                    <v-file-input v-model="file_name" @change="onFileChanged">
                    </v-file-input>
                  </div>
                </div>
                <div v-else>
                  <div v-if="file_name.length > 0">
                    <v-tooltip bottom>
                      <template v-slot:activator="{ on, attrs }">
                          <v-chip
                            class="ma-2"
                            color="indigo darken-3"
                            outlined
                            v-on="on"
                          >
                            <v-icon left> mdi-file </v-icon>
                            <a
                              :href="`/downloadMov/?file_name=${file_name}&category=${catSelectedTab}`"
                              target="blank"
                            >
                            {{ limitChipName(file_name)}}
                            </a>
                          </v-chip>
                      </template>
                      <span>Download {{file_name}}</span>
                    </v-tooltip>
                  </div>
                  <div v-else>
                    <v-chip class="ma-2" color="indigo darken-3" outlined>
                      <v-icon left> mdi-file-remove-outline</v-icon>
                      No Attached File
                    </v-chip>
                  </div>
                </div>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions v-if="isEditting">
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="closeSub" dense>
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
        class="mx-3 btn"
        cols="2"
        v-for="(stats, idx) in status_list"
        :key="idx"
      >
        <v-progress-linear
          class="rounded-top rounded-bottom text-white text-center"
          height="35"
          :color="getColor(stats.text)"
          @click="setFilterByStatus(stats.text)"
          value="100"
          >{{ stats.value }}</v-progress-linear
        >
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
                    <a :href="`/downloadCSOMov/?file_name=${file_name}`">
                      <v-icon center color="primary">
                        mdi-file-download-outline
                      </v-icon>
                    </a>
                  </div>
                </template>
                <template v-slot:top>
                  <v-toolbar class="py-4" flat dense>
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
                    <v-btn
                      v-show="crud_guard.create"
                      color="lightgray"
                      class="mb-2"
                      @click="newActivity"
                    >
                      New
                      <v-icon color="green">mdi-plus-thick</v-icon>
                    </v-btn>
                    &nbsp;&nbsp;
                    <v-btn
                      v-show="crud_guard.export"
                      color="lightgray"
                      class="mb-2"
                      :loading="btnLoader"
                      @click="exportExcel('CSOIndicator', item.value)"
                    >
                      Export
                      <v-icon color="green">mdi-microsoft-excel</v-icon>
                    </v-btn>
                  </v-toolbar>
                </template>
                <template v-slot:item.cso_status="{ item }">
                  <v-progress-linear
                    class="rounded-top text-white text-center"
                    height="23"
                    value="100"
                    :color="getColor(item.cso_status)"
                  ></v-progress-linear>
                  <!-- <v-progress-linear
                                        indeterminate
                                        class="rounded-bottom text-white text-center"
                                        height="2"
                                        :color="getColor(item.cso_status)"
                                    ></v-progress-linear> -->
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
                <template v-slot:expanded-item="{ headers, item }">
                  <td :colspan="headers.length">
                    <v-data-table
                      :headers="subHeaders"
                      :items="item.subItems"
                      class="elevation-1"
                    >
                      <template v-slot:item.indicator_status="{ item }">
                        <v-progress-linear
                          class="rounded-top text-white text-center"
                          height="23"
                          value="100"
                          :color="getColor(item.indicator_status)"
                        ></v-progress-linear>
                        <!-- <v-progress-linear
                                                    indeterminate
                                                    class="rounded-bottom text-white text-center"
                                                    height="2"
                                                    :color="getColor(item.indicator_status)"
                                                ></v-progress-linear> -->
                      </template>
                      <template v-slot:item.actions="{ item }">
                        <v-icon
                          v-show="crud_guard.view"
                          small
                          class="mr-2"
                          @click="detailsSubItem(item)"
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
                  <v-toolbar class="py-4" flat dense>
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
                    <v-btn
                      v-show="crud_guard.create"
                      color="lightgray"
                      class="mb-2"
                      @click="newActivity"
                    >
                      New
                      <v-icon color="green">mdi-plus-thick</v-icon>
                    </v-btn>
                    &nbsp;&nbsp;
                    <v-btn
                      v-show="crud_guard.export"
                      color="lightgray"
                      class="mb-2"
                      :loading="btnLoader"
                      @click="exportExcel('CSOIndicator', item.value)"
                    >
                      Export
                      <v-icon color="green">mdi-microsoft-excel</v-icon>
                    </v-btn>
                  </v-toolbar>
                </template>
                <template v-slot:item.cso_status="{ item }">
                  <v-progress-linear
                    class="rounded-top text-white text-center"
                    height="23"
                    value="100"
                    :color="getColor(item.cso_status)"
                  ></v-progress-linear>
                  <!-- <v-progress-linear
                                        indeterminate
                                        class="rounded-bottom text-white text-center"
                                        height="2"
                                        :color="getColor(item.cso_status)"
                                    ></v-progress-linear> -->
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
                <template v-slot:expanded-item="{ headers, item }">
                  <td :colspan="headers.length">
                    <v-data-table
                      :headers="subHeaders"
                      :items="item.subItems"
                      class="elevation-1"
                    >
                      <template v-slot:item.indicator_status="{ item }">
                        <v-progress-linear
                          class="rounded-top text-white text-center"
                          height="23"
                          value="100"
                          :color="getColor(item.indicator_status)"
                        ></v-progress-linear>
                        <!-- <v-progress-linear
                                                    indeterminate
                                                    class="rounded-bottom text-white text-center"
                                                    height="2"
                                                    :color="getColor(item.indicator_status)"
                                                ></v-progress-linear> -->
                      </template>
                      <template v-slot:item.actions="{ item }">
                        <v-icon
                          v-show="crud_guard.view"
                          small
                          class="mr-2"
                          @click="detailsSubItem(item)"
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
    selected_filter_item: ["All"],
    filter_items: ["All", "Lead Organization", "Status"],

    selected_filter_item2: [],
    filter_items2: [],
    filter2_label: "",
    //
    copyItem: {},
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
      //{ text: "Intermediate Outcomes", value: "Intermediate Outcomes" }
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
      { text: "", value: "data-table-expand" },
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
    ],
    indicators_list: [],
    editedIndex: -1,
    cso_objectives: [
      { value: "objective_1", text: "Objective 1" },
      { value: "objective_2", text: "Objective 2" },
      { value: "objective_3", text: "Objective 3" },
      { value: "objective_4", text: "Objective 4" },
    ],
    cso_objective: "",
    editedItem: {
      cso_category: "",
      cso_description: "",
      cso_act_no: "",
      cso_lead_organization: "",
      cso_indicator_mov: "",
      //cso_intermediate_outcome: "",
      cso_remarks: "",
      cso_status: "",
      objective_1: false,
      objective_2: false,
      objective_3: false,
      objective_4: false,
    },
    defaultItem: {
      cso_category: "",
      cso_description: "",
      cso_act_no: "",
      cso_lead_organization: "",
      cso_indicator_mov: "",
      //cso_intermediate_outcome: "",
      cso_remarks: "",
      cso_status: "",
      objective_1: false,
      objective_2: false,
      objective_3: false,
      objective_4: false,
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
    isRemove: false,
    fileRemoveOnSave: false,
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
    initialize() {
      document.title = "SCP: CSO² Project | Project Indicator";
      axios.get("/user-roles-permission").then((response) => {
        const moduleName = "CSOIndicator";
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
      category_items: ["Impact", "Outcome", "Activity"],
        (this.loadCSOIndicator = true);
      // getLead organization list
      axios.get("/get-lead-organization").then((res) => {
        this.lead_orgs = res.data;
      });
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
        this.status_list = response.data;
      });

      if (this.catSelectedTab === "Activity")
        axios.get("/cso-indicator").then((response) => {
          this.indicators_list = this.filterData(response);
          this.loadCSOIndicator = false;
        });
      else this.getFilteredIndicator();

      this.file2_name = "";
      this.file2_attached = [];
    },
    async verifyNoExist(url, id, cat) {
      try {
        const response = await axios.get(
          `/${url}/?act_no=${id.replace(/[^\d.-]/g, "")}&category=${cat}`
        );
        const arr = [];

        for (let x = 0; x < response.data.length; x++) {
          if (
            response.data[x].cso_act_no.replace(/[^\d.-]/g, "") ==
            id.replace(/[^\d.-]/g, "")
          )
            arr[arr.length] = response.data[x].cso_act_no.replace(
              /[^\d.-]/g,
              ""
            );
        }

        if (arr.length !== 0) {
          return true;
        } else {
          return false;
        }
      } catch (error) {}
    },

    async verifySubNoExist(url, cso_indicator_id, indicator_no) {
      try {
        const response = await axios.get(
          `/${url}/?cso_indicator_id=${cso_indicator_id}&indicator_no=${indicator_no}`
        );
        const arr = [];

        for (let x = 0; x < response.data.length; x++) {
          if (
            response.data[x].indicator_no.replace(/[^\d.-]/g, "") ===
            indicator_no.replace(/[^\d.-]/g, "")
          )
            arr[arr.length] = response.data[x].indicator_no.replace(
              /[^\d.-]/g,
              ""
            );
        }

        if (arr.length !== 0) {
          return true;
        } else {
          return false;
        }
      } catch (error) {
        console.log(error);
      }
    },
    setFilterByStatus(status) {
      //TODO
      this.selected_filter_item = "Status";
      this.selected_filter_item2 = { text: status, value: status };
      this.filter_items2 = this.status_list;
      this.initialize();
    },
    filterData(response) {
      var m_filter_value = this.selected_filter_item;
      var filter_value = "";
      if (this.selected_filter_item2.text)
        filter_value = this.selected_filter_item2.text;
      else filter_value = this.selected_filter_item2;

      if (
        m_filter_value === "Lead Organization" &&
        !(this.selected_filter_item === "All" || filter_value.length === 0)
      )
        return response.data.filter(
          (item) => item.cso_lead_organization == filter_value
        );
      else if (m_filter_value === "Status")
        return response.data.filter((item) => item.cso_status == filter_value);
      else return response.data;
    },
    initFilter2Items() {
      this.selected_filter_item2 = "";
      this.filter2_label = `Select ${this.selected_filter_item}`;
      if (this.selected_filter_item === "Lead Organization")
        this.filter_items2 = this.lead_orgs;
      else if (this.selected_filter_item === "Status")
        this.filter_items2 = this.status_list;
      else {
        this.selected_filter_item = "All";
        this.selected_filter_item2 = "";
      }
      this.initialize();
    },
    getIndicator: function (categorySelected) {
      this.catSelectedTab = categorySelected;
      this.headers = this.resetHeaders();

      if (this.catSelectedTab === "Activity")
        this.headers.splice(2, 0, {
          text: "Lead Organization",
          align: "start",
          sortable: true,
          width: "15%",
          value: "cso_lead_organization",
        });

      if (categorySelected === "Output") {
        this.subHeaders[1].text = "Indicator #";
        this.headers.splice(3, 0, {
          text: "MOV",
          width: "8%",
          align: "start",
          sortable: true,
          value: "cso_indicator_mov",
        });
        this.headers.splice(5, 0, {
          text: "Remarks",
          width: "10%",
          align: "start",
          sortable: true,
          value: "cso_remarks",
        });
      } else if (categorySelected === "Activity") {
        this.subHeaders[0].text = "Sub-Activity #";
      } else if (categorySelected === "Outcome") {
        //   this.headers.splice(3,0,{
        //       text: "Intermediate Outcome",
        //       width: "10%",
        //       align: "start",
        //       sortable: false,
        //       value: "cso_intermediate_outcome"
        //   })
      } else {
        this.subHeaders[0].text = "Indicator #";
      }

      this.headers[0].text = categorySelected + " #";

      this.indicators_list = [];
      this.loadCSOIndicator = true;
      this.getFilteredIndicator();
    },
    resetHeaders() {
      return [
        {
          text: "Activity #",
          width: "10%",
          align: "start",
          sortable: true,
          value: "cso_act_no",
        },
        { text: "", value: "data-table-expand" },
        {
          text: "Description",
          align: "start",
          sortable: true,
          value: "cso_description",
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
      ];
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
      this.copyItem = {};
      this.copyItem = item;
      this.isEditting = true;
      this.isAddingNew = false;
      this.editedIndex = this.indicators_list.indexOf(item);
      this.editedItem = Object.assign({}, item);

      let objectives = [];
      for (const obj in item)
        if (obj.includes("objective") && item[obj])
          objectives.push({
            value: obj,
            text: "Objective " + obj.replace(/[^0-9]/g, ""),
          });

      this.file_name = this.isNotDefine(this.editedItem.cso_indicator_mov)
        ? []
        : this.editedItem.cso_indicator_mov;
      this.cso_objective = objectives;
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
      this.file_name = [];

      this.formSubTitle = "Indicator Details";
      this.editedSubItem = Object.assign({}, item);

      this.detailsReadonly = true;
      this.file_name = this.isNotDefine(this.editedSubItem.mov_file)
        ? []
        : this.editedSubItem.mov_file;
      this.subdialog = true;
    },

    editSubItem(item) {
      this.copyItem = {};
      this.copyItem = item;
      this.isEditting = true;
      this.isAddingNew = false;
      this.removeFile();
      this.editedIndex = 1;
      this.formSubTitle = "Edit Indicator Details";
      this.editedSubItem = Object.assign({}, item);

      this.file_name = this.isNotDefine(this.editedSubItem.mov_file)
        ? []
        : this.editedSubItem.mov_file;
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
      this.isEditting = true;
      this.isAddingNew = true;
    },
    close() {
      this.detailsReadonly = false;
      this.btnLoader = false;
      this.dialog = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
      this.cso_objective = [];
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

    async save() {
      this.btnLoader = true;
      let validate = true;
      this.btnLoader = true;
      const objective = this.cso_objective;
      const objectives = this.cso_objectives;
      for (const ob in objectives) {
        this.editedItem[objectives[ob].value] = false;
      }
      for (const ob in objective) {
        this.editedItem[objective[ob].value] = true;
      }
      if (!this.editedItem.cso_category) {
        this.$noty.error("Category is empty!");
        validate = false;
      }

      if (!this.editedItem.cso_description) {
        this.$noty.error("Description is empty!");
        validate = false;
      }

      if (!this.editedItem.cso_lead_organization) {
        this.$noty.error("Lead Organization is empty!");
        validate = false;
      }

      if (!this.editedItem.cso_act_no && validate) {
        this.$noty.error("Activity # is empty!");
        validate = false;
      } else {
        let check = await this.verifyNoExist(
          "checkNoExist",
          this.editedItem.cso_act_no,
          this.editedItem.cso_category
        );
        if (check && this.isAddingNew) {
          this.$noty.error(
            `${this.editedItem.cso_category} # ${this.editedItem.cso_act_no} already exist`
          );
          validate = false; 
        } else {
          let check = await this.verifyNoExist(
            "checkNoExist",
            this.editedItem.cso_act_no,
            this.editedItem.cso_category
          );
          if (
            check &&
            this.copyItem.cso_act_no.replace(/[^\d.-]/g, "") !=
              this.editedItem.cso_act_no.replace(/[^\d.-]/g, "")
          ) {
            this.$noty.error(
              `${this.editedItem.cso_category} # ${this.editedItem.cso_act_no} already exist`
            );
            validate = false; 
          }
        }
      }

      if (validate) {
        var formData = new FormData();
        if (this.file_name.length === 0)
          formData.append("fileRemoveOnSave", true);
        formData.append("data", JSON.stringify(this.editedItem));
        formData.append("form_mode", this.editedIndex);
        formData.append("upload_file", this.file_attached);
        formData.append("file_name", this.file_name);

        axios.post("/save-cso-indicator", formData).then((response) => {
          if (response.data.success) {
            this.initialize();
            if (this.editedIndex < 0) {
              this.$noty.success("Successfully Added.");
            } else {
              this.$noty.success("Successfully Updated.");
              this.fileRemoveOnSave = false;
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

    async saveSub() {
      this.btnLoader = true;
      let validate = true;
      if (!this.editedSubItem.indicator_no) {
        this.$noty.error("Indicator No is empty!");
        validate = false;
      } else {
        let check = await this.verifySubNoExist(
          "checkSuNoExist",
          this.editedSubItem.cso_indicator_id,
          this.editedSubItem.indicator_no
        );
        if (check && !this.isEditting) {
          this.$noty.error(
            `${this.subHeaders[0].text.replace("#", "")}${
              this.editedSubItem.indicator_no
            } already exist`
          );
          validate = false;
        } else {
          if (
            check &&
            this.copyItem.indicator_no.replace(/[^\d.-]/g, "") !=
              this.editedSubItem.indicator_no.replace(/[^\d.-]/g, "")
          ) {
            this.$noty.error(
              `${this.subHeaders[0].text.replace("#", "")}${
                this.editedSubItem.indicator_no
              } already exist`
            );
            validate = false;
          }
        }
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

        if (!this.editedSubItem.indicator_remarks)
          this.editedSubItem.indicator_remarks = "";

        if (this.file_name.length === 0)
          formData.append("fileRemoveOnSave", true);

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
    },
    exportExcel: function (tableName, value) {
      this.btnLoader = true;
      let filename = tableName + ".xlsx";
      var formData = new FormData();
      var tablename =
        this.catSelectedTab === "Output" ? "CSOIndicator-Output" : tableName;
      tablename =
        this.catSelectedTab === "Outcome" ? "CSOIndicator-Outcome" : tablename;
      tablename =
        this.catSelectedTab === "Impact" ? "CSOIndicator-Impact" : tablename;
      formData.append("tableName", tablename);
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
    }
  },
};
</script>
