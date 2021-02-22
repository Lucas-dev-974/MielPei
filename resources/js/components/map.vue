<template>
<div class="" style="height: 88%;">
    <l-map class="h-100 mx-auto" style="width: 100%; "  :zoom="zoom" :center='center'>
        <l-tile-layer :url="url" ></l-tile-layer>
    </l-map>
</div>

</template>

<script src='./js/map.js'></script>