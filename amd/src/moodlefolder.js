define(['core/ajax', 'jquery'], function(ajax, $) {
  var module = {
    init: function() {
      $('#moodlefolder_button').off('click');
      $('.block_moodlefolder_subscribe').on('click', module.subscribe);
      $('.block_moodlefolder_unsubscribe').on('click', module.unsubscribe);
    },
    subscribe: function() {
      console.log('called subscribe');
      var promises = ajax.call([
        {
          methodname: 'block_moodlefolder_subscribe',
          args: {courseid: module.getCourseId()
          }
        }
      ]);

      var button = Y.one('#moodlefolder_button');
      var spinner = M.util.add_spinner(Y, button);
      spinner.show();
      promises[0].done(function(response) {
        module.switchSubscribeUnsubscribe();
        spinner.hide();
      }).fail(function(ex) {
        console.error(ex);
      });
    },
    unsubscribe: function() {
      var promises = ajax.call([
        {
          methodname: 'block_moodlefolder_unsubscribe',
          args: {courseid: module.getCourseId()
          }
        }
      ]);

      var button = Y.one('#moodlefolder_button');
      var spinner = M.util.add_spinner(Y, button);
      spinner.show();
      promises[0].done(function(response) {
        module.switchSubscribeUnsubscribe();
        spinner.hide();
      }).fail(function(ex) {
        console.error(ex);
      });
    },
    switchSubscribeUnsubscribe: function() {
      var action;
      var selector;
      if (!!document.querySelector('.block_moodlefolder_subscribe')) {
        action = 'unsubscribe';
      } else {
        action = 'subscribe';
      }
      console.log('Action: ', action);
      var button = $('#moodlefolder_button');
      button.html(action[0].toUpperCase() + action.slice(1));
      button.removeClass();
      button.off('click');
      button.addClass('block_moodlefolder_' + action);
      button.on('click', module[action]);
    },
    getCourseId: function() {
      var classes = document.querySelector('body').classList;
      var courseid;
      for (var i = 0; i < classes.length; ++i) {
        var m = /course-(\d*)/g.exec(classes[i]);
        if (!!m && !!m[1]) {
          return parseInt(m[1]);
        }
      }
    }
  };
  return module;
})
