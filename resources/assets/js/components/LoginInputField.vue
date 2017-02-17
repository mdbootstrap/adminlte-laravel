<template>
    <div class="form-group has-feedback">
        <input v-model="credential" v-if="type === 'email'" type="email" class="form-control" :placeholder="placeholder" :name="name" @change="adddomain"/>
        <input v-model="credential" v-else type="text" class="form-control" :placeholder="placeholder" :name="name" @change="adddomain"/>
        <span class="glyphicon form-control-feedback" :class="[icon]"></span>
    </div>
</template>

<script>
    export default {
        data: function () {
          return {
            credential: ''
          }
        },
        props: {
          name: {
            type: String,
            required: true
          },
          domain: {
            type: String,
            required: false
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
        },
        methods: {
          adddomain: function () {
            if (this.type === 'email') return
            if (this.domain === '') return
            if (this.credential.endsWith(this.domain)) return
            if (this.credential.includes('@')) return
            this.credential = this.credential + '@' + this.domain
          }
        }
    }
</script>
