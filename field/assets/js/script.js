(function($) {
  $.fn.clonr = function() {
    return this.each(function() {
      var fieldname = 'clonr';
          field = $(this);
          btn = $('.btn-clonr');
          container = $('.message-clonr');
          input = $('.input-clonr');


      btn.on('click', function() {
        container.hide().removeClass("success error");
        input.val('').toggleClass('active');
      });

      input.keypress(function(e) {
        console.log('click');
        if (e.which == 13) {
          if($(this).val() == "") {
            container.show().html('The field cannot be empty. Please enter a page title.').addClass('error').append('<i class="icon fa fa-close"></i>')
            return false;
          }
          $.fn.ajaxClonr(fieldname);
          return false;
        }
      });

      container.on('click', '.fa-close', function(e){
        $(this).parent().hide().removeClass("success error");
      });

    });

  };

  // Ajax function
  $.fn.ajaxClonr = function(fieldname) {
    var newID = $('[data-field="' + fieldname + '"]').find('.input-clonr').val();
    var newID = newID.replace(/[\/\\\)\($%^&*<>"'`´:;.\?=]/g, " ");
    var blueprintKey = $('[data-field="' + fieldname + '"]').find('button').data('fieldname');
    var base_url = window.location.href.replace(/(\/edit.*)/g, '/field') + '/' + blueprintKey + '/' + fieldname + '/api/clonr/';

    $.ajax({
      url: base_url + encodeURIComponent(newID),
      type: 'GET',
      success: function(response) {
        var r = JSON.parse(response);
        if(r.class == 'error') {
          container.show().html(r.message).addClass(r.class).append('<i class="icon fa fa-close"></i>');
          input.removeClass('active');
        }

        if(r.class == 'success' && r.uri) {
          container.show().html(r.message).addClass(r.class);
          new_url = window.location.href.replace(/(pages\/.*\/edit.*)/g, 'pages/' + r.uri + '/edit');
          container.append('You will be redirected to the new page ...')
          setTimeout(function () {
              window.location.replace(new_url);
          }, 1000);

        }
      }
    });
  };

})(jQuery);
