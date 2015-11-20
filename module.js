require(['core/ajax', 'YUI'], function(ajax, Y) {
  var promises = ajax.call([
    { methodname: block_moodlefolder_subscribe }
  ]);

  promises[0].done(function(response) {
    console.log(response);
  }).fail(function(ex) {
    console.error(ex);
  });
  var test = Y.extend('test', Y.Base, {
    init: function() {
      console.log('courseid is: ', this.get('courseid'));
    }
  })
})
