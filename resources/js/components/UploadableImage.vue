<template>
    <div>
        <img src="https://images.pexels.com/photos/847402/pexels-photo-847402.jpeg?auto=compress"
             alt="User Banner" ref="userImage"
             class="object-cover w-full">
    </div>
</template>

<script>

    /*Read the DOCS- npm package*/
    import DropZone from 'dropzone';

    export default {
        name: "UploadableImage",

        props: [
            'imageWidth',
            'imageHeight',
            'location',
        ],

        data: () => {
            return {
                dropzone: null,
            }
        },

        mounted(){
            this.dropzone = new DropZone(this.$refs.userImage, this.settings);
        },

        computed: {
            settings() {
                return {
                    paramName: 'image',
                    url: '/api/user-images',
                    acceptedFiles: 'image/*',
                    params: {
                        'width': this.imageWidth,
                        'height': this.imageHeight,
                        'location': this.location,
                    },
                    headers: {
                        /* this from app.blade in csrf-token */
                        'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
                    },
                    success: (e, res) => {
                        alert('uploaded!');
                    }
                };
            }
        }

    }
</script>

<style scoped>

</style>
