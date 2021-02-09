<template>
    <l-map class="h-100 mx-auto" style="width: 80%;" :zoom="zoom" :center='center'>
        <l-tile-layer :url="url"></l-tile-layer>
    </l-map>
</template>

<script src='./js/map.js'></script>