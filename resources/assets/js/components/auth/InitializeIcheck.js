export default {
  mounted () {
    this.initialitzeICheck()
  },
  methods: {
    initialitzeICheck () {
      var component = this
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
      }).on('ifChecked', function (event) {
        component.form.set('terms', true)
        component.form.errors.clear('terms')
      }).on('ifUnchecked', function (event) {
        component.form.set('terms', '')
      })
    }
  }
}
