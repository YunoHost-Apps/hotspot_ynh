$(document).ready(function() {
  $('.btn-group').button();
  $('[data-toggle="tooltip"]').tooltip();

  $('.fileinput').click(function() {
    var realinputid = '#' + $(this).attr('id').replace(/_chooser.*/, '');
    $(realinputid).click();
  });

  $('input[type="file"]').change(function() {
    var choosertxtid = '#' + $(this).attr('id') + '_choosertxt';

    $(choosertxtid).val($(this).val().replace(/^.*[\/\\]/, ''));
  });

  $('.dropdown-menu li').click(function() {
    var menu = $(this).parent();
    var items = menu.children();
    var button = menu.prev();
    var input = button.prev();

    items.removeClass('active');
    $(this).addClass('active');

    button.text($(this).text());
    button.append(' <span class="caret"></span>');

    input.attr('value', $(this).text());
  });

  $('.switch').bootstrapToggle();

  $('#save').click(function() {
    $(this).prop('disabled', true);
    $('#save-loading').show();
    $('#form').submit();
  });

  $('#status .close').click(function() {
    $(this).parent().hide();
  });

  $('#statusbtn').click(function() {
    if($('#status-loading').is(':hidden')) {
      $('#status').hide();
      $('#status-loading').show();

      $.ajax({
        url: '?/status',
      }).done(function(data) {
        $('#status-loading').hide();
        $('#status-text').html('<ul>' + data + '</ul>');
        $('#status').show('slow');
      });
    }
  });
});
