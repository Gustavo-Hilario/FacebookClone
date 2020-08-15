<template>
    <div class="flex flex-col items-center">
        <div class="relative mb-8">
            <div class="w-100 h-64 overflow-hidden z-10">
                <img src="https://images.pexels.com/photos/847402/pexels-photo-847402.jpeg?auto=compress" alt="User Banner" class="object-cover w-full">
            </div>

            <div class="flex items-center absolute bottom-0 left-0 -mb-8 ml-12 z-20">
                <div class="w-32">
                    <img src="https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="Profile User" class="w-32 h-32 object-cover border-4 border-gray-200 shadow-lg rounded-full">
                </div>
                <p class="ml-4 text-2xl text-gray-100">{{ user.data.attributes.name }}</p>
            </div>
        </div>

        <p v-if="postLoading"> Loading Posts... </p>
        <Post v-else v-for="post in posts.data" :key="post.data.post_id" :post="post"></Post>

        <p v-if=" ! postLoading && posts-data-lenght < 1"> No posts found. Get Started ...</p>

    </div>
</template>

<script>

    import Post from '../../components/Post';

    export default {
        name: "Show",

        components: {
            Post
        },

        data: () => {
            return {
                user:null,
                posts:null,
                userLoading: true,
                postLoading: true,
            }
        },

        mounted() {
            /*We can use $route.params.userID because of vue-router */
            axios.get('/api/users/' + this.$route.params.userId)
                .then(res => {
                    this.user = res.data;
                    this.userLoading = false;
                })
                .catch(error => {
                    console.log("unable to fetch the user from the server");
                })
                .finally(() => {
                    this.userLoading = false;
                });

            axios.get('/api/users/' + this.$route.params.userId + '/posts')
                .then(res => {
                  this.posts = res.data;
                })
                .catch(error => {
                  console.log('Unable to fetch posts');
                })
                .finally(() => {
                    this.postLoading = false;
                });
        }

    }

</script>

<style scoped>

</style>
