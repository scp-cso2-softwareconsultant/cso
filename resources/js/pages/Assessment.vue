<template>
  <v-app>
    <h3 class="subheading grey--text">Assessment</h3>
    <br />
    <v-dialog v-model="dialog" max-width="500px">
      <v-card>
        <v-card-title>
          <span class="text-h5" v-if="!detailsReadonly">{{ formTitle }}</span>
          <span class="text-h5" v-else>Assessment Details</span>
        </v-card-title>
        <v-card-text>
          <v-container dense>
            <v-row class="mt-0" v-if="!detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-select
                  :items="cso_name_items"
                  v-model="editedItem.lro_id"
                  label="Name of LRO *"
                  dense
                  :rules="[rules.required]"
                ></v-select>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  v-model="editedItem.cso_name"
                  label="Name of LRO *"
                  dense
                  readonly
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  v-model="editedItem.proj_area"
                  label="Project Area"
                  dense
                  readonly
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="editedIndex != -1 && !detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-select
                  :items="status_list"
                  v-model="editedItem.status"
                  label="Status"
                  dense
                ></v-select>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  v-model="editedItem.status"
                  label="Status"
                  dense
                  readonly
                ></v-text-field>
              </v-col>
            </v-row>
            <!-- <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  v-model="editedItem.domain"
                  :readonly="detailsReadonly"
                  :rules="[rules.required]"
                  label="Domain *"
                  dense
                ></v-text-field>
              </v-col>
            </v-row> -->

            <v-row class="mt-0" v-if="!detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-select
                  :items="tool_list"
                  v-model="editedItem.tool_used"
                  label="Tool Used *"
                  dense
                  :rules="[rules.required]"
                ></v-select>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  v-model="editedItem.tool_used"
                  label="Tool Used *"
                  dense
                  readonly
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  :readonly="detailsReadonly"
                  v-model="editedItem.final_score"
                  label="Final Score"
                  dense
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  :readonly="detailsReadonly"
                  v-model="editedItem.conducted_by"
                  label="Conducted By"
                  dense
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="!detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-menu
                  ref="modelAssessmentDate"
                  v-model="modelAssessmentDate"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="auto"
                  dense
                >
                  <template v-slot:activator="{ on, attrs }">
                    <v-text-field
                      v-model="editedItem.assessment_date"
                      label="Assessment Date"
                      persistent-hint
                      append-outer-icon="mdi-calendar"
                      v-bind="attrs"
                      v-on="on"
                      dense
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="editedItem.assessment_date"
                    no-title
                    @input="modelAssessmentDate = false"
                    dense
                  ></v-date-picker>
                </v-menu>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  v-model="editedItem.assessment_date"
                  label="Assessment Date"
                  dense
                  readonly
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row class="mt-0">
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
                            :href="`/downloadAssessMov/?file_name=${editedItem.mov}`"
                            target="blank"
                          >
                            {{ limitChipName(file_name) }}
                          </a>
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

        <v-card-actions v-if="!detailsReadonly">
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="close" dense>
            Cancel
          </v-btn>
          <v-btn
            color="blue darken-1"
            text
            @click="save"
            :loading="btnLoader"
            dense
          >
            Save
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
    <v-dialog v-model="dialogDelete" max-width="500px">
      <v-card>
        <v-card-title class="text-h5"
          >Are you sure you want to delete this item?</v-card-title
        >
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
                  v-model="editedSubItem.sub_domain"
                  :rules="[rules.required]"
                  :readonly="detailsReadonly"
                  label="Domain *"
                  dense
                ></v-text-field>
              </v-col>
            </v-row>

            <v-row class="mt-0" v-if="!detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <!-- <v-select
                  :items="rating_list"
                  v-model="editedSubItem.rating"
                  label="Rating *"
                  dense
                  :rules="[rules.required]"
                ></v-select> -->
                <v-text-field
                  v-model="editedSubItem.rating"
                  :rules="[rules.required]"
                  :readonly="detailsReadonly"
                  label="Rating *"
                  dense
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row class="mt-0" v-if="detailsReadonly">
              <v-col cols="12" sm="12" md="12">
                <v-text-field
                  v-model="editedSubItem.rating"
                  label="Rating *"
                  dense
                  readonly
                ></v-text-field>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <v-textarea
                  auto-grow
                  rows="1"
                  :readonly="detailsReadonly"
                  v-model="editedSubItem.remarks"
                  label="Remarks"
                  dense
                ></v-textarea>
              </v-col>
            </v-row>
            <v-row class="mt-0">
              <v-col cols="12" sm="12" md="12">
                <p class="mt-4 font-weight-bold">Attached File</p>
                <div v-if="file_name.length !== 0">
                  <v-chip
                    class="ma-2"
                    close
                    color="indigo darken-3"
                    outlined
                    @click:close="removeFile"
                  >
                    <v-icon left> mdi-file </v-icon>
                    {{ file_name }}
                  </v-chip>
                </div>
                <div v-else>
                  <v-file-input v-model="file_name" @change="onFileChanged">
                  </v-file-input>
                </div>
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>
        <v-card-actions v-if="!detailsReadonly">
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
    <v-card>
      <v-data-table
        :headers="headers"
        :items="lroList"
        :single-expand="singleExpand"
        :expanded.sync="expanded"
        :search="filters.filter_items[filters.filter_items_active].value"
        :custom-filter="filterItems"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        :loading="loadLROAssessment"
        item-key="lro_assessment_id"
        class="elevation-1"
        show-expand
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-spacer></v-spacer>
            <v-btn
              v-if="crud_guard.create"
              color="lightgray"
              class="mb-2"
              @click="newAsessment"
            >
              New
              <v-icon color="green">mdi-plus-thick</v-icon>
            </v-btn>
            &nbsp;&nbsp;
            <v-btn
              color="lightgray"
              v-if="crud_guard.export"
              class="mb-2"
              :loading="btnLoader"
              @click="exportExcel('Assessment', '')"
            >
              Export
              <v-icon color="green">mdi-microsoft-excel</v-icon>
            </v-btn>
          </v-toolbar>

          <v-row no-gutters style="flex-wrap: nowrap">
            <v-col
              cols="1"
              style="min-width: 100px; max-width: 70%"
              class="flex-grow-1 flex-shrink-0"
            >
              <v-select
                v-model="filters.filter_items['cso_name'].value"
                :label="filters.filter_items['cso_name'].text"
                :items="filters.filter_items['cso_name'].multiple_selection"
                @input="changeFilterActiveValue('cso_name')"
                outlined
                hide-details
              ></v-select>
            </v-col>
            <v-col
              cols="4"
              style="min-width: 100px; max-width: 50%"
              class="flex-grow-1 flex-shrink-0"
            >
              <v-text-field
                v-model="filters.filter_items['domain'].value"
                :label="filters.filter_items['domain'].text"
                @input="changeFilterActiveValue('domain')"
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
                v-model="filters.filter_items['tool_used'].value"
                :label="filters.filter_items['tool_used'].text"
                :items="filters.filter_items['tool_used'].multiple_selection"
                @input="changeFilterActiveValue('tool_used')"
                outlined
                hide-details
              ></v-select>
            </v-col>
          </v-row>
          <v-row no-gutters style="flex-wrap: nowrap" class="my-3">
            <v-col
              cols="3"
              style="min-width: 50px"
              class="flex-grow-0 flex-shrink-1"
            >
              <div
                v-if="
                  filters.filter_items['final_score_selection'].value != 'range'
                "
              >
                <v-text-field
                  v-model="filters.filter_items['final_score'].value"
                  :label="filters.filter_items['final_score'].text"
                  @input="changeFilterActiveValue('final_score')"
                  :rules="[rules.number]"
                  outlined
                  hide-details
                ></v-text-field>
              </div>
              <div v-else>
                <v-text-field
                  v-model="filters.filter_items['final_score_min'].value"
                  :label="filters.filter_items['final_score_min'].text"
                  @input="changeFilterActiveValue('final_score_min')"
                  :rules="[rules.number]"
                  outlined
                  hide-details
                ></v-text-field>
                <v-text-field
                  v-model="filters.filter_items['final_score_max'].value"
                  :label="filters.filter_items['final_score_max'].text"
                  @input="changeFilterActiveValue('final_score_max')"
                  :rules="[rules.number]"
                  outlined
                  hide-details
                ></v-text-field>
              </div>
            </v-col>
            <v-col cols="2" class="flex-grow-1 flex-shrink-0">
              <v-select
                v-model="filters.filter_items['final_score_selection'].value"
                :label="filters.filter_items['final_score_selection'].text"
                :items="
                  filters.filter_items['final_score_selection']
                    .multiple_selection
                "
                @input="changeFilterActiveValue('final_score_selection')"
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
                v-model="filters.filter_items['status'].value"
                :label="filters.filter_items['status'].text"
                :items="filters.filter_items['status'].multiple_selection"
                @input="changeFilterActiveValue('status')"
                outlined
                hide-details
              ></v-select>
            </v-col>
          </v-row>
          <v-row no-gutters style="flex-wrap: nowrap">
            <v-col
              cols="4"
              style="min-width: 100px; max-width: 50%"
              class="flex-grow-1 flex-shrink-0"
            >
              <v-text-field
                v-model="filters.filter_items['conducted_by'].value"
                :label="filters.filter_items['conducted_by'].text"
                @input="changeFilterActiveValue('conducted_by')"
                append-icon="mdi-magnify"
                outlined
                hide-details
              ></v-text-field>
            </v-col>
            <v-col
              cols="4"
              style="min-width: 50px"
              class="flex-grow-0 flex-shrink-1"
            >
              <div
                v-if="
                  filters.filter_items['displayDate_selection'].value != 'range'
                "
              >
                <v-menu
                  v-model="filters.filter_items['displayDate'].fromDateMenu"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                  hide-details
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      readonly
                      v-on="on"
                      :value="filters.filter_items['displayDate'].value"
                      :label="filters.filter_items['displayDate'].text"
                      @input="changeFilterActiveValue('displayDate')"
                      append-icon="mdi-magnify"
                      outlined
                      hide-details
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    locale="en-in"
                    hide-details
                    v-model="filters.filter_items['displayDate'].value"
                    @input="
                      filters.filter_items['displayDate'].fromDateMenu = false;
                      changeFilterActiveValue('displayDate');
                    "
                  ></v-date-picker>
                </v-menu>
              </div>
              <div v-else>
                <v-menu
                  v-model="filters.filter_items['displayDate_min'].fromDateMenu"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                  hide-details
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      readonly
                      v-on="on"
                      :value="filters.filter_items['displayDate_min'].value"
                      :label="filters.filter_items['displayDate_min'].text"
                      @input="changeFilterActiveValue('displayDate_min')"
                      append-icon="mdi-magnify"
                      outlined
                      hide-details
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    locale="en-in"
                    v-model="filters.filter_items['displayDate_min'].value"
                    @input="
                      filters.filter_items[
                        'displayDate_min'
                      ].fromDateMenu = false;
                      changeFilterActiveValue('displayDate_min');
                    "
                  ></v-date-picker>
                </v-menu>

                <v-menu
                  v-model="filters.filter_items['displayDate_max'].fromDateMenu"
                  :close-on-content-click="false"
                  transition="scale-transition"
                  offset-y
                  max-width="290px"
                  min-width="290px"
                  hide-details
                >
                  <template v-slot:activator="{ on }">
                    <v-text-field
                      readonly
                      v-on="on"
                      :value="filters.filter_items['displayDate_max'].value"
                      :label="filters.filter_items['displayDate_max'].text"
                      @input="changeFilterActiveValue('displayDate_max')"
                      append-icon="mdi-magnify"
                      outlined
                    ></v-text-field>
                  </template>
                  <v-date-picker
                    v-model="filters.filter_items['displayDate_max'].value"
                    @input="
                      filters.filter_items[
                        'displayDate_max'
                      ].fromDateMenu = false;
                      changeFilterActiveValue('displayDate_max');
                    "
                    hide-details
                  ></v-date-picker>
                </v-menu>
              </div>
            </v-col>
            <v-col cols="2" class="flex-grow-1 flex-shrink-0">
              <v-select
                v-model="filters.filter_items['displayDate_selection'].value"
                :label="filters.filter_items['displayDate_selection'].text"
                :items="
                  filters.filter_items['displayDate_selection']
                    .multiple_selection
                "
                @input="changeFilterActiveValue('displayDate_selection')"
                v-on:change="
                  if (filters.filter_items['displayDate_selection'].value == '')
                    filters.filter_items['displayDate'].value = '';
                "
                outlined
              ></v-select>
            </v-col>
          </v-row>
        </template>
        <template v-slot:item.mov="{ item }">
          <div v-if="item.mov">
            <!-- <v-btn text color="primary"
                               @click="downloadFile(item.mov)">
                            {{ item.file_name_old }}
                            <v-icon center color="primary">
                                mdi-file-download-outline
                            </v-icon>
                        </v-btn> -->
            <a
              :href="`/downloadAssessMov/?file_name=${item.mov}`"
              target="blank"
            >
              <v-icon center color="primary">
                mdi-file-download-outline
              </v-icon>
            </a>
          </div>
        </template>
        <template v-slot:item.actions="{ item }">
          <v-icon
            v-if="crud_guard.create"
            small
            class="mr-2"
            @click="addSubItem(item)"
            color="green"
            data-toggle="tooltip"
            data-placement="top"
            title="New Domain"
          >
            mdi-sticker-plus-outline
          </v-icon>
          <v-icon
            v-if="crud_guard.view"
            small
            class="mr-2"
            @click="detailsItem(item)"
            color="blue"
            data-toggle="tooltip"
            data-placement="top"
            title="Assessment Details"
          >
            mdi-information-outline
          </v-icon>
          <v-icon
            v-if="crud_guard.update"
            small
            class="mr-2"
            @click="editItem(item)"
            color="blue darken-2"
            data-toggle="tooltip"
            data-placement="top"
            title="Edit Assessment"
          >
            mdi-pencil
          </v-icon>
          <v-icon
            v-if="crud_guard.delete"
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
              <template v-slot:item.file_attachment="{ item }">
                <div v-if="item.file_attachment">
                  <a
                    :href="`/downloadAssessSubAttach/?file_name=${item.file_attachment}`"
                    target="blank"
                  >
                    <v-icon center color="primary">
                      mdi-file-download-outline
                    </v-icon>
                  </a>
                </div>
              </template>
              <template v-slot:item.actions="{ item }">
                <v-icon
                  v-if="crud_guard.update"
                  small
                  class="mr-2"
                  @click="editSubItem(item)"
                  color="blue darken-2"
                  data-toggle="tooltip"
                  data-placement="top"
                  title="Edit Subdomain"
                >
                  mdi-pencil
                </v-icon>
                <v-icon
                  v-if="crud_guard.delete"
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
  </v-app>
</template>

<script>
export default {
  data: (vm) => ({
    dialog: false,
    btnLoader: false,
    dialogDelete: false,
    loadLROAssessment: false,
    detailsReadonly: false,
    modelAssessmentDate: false,
    // hideProjArea: true,
    cso_name_items: [],
    status_list: [],
    expanded: [],
    tool_list: ["OCAT", "OPI"],
    singleExpand: false,
    searchBy: "",
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

    sortBy: "fat",
    sortDesc: false,
    filters: {
      filter_items_active: "cso_name",
      filter_items: {
        cso_name: {
          value: "",
          text: "Name",
          data_value: "cso_name",
          multiple_selection: [{ text: "None", value: "" }],
        },
        domain: {
          value: "",
          text: "Domain",
          data_value: "domain",
        },
        conducted_by: {
          value: "",
          text: "Conducted by",
          data_value: "conducted_by",
        },
        tool_used: {
          value: "",
          text: "Tool used",
          data_value: "tool_used",
          multiple_selection: [
            { text: "None", value: "" },
            { value: "OCAT", text: "OCAT" },
            { value: "OPI", text: "OPI" },
          ],
        },
        // ============================= Date range['OCAT', 'OPI']
        displayDate: {
          value: "",
          text: "Date of Assessment",
          data_value: "displayDate",
          fromDateMenu: false, // For the calendar modal (true to show calendar)
          date_range: true, // Enables min and max value (Prerequisits are below)
        },
        displayDate_min: {
          value: "",
          text: "Assesment from",
          data_value: "displayDate_min",
          inherit_value: "displayDate", // <--------------------------- Needed for the key
          fromDateMenu: false,
          date_range: true,
        },
        displayDate_max: {
          value: "",
          text: "Assesment to",
          data_value: "displayDate_max",
          inherit_value: "displayDate", // <--------------------------- Needed for the key
          fromDateMenu: false,
          date_range: true,
        },
        displayDate_selection: {
          value: "==",
          text: "Choose value",
          data_value: "displayDate_selection",
          inherit_value: "displayDate", // <--------------------------- Needed for the key
          multiple_selection: [
            { text: "None", value: "" },
            { text: "Range", value: "range" },
            { text: "Equal to", value: "==" },
            { text: "Greater than or equal to", value: ">=" },
            { text: "Less than or equal to", value: "<=" },
            { text: "Greater than", value: ">" },
            { text: "Less than", value: "<" },
          ],
        },
        // =============================  Date range

        // ============================= Final score range
        final_score: {
          value: "",
          text: "Final Score",
          data_value: "final_score",
          number_range: true, // Enables min and max value (Prerequisits are below)
        },
        final_score_min: {
          value: "",
          text: "Final score min",
          data_value: "Final Score min",
          inherit_value: "final_score", // <--------------------------- Needed for the key
          number_range: true,
        },
        final_score_max: {
          value: "",
          text: "Final score max",
          data_value: "Final Score max",
          inherit_value: "final_score", // <--------------------------- Needed for the key
          number_range: true,
        },
        final_score_selection: {
          value: "==",
          text: "Choose value",
          data_value: "final_score",
          inherit_value: "final_score", // <--------------------------- Needed for the key
          multiple_selection: [
            { text: "Range", value: "range" },
            { text: "Equal to", value: "==" },
            { text: "Greater than or equal to", value: ">=" },
            { text: "Less than or equal to", value: "<=" },
            { text: "Greater than", value: ">" },
            { text: "Less than", value: "<" },
          ],
        },
        // =============================Final score range

        status: {
          value: "",
          text: "Status",
          data_value: "status",
          multiple_selection: [{ text: "None", value: "" }],
        },
      },
    },
    headers: [
      {
        text: "",
        width: "2%",
        value: "data-table-expand",
      },
      {
        text: "Name of LRO",
        align: "start",
        sortable: true,
        value: "cso_name",
        width: "20%",
      },
      // {
      // 	text: 'Domain',
      // 	value: 'domain',
      // 	width: '15%',
      // 	sortable: true
      // },
      {
        text: "Tool Used",
        value: "tool_used",
        width: "10%",
        sortable: true,
      },
      {
        text: "Conducted By",
        value: "conducted_by",
        width: "15%",
        sortable: true,
      },
      {
        text: "Date of Assessment",
        value: "displayDate",
        width: "12%",
        sortable: true,
      },
      {
        text: "Final Score",
        value: "final_score",
        width: "10%",
        sortable: false,
        align: "right",
      },
      {
        text: "MOV",
        value: "mov",
        width: "3%",
        sortable: false,
        align: "center",
      },
      {
        text: "Status",
        value: "status",
        width: "10%",
        sortable: false,
      },
      {
        text: "Actions",
        value: "actions",
        width: "10%",
        sortable: false,
      },
    ],
    subHeaders: [
      {
        text: "Domain",
        align: "start",
        sortable: false,
        value: "sub_domain",
        width: "25%",
      },
      {
        text: "Rating",
        value: "rating",
        width: "15%",
        sortable: false,
      },
      {
        text: "Remarks",
        value: "remarks",
        sortable: false,
      },
      {
        text: "Attachment",
        value: "file_attachment",
        sortable: false,
      },
      {
        text: "Actions",
        value: "actions",
        width: "10%",
        sortable: false,
      },
    ],
    lroList: [],
    editedIndex: -1,
    editedItem: {
      lro_id: "",
      proj_area: "",
      domain: "",
      tool_used: "",
      conducted_by: "",
      assessment_date: "",
      final_score: "",
      mov: "",
      status: "",
    },
    defaultItem: {
      lro_id: "",
      proj_area: "",
      domain: "",
      tool_used: "",
      conducted_by: "",
      assessment_date: "",
      final_score: "",
      mov: "",
      status: "",
    },
    editedSubItem: {
      lro_assessment_id: "",
      sub_domain: "",
      rating: "",
      file_attachment: "",
      remarks: "",
    },
    defaultSubItem: {
      lro_assessment_id: "",
      sub_domain: "",
      file_attachment: "",
      rating: "",
      remarks: "",
    },
    delete_lro: "",
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
    isRemove: false,
    isSelecting: false,
    isCreatingNew: false,
    file_name: [],
    file_attached: "",
    assessment_id: "",
    formSubTitle: "",
    subdialog: false,
    delete_lro_sub: "",
    rating_list: [],
    isEditting: false,
  }),

  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "New Assessment" : "Edit Assessment";
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
      this.loadLROAssessment = true;
      document.title = "SCP: CSO² Project | Assessment";
      axios.get("/user-roles-permission").then((response) => {
        const moduleName = "Assessment";
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

      axios.get("/cso-name-list").then((response) => {
        const data = response.data;
        this.cso_name_items = data;

        var multiple_selection = [{ text: "None", value: "" }];

        for (const value in data) {
          const select_text_value = data[value].text;
          multiple_selection.push({
            text: select_text_value,
            value: select_text_value,
          });
        }
        this.filters.filter_items.cso_name.multiple_selection =
          multiple_selection;
      });

      axios.get("/lro-status").then((response) => {
        const data = response.data.concat([{ text: "None", value: "" }]);
        this.status_list = data;
        this.filters.filter_items.status.multiple_selection = data;
      });

      axios.get("/lro-assessment").then((response) => {
        this.lroList = response.data;
        this.lroList.forEach((item) => {
          item.displayDate = this.formatDate(item.assessment_date);
        });
        this.loadLROAssessment = false;

        console.log("ASSESSMENT", this.lroList);
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
      const active = this.$MultiFilters.changeFilterActiveValue(
        key,
        filter,
        active_key,
        active_value
      );
      console.log(this.filters.filter_items[active].value);
      this.filters.filter_items_active = active;
    },
    toggleOrder() {
      this.sortDesc = !this.sortDesc;
    },
    nextSort() {
      let index = this.headers.findIndex((h) => h.value === this.sortBy);
      index = (index + 1) % this.headers.length;
      this.sortBy = this.headers[index].value;
    },
    formatDate(date) {
      var today = new Date(date);
      var dd = String(today.getDate()).padStart(2, "0");
      var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
      var yyyy = today.getFullYear();
      return `${mm}/${dd}/${yyyy}`;
    },
    detailsItem(item) {
      this.detailsReadonly = true;
      this.editedIndex = this.lroList.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.file_name = this.isNotDefine(this.editedItem.mov)
        ? []
        : this.editedItem.mov;
      this.dialog = true;
    },
    isNotDefine(item) {
      return item == null || item.length === 0 || item === undefined;
    },
    editItem(item) {
      this.editedIndex = this.lroList.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.isEditting = true;
      this.file_name = this.isNotDefine(this.editedItem.mov)
        ? []
        : this.editedItem.mov;
      this.dialog = true;
    },

    deleteItem(item) {
      this.delete_lro = item.lro_assessment_id;
      this.editedIndex = this.lroList.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },

    addSubItem(item) {
      this.rating_list = item.rating_tool;
      this.assessment_id = item.lro_assessment_id;
      this.formSubTitle = "New Domain";
      this.editedSubItem = Object.assign({}, item);
      this.subdialog = true;
    },

    detailsSubItem(item) {
      this.formSubTitle = "Domain Details";
      this.editedSubItem = Object.assign({}, item);
      this.detailsReadonly = true;
      this.file_name = this.isNotDefine(this.editedSubItem.file_attachment)
        ? []
        : this.editedSubItem.file_attachment;

      this.subdialog = true;
    },

    editSubItem(item) {
      this.editedIndex = 1;
      this.edditing = true;
      this.formSubTitle = "Edit Domain";
      this.editedSubItem = Object.assign({}, item);
      this.file_name = this.isNotDefine(this.editedSubItem.file_attachment)
        ? []
        : this.editedSubItem.file_attachment;
      console.log(this.editedSubItem);
      this.subdialog = true;
    },

    deleteSubItem(item) {
      this.delete_lro_sub = item.lro_sub_id;
      this.dialogDelete = true;
    },

    deleteItemConfirm() {
      this.btnLoader = true;
      this.lroList.splice(this.editedIndex, 1);

      if (this.delete_lro) {
        axios
          .post("/delete-lro-assessment", {
            delete_id: this.delete_lro,
          })
          .then((response) => {
            if (response.data.success) {
              this.initialize();
              this.$noty.success("Successfully deleted.");
              this.closeDelete();
            }
          });
      }

      if (this.delete_lro_sub) {
        axios
          .post("/delete-lro-sub-assessment", {
            delete_id: this.delete_lro_sub,
          })
          .then((response) => {
            if (response.data.success) {
              this.initialize();
              this.$noty.success("Successfully deleted.");
              this.closeDelete();
            }
          });
      }
    },

    close() {
      this.dialog = false;
      this.btnLoader = false;
      this.detailsReadonly = false;
      this.isEditting = false;
      this.isCreatingNew = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
      this.removeFile();
    },

    closeSub() {
      this.assessment_id = "";
      (this.isEditting = false), (this.detailsReadonly = false);
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
      if (!this.editedItem.lro_id) {
        this.$noty.error("Name of LRO is empty!");
        validate = false;
      }
      // if (!this.editedItem.domain) {
      // 	this.$noty.error('Domain is empty!');
      // 	validate = false;
      // }
      if (!this.editedItem.tool_used) {
        this.$noty.error("Tool Used is empty!");
        validate = false;
      }
      if (validate) {
        var formData = new FormData();
        console.log(this.editedItem);
        formData.append("data", JSON.stringify(this.editedItem));
        if (this.file_name.length === 0)
          formData.append("delete_attachedFile", true);
        console.log(this.file_name.length === []);
        formData.append("form_mode", this.editedIndex);
        formData.append("upload_file", this.file_attached);
        formData.append("file_name", this.file_name);
        axios.post("/save-lro-assessment", formData).then((response) => {
          if (response.data.success) {
            this.initialize();
            if (this.editedIndex < 0) {
              this.$noty.success("Successfully Added.");
            } else {
              this.$noty.success("Successfully Updated.");
            }
            this.close();
            this.removeFile();
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
      if (!this.editedSubItem.sub_domain) {
        this.$noty.error("Sub Domain is empty!");
        validate = false;
      }
      if (!this.editedSubItem.rating) {
        this.$noty.error("Rating is empty!");
        validate = false;
      }
      if (isNaN(this.editedSubItem.rating)) {
        this.$noty.error("Rating is Not a valid Number!");
        validate = false;
      }

      if (validate) {
        var formData = new FormData();
        formData.append("data", JSON.stringify(this.editedSubItem));
        formData.append("form_mode", this.editedIndex);
        if (this.file_name.length === 0)
          formData.append("delete_attachedFile", true);
        formData.append("lro_assessment_id", this.assessment_id);
        formData.append("upload_file", this.file_attached);
        formData.append("file_name", this.file_name);
        axios.post("/save-lro-sub-assessment", formData).then((response) => {
          if (response.data.success) {
            this.initialize();
            if (this.editedIndex < 0) {
              this.$noty.success("Successfully Added.");
            } else {
              this.$noty.success("Successfully Updated.");
            }
            this.closeSub();
          } else {
            this.closeSub();
          }
        });
      } else {
        this.btnLoader = false;
      }
    },
    newAsessment() {
      this.isCreatingNew = true;
      this.dialog = true;
    },

    onButtonClick: function () {
      this.isSelecting = true;
      window.addEventListener(
        "focus",
        () => {
          this.isSelecting = false;
        },
        {
          once: true,
        }
      );

      this.$refs.uploader.click();
    },
    onFileChanged: function (e) {
      var files = e;
      this.file_attached = files;
      this.file_name = files.name;
    },
    removeFile: function (item) {
      this.file_name = [];
      this.isRemove = false;
      this.file_attached = "";
    },
    // downloadFile: function(encoded_url){
    //     window.open("download/"+encoded_url);
    // },
    exportExcel: function (tableName, value) {
      this.btnLoader = true;
      let filename = tableName + ".xlsx";
      var formData = new FormData();
      formData.append("tableName", tableName);
      formData.append("category", value);
      axios
        .post("/export-excel", formData, {
          responseType: "blob",
        })
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
