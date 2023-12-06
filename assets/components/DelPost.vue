<template>
    <div>
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Delete
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="#" @click="delPost">Delete post</a>
                </li>
            </ul>
        </div>
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div :id="'liveToast' + postId" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Bootstrap</strong>
                    <small>11 mins ago</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Post deleted
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
export default {
    name: "DelPost",
    props: ['postId', 'appPostDeleteUrl'],
    data() {
        return {
            // error: '',
        };
    },
    methods: {
        delPost: function (e) {
            e.preventDefault();
            var that = this;
            axios.post(that.appPostDeleteUrl, {
                postId: that.postId,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            })
                .then(function (response) {
                    if (true !== response.data.success) {
                        return;
                    }
                    const toastLive = document.getElementById('liveToast' + that.postId);
                    const toast = new bootstrap.Toast(toastLive);
                    toast.show();
                    toastLive.addEventListener('hide.bs.toast', () => {
                        document.getElementById("tr-" + that.postId).setAttribute("style", "opacity:0");
                    })
                })
                .catch(function (error) {
                    console.log(error);
                });
        }

    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>