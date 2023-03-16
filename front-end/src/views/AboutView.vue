<template>
  <div class="about">
    {{ user}}
  </div>
 
  
</template>
<script>
    export default {
        data() {
          return {
            user:{},
          };
        },
        mounted(){
          const id = this.$route.params.id;
          fetch(`http://127.0.0.1:8000/api/show/${id}`)
          .then(response => response.json())
          .then(res => this.user = res.data);
        },
  };       
</script>
   
<style>
</style>
