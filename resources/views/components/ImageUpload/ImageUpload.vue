<template>

    <div v-el:dropzone class="ImageUpload {{ isclasses }} dropzone"></div>

</template>

<script>

    import Dropzone from 'dropzone';
    import Component from '../Component';

    export default Component.extend({

        ready: function() {

            Dropzone.autoDiscover = false;

            new Dropzone(this.$els.dropzone, {
                url: "/image/upload",
                paramName: 'image',
                maxFilesize: 10,
                uploadMultiple: false,
                acceptedFiles: 'image/*',
                maxFiles: 1,
                headers: {'X-CSRF-TOKEN' : document
                    .querySelector('#token')
                    .getAttribute('content')
                },
                success: function(file, res) {
                    this.$dispatch('imageUploaded')
                }.bind(this)
            
            }).on("complete", function(file) {
                this.removeFile(file);
            });

        }

    })

</script>