<template>
    <div>
        <img :src="userImage.data.attributes.path"
             :alt="alt"
             ref="userImage"
             :class="classes">
    </div>
</template>

<script>

    /*Read the DOCS- npm package*/
    import DropZone from 'dropzone';
    import { mapGetters } from 'vuex';

    export default {
        name: "UploadableImage",

        props: [
            'userImage',
            'imageWidth',
            'imageHeight',
            'location',
            'classes',
            'alt',
        ],

        data: () => {
            return {
                dropzone: null,
            }
        },

        mounted(){
            if(this.authUser.data.user_id.toString() === this.$route.params.userId){
                this.dropzone = new DropZone(this.$refs.userImage, this.settings);
            }
        },

        computed: {
            ...mapGetters ({
                authUser: 'authUser',
            }),

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
                        /*To refresh the profile image in other components*/
                        this.$store.dispatch('fetchAuthUser');
                        this.$store.dispatch('fetchUser', this.$route.params.userId);
                        this.$store.dispatch('fetchUserPosts', this.$route.params.userId);
                    }
                };
            },
        }

    }
</script>

<style scoped>

</style>
