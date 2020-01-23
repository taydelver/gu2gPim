<template>
  <card title="Images and Videos">
    <div class="upload-images">
      <h3>Images</h3>
      <div>
        <div class="row-header">
          <div class="media-header--handle"></div>
          <div class="media-header--check"></div>
          <div class="media-header--image">Image</div>
          <div class="media-header--alt_text">Description</div>
          <div class="media-header--thumb">Thumbnail</div>
          <div class="media-header--remove"></div>
        </div>
        <draggable v-model="uploads" ghost-class="ghost">
          <transition-group type="transition" name="flip-list">
            <draggable-item
              @remove="removeItem(key)"
              v-for="(item, key) in uploads"
              :key="key"
              :can-delete="canDelete"
            >
            <div class="media-header--check">
              <span class="checkbox-wrapper mb-0 text-sm">
                <input :id="inputId('tableCheckbox', key)" :ref="inputId('tableCheckbox', key)" class="table-checkbox" type="checkbox">
                <label class="table-checkbox__label" :for="inputId('tableCheckbox', key)"></label>
              </span>
            </div>
            <div class="media-header--image">
              <div class="thumb-wrapper">
                <img :src="item.image" alt="">
              </div>
            </div>
            <div class="media-header--alt_text">
              <textarea v-model="uploads[key].alt_text" class="form-control" rows="2"></textarea>
            </div>
            <div class="media-header--thumb">
              <input :id="inputId('tableRadio', key)" :ref="inputId('tableRadio', key)" class="table-checkbox" type="radio" :value="key" v-model="featuredThumb">
              <label :class="{checked: featuredThumb == key}" class="table-radio__label" :for="inputId('tableRadio', key)"></label>
            </div>
            </draggable-item>

          </transition-group>
        </draggable>
      </div>
      <image-input product-uploader class="product-uploader" @remove="handleRemove(inputId('productImageUpload', 1))" :ref="inputId('productImageUpload', 1)" :input-id="inputId('productImageUpload', 1)" @change="filesChange($event, 1)"></image-input>
      <!-- <vue-dropzone @vdropzone-success="uploadSuccess" ref="productNewImages" id="mediaUploader" :include-styling="false" :options="dropzoneOptions"></vue-dropzone> -->
      {{uploads}}
    </div>
  </card>
</template>

<script>
import VueDropzone from 'vue2-dropzone'
export default {
  components: {VueDropzone},
  data() {
    return {
      dropzoneOptions: {
        url: 'https://httpbin.org/post',
        // url: '/api/products/images/save',
        thumbnailWidth: 150,
        maxFilesize: 0.5,
        addRemoveLinks: true,
      },
      files: [],
      uploads: [],
      featuredThumb: null,
      imageForm: new FormData,
      thumbnails: []
      
    }
  },
  watch: {
    uploads: {
      handler: function(val, oldVal) {
        this.$store.dispatch('newProductImages', val)
      },
      deep: true
    }
  },
  methods: {
   uploadSuccess(file, response) {
     console.log(response)
   },
   filesChange(files, index) {
      this.imageForm.append('image', files[0])
      const config = { headers: { 'Content-Type': 'multipart/form-data' } };
      axios.post('/api/products/images/save', this.imageForm, config)
      .then(res => {
        const newRow = {
          image: `/storage/${res.data.path}`,
          alt_text: '',
          is_thumbnail: false
        }
        
        this.uploads.push(newRow)
        // this.thumbnails.splice(index, 1, res.data)
        console.log(this.uploads)
      })
      .catch(err => console.log(err))
    },
    inputId(prefix, key) {
      return `${prefix}${key}`
    },
    handleRemove(input) {
      console.log(this.$refs[input])
      console.log(input)
    },
    removeItem(key) {
      this.$delete(this.uploads, key)
    }
  },
  computed: {
    canDelete() {
      return this.uploads.length > 1
    },
  }
}
</script>

<style lang="scss">
#mediaUploader {
	background-color: #f7f7f7;
	font-family: "Arial", sans-serif;
	letter-spacing: 0.2px;
	color: #777;
	transition: background-color 0.2s linear;
	height: 200px;
	padding: 40px;
}
.row-header {
	display: flex;
	font-weight: 700;
	font-size: 0.82rem;
	margin-bottom: 1rem;
}
.media-header {
	&--check {
		flex: 0 0 4rem;
		padding: 0 0.53333rem;
		text-align: center;
	}
	&--alt_text {
		width: 100%;
		padding: 0 0.53333rem;
		text-align: left;
	}
	&--thumb {
		flex: 0 0 4rem;
		padding: 0 0.53333rem;
		text-align: center;
	}
	&--handle {
		flex: 0 0 30px;
		text-align: center;
	}
	&--image {
		flex: 0 0 4rem;
		padding: 0 0.53333rem;
		text-align: center;
		.thumb-wrapper {
			border: 1px solid #dee2e6;
			padding: 1px;
			img {
				display: block;
				width: 100%;
			}
		}
	}
}
</style>