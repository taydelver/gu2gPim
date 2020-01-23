<template>
  <page :alert="alert" title="Fitments">
    <card has-actions title="Fitment Groups">
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
              {{renderModels(row.models)}}
              </span>
            </td>
            <td class="text-center">
              <base-icon @click="openEditPanel(row)" icon="fas fa-cog"></base-icon>
            </td>
          </template>
        </base-table>
      </div>
    </card>

    <fitment-group-add-panel
      @show-alert="handleAlert"
      @close="closeNewPanel"
      :open="showPanel.new"
    ></fitment-group-add-panel>

    <fitment-group-edit-panel
      :group="currentGroup"
      @show-alert="handleAlert"
      @close="closeEditPanel"
      :open="showPanel.edit"
    ></fitment-group-edit-panel>
  </page>
</template>

<script>
import FitmentGroupAddPanel from "./Fitments/FitmentGroupAddPanel";
import FitmentGroupEditPanel from "./Fitments/FitmentGroupEditPanel";
export default {
  components: { FitmentGroupAddPanel, FitmentGroupEditPanel },
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
    };
  },
  created() {
    this.fetchFitments();
  },
  mounted() {},
  methods: {
    openEditPanel(group) {
      this.currentGroup = group;
      this.showPanel.edit = true;
    },
    closeEditPanel() {
      this.showPanel.edit = false;
      this.fetchFitments();
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
      this.fetchFitments()
    },
    fetchFitments() {
      axios
        .get("/api/fitments", {
          params: {
            paginate: this.table.paginate
          }
        })
        .then(res => {
          console.log(res);
          this.table.data = res.data.data;
        });
    },
    createGroup() {
      axios
        .post("/api/products/option-group/create", {
          display_name: this.displayName
        })
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