<template>
  <page :alert="alert" title="Product Options">
    <card has-actions title="Option Groups">
      <div class="action-btn-group" slot="actions">
        <base-button
          @click="showPanel.new = true"
          type="primary"
          size="sm"
          icon="fas fa-plus"
        >New Group</base-button>
      </div>
      <div class="table-responsive">
        <base-table
          class="table align-items-center table-flush"
          thead-classes="thead-light"
          tbody-classes="list"
          :data="table.data"
        >
          <template slot="columns">
            <th>Name</th>
            <th class="w-100">Type</th>
            <th>Values</th>
            <th>Actions</th>
          </template>

          <template slot-scope="{row}">
            <th scope="row">
              <span class="mb-0 text-sm">{{row.display_name}}</span>
            </th>
            <td>
              <span v-for="item in row.values" :key="item.id">{{item.label}}</span>
            </td>
            <td>{{ row.type }}</td>
            <td>
              <base-icon @click="openEditPanel(row)" icon="fas fa-cog"></base-icon>
            </td>
          </template>
        </base-table>
      </div>
    </card>

    <option-group-add-panel
      :groups="groupNames"
      @show-alert="handleAlert"
      @close="closeNewPanel"
      :open="showPanel.new"
    ></option-group-add-panel>

    <option-group-edit-panel
      :group="currentGroup"
      :groups="groupNames"
      @show-alert="handleAlert"
      @close="closeEditPanel"
      :open="showPanel.edit"
    ></option-group-edit-panel>
  </page>
</template>

<script>
import OptionGroupAddPanel from "./OptionGroup/OptionGroupAddPanel";
import OptionGroupEditPanel from "./OptionGroup/OptionGroupEditPanel";
export default {
  components: { OptionGroupEditPanel, OptionGroupAddPanel },
  data() {
    return {
      showPanel: {
        new: false,
        edit: false
      },
      table: {
        data: [],
        paginate: 20
      },
      currentGroup: {},
      alert: {
        show: false,
        text: "New group added successfully!",
        type: "success",
        autoClose: true
      },
      groupNames: []
    };
  },
  created() {
    this.fetchOptionGroups();
  },
  mounted() {},
  methods: {
    checkRefresh(e) {
      this.refreshTable = true;
    },
    openEditPanel(group) {
      this.currentGroup = group;
      this.showPanel.edit = true;
    },
    closeEditPanel() {
      this.showPanel.edit = false;
      this.fetchOptionGroups();
    },
    handleAlert(e) {
      this.alert.text = e.text;
      this.alert.type = e.type;
      setTimeout(() => {
        this.alert.show = e.show;
      },400)
    },
    closeNewPanel(refresh) {
      this.showPanel.new = false;
      this.fetchOptionGroups();
    },
    fetchOptionGroups() {
      axios
        .get("/api/products/option-groups", {
          params: {
            paginate: this.table.paginate
          }
        })
        .then(res => {
          console.log(res);
          this.table.data = res.data.data;
          this.groupNames = res.data.data.map(g => g.name);
        });
    },
    createGroup() {
      axios
        .post("/api/products/option-group/create", {
          display_name: this.displayName
          // type: this.type
        })
        .then(res => {
          this.$emit("refresh", "created group");
        });
    }
  },
  computed: {}
};
</script>

<style>
</style>