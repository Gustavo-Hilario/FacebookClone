<template>
    <div>
        <div class="w-100 h-64 overflow-hidden">
            <img src="https://images.pexels.com/photos/847402/pexels-photo-847402.jpeg?auto=compress" alt="User Banner" class="object-cover w-full">
        </div>
    </div>
</template>

<script>

    export default {
        name: "Show",

        data: () => {
            return {
                user:null,
                loading: true,
            }
        },

        mounted() {
            /*We can use $route.params.userID because of vue-router */
            axios.get('/api/users/' + this.$route.params.userId)
                .then(res => {
                    this.user = res.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log("unable to fetch the user from the server");
                })
                .finally(() => {
                    this.loading = false;
                });

            axios.get('/api/posts' + this.$route.params.userId)
                .then(res => {
                  this.posts = res.data;
                  this.loading = false;
                })
                .catch(error => {
                  console.log('Unable to fetch posts');
                  this.loading = false;
                });
        }

    }

</script>

<style scoped>

</style>
