<template>
    <div>
        <p>тест yii2 + vue.js</p>
 
        <router-link to="/english/backend/web/wordrests/add">Добавить товар</router-link>
 
        <router-view></router-view>

    </div>
</template>
 
<script>
 
export default {
 
  data () {
    return {
    }  
  },
 
  mounted: function () {
    console.log('App component mounted');
  }
 
}
</script>
 
<style>
 
</style>