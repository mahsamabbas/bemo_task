<template>
    <CardModal name="CardModal" :height="380">
        <div class="card-modal-wrapper">
            <label for="story">Title</label>
            <input name="story">

            <label for="story">Description</label>
            <textarea id="story" name="story" rows="5" cols="33">{{ currentCard.title }}</textarea>
            <hr>
            <button>Update</button>
        </div>
    </CardModal>
</template>
<script>
    export default {
        props: ['currentCard'],
        name: 'CardModalView',
        mounted () {
            this.$modal.show('example')
        }
    }
</script>
