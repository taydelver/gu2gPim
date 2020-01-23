<template>
  <div class="custom-image-file">
    <input type="file"
           class="custom-image-file-input"
           lang="en"
           v-bind="$attrs"
           v-on="listeners"
           accept="image/*"
           :id="inputId"
    />
    <label v-if="files.length < 1 && !productUploader" class="custom-image-file-label" :for="inputId">
      <i class="fas fa-camera"></i>
    </label>
    <label v-if="files.length > 0 && !productUploader" class="custom-image-file-label" :for="inputId">
      <img v-if="thumbnail" :src="imageSrc" alt="" class="upload-thumbnail">
      <span @click="handleRemove" class="clear-file"><i class="ni ni-fat-remove"></i></span>
    </label>
    <label v-if="productUploader" class="product-uploader-label" :for="inputId">
      <div class="label-content">
        <i class="fas fa-camera"></i>
        <span class="ml-2">Drag and Drop images here to upload.</span>
      </div>
      
    </label>
    
  </div>
</template>
<script>
  export default {
    name: 'file-input',
    inheritAttrs: false,
    props: {
      initialLabel: {
        type: String,
        default: 'Select file'
      },
      inputId: {
        type: String
      },
      thumbnail: String,
      productUploader: Boolean
    },
    data() {
      return {
        files: []
      }
    },
    computed: {
      listeners() {
        return {
          ...this.$listeners,
          change: this.fileChange
        }
      },
      imageSrc() {
        return `/storage/${this.thumbnail}`
      },
      label() {
        let fileNames = [];
        for (let file of this.files) {
          fileNames.push(file.name)
        }
        return fileNames.length ? fileNames.join(', ') : this.initialLabel
      }
    },
    methods: {
      fileChange(evt) {
        this.files = evt.target.files
        this.$emit('change', this.files)
      },
      handleRemove() {
        this.$emit('remove')
      }
    }
  }
</script>
<style lang="scss">
.clear-file {
	font-size: 14px;
}
.upload-thumbnail {
	display: block;
	width: 100%;
	position: absolute;
	top: 50%;
	left: 0;
	transform: translateY(-50%);
}
.custom-image-file {
	position: relative;
	width: 50px;
	&.autowidth {
		width: auto;
		max-width: 100px;
		overflow: hidden;
	}
	&.product-uploader {
		width: 100%;
		height: 60px;
		input {
			height: 100%;
		}
	}
}
.custom-image-file-input {
	position: relative;
	z-index: 2;
	width: 100%;
	height: calc(1.5em + 1.25rem + 2px);
	margin: 0;
	opacity: 0;
}

.product-uploader-label {
	font-weight: 400;
	line-height: 1.5;
	position: absolute;
	z-index: 1;
	top: 0;
	right: 0;
	left: 0;
	height: 100%;
	padding: 0.625rem 1.5rem;
	color: #8898aa;
	border: 1px solid #dee2e6;
	border-radius: 0.25rem;
	background-color: #fff;
	.label-content {
		display: flex;
		align-items: center;
		height: 100%;
	}
}

.custom-image-file-label {
	font-weight: 400;
	line-height: 1.5;
	position: absolute;
	z-index: 1;
	top: 0;
	right: 0;
	left: 0;
	height: calc(1.5em + 1.25rem + 2px);
	padding: 0.625rem 0.75rem;
	color: #8898aa;
	border: 1px solid #dee2e6;
	border-radius: 0.25rem;
	background-color: #fff;
	text-align: center;
	&.filename {
	}
}
</style>