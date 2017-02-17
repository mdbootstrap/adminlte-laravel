<template>
    <div class="form-group has-feedback">
        <input :type="type" class="form-control" :placeholder="placeholder" :name="name"/>
        <span class="glyphicon form-control-feedback" :class="[icon]"></span>
    </div>
</template>

<script>
    export default {
        props: {
          name: {
            type: String,
            required: true
          }
        },
        computed: {
          placeholder: function () {
            if (this.name === 'email') return this.trans('adminlte_lang_message.email')
            return this.trans('adminlte_lang_message.username')
          },
          type: function () {
            if (this.name === 'email') return 'email'
            return 'text'
          },
          icon: function () {
            if (this.name === 'email') return 'glyphicon-envelope'
            return 'glyphicon-user'
          }
        }
    }
</script>
