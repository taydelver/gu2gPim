<template>
  <page :alert="alert" title="Attributes">
    <card has-actions title="Attribute Groups">
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
            <th class="w-100">Values</th>
            <th class="text-center">Actions</th>

          </template>

          <template slot-scope="{row}">
            <th scope="row">
              <span class="mb-0 text-sm">{{row.name}}</span>
            </th>
            <td class="w-100">
              <span class="text-overflow">
              </span>
            </td>
            <td class="text-center">
              <base-icon @click="openEditPanel(row)" icon="fas fa-cog"></base-icon>
            </td>
          </template>
        </base-table>
      </div>
    </card>

    <attribute-group-add-panel
      @show-alert="handleAlert"
      @close="closeNewPanel"
      :open="showPanel.new"
    ></attribute-group-add-panel>

    <attribute-group-edit-panel
      :group="currentGroup"
      @show-alert="handleAlert"
      @close="closeEditPanel"
      :open="showPanel.edit"
    ></attribute-group-edit-panel>
  </page>
</template>

<script>
import AttributeGroupAddPanel from "./Attributes/AttributeGroupAddPanel";
import AttributeGroupEditPanel from "./Attributes/AttributeGroupEditPanel";
export default {
  components: { AttributeGroupAddPanel, AttributeGroupEditPanel },
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
      alert: {
        show: false,
        text: "New group added successfully!",
        type: "success",
        autoClose: true
      },
      currentGroup: {},
    };
  },
  created() {
    this.fetchAttributes();
  },
  mounted() {},
  methods: {
    openEditPanel(group) {
      this.currentGroup = group;
      this.showPanel.edit = true;
    },
    closeEditPanel() {
      this.showPanel.edit = false;
      this.fetchAttributes();
    },
    handleAlert(e) {
      this.alert.text = e.text;
      this.alert.type = e.type;
      setTimeout(() => {
        this.alert.show = e.show;
      },400)
    },
    closeNewPanel() {
      this.showPanel.new = false;
      this.fetchAttributes()
    },
    fetchAttributes() {
      axios
        .get("/api/attribute-groups", {
          params: {
            paginate: this.table.paginate
          }
        })
        .then(res => {
          console.log(res);
          this.table.data = res.data.data;
        });
    },
    renderModels(models) {
      const m = models.map(i => i.value)
      return m.join(', ')
    }
  },
  computed: {

  }
};
</script>

<style>

.text-overflow {
  display: block;
    width: 100%;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}
.small-cell {
  max-width: 180px;
}
</style>