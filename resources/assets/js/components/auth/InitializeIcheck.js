export default {
  methods: {
    initialitzeICheck (field) {
      var component = this
      $('input[name=' + field + ']').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
      }).on('ifChecked', function (event) {
        component.form.setField(field, true)
        component.form.errors.clear(field)
      }).on('ifUnchecked', function (event) {
        component.form.setField(field, '')
      })
    }
  }
}
