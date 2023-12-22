<script setup>
import { inject } from 'vue';


const Color = inject('color')
</script>

<template>
    <div class="card p-3 rounded-lg duration-500" :class="{
        'bg-blue-600' : Color == 'red',
        'bg-blue-800' : Color == 'blue',
        'bg-blue-900' : Color == 'green',
    }">
      <div class="card-header">
        <slot name="head">Header</slot>
      </div>
      <div class="card-body">
        <slot name="content">Body</slot>
      </div>
      <div class="card-footer">
        <slot name="footer">Footer</slot>
      </div>
    </div>
  </template>

  <script>
  export default {
    name: 'Card',
  };
  </script>
