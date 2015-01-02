/* Wifi Hotspot app for YunoHost 
 * Copyright (C) 2015 Julien Vaubourg <julien@vaubourg.com>
 * Contribute at https://github.com/jvaubourg/hotspot_ynh
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

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

  $('#saveconfirm').click(function() {
    $(this).hide();
    $('#saveconfirmation').show();
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

  $('#wifiparty').click(function() {
    $('#wifiparty_screen').show('slow');
  });

  $('#wifiparty_zoomin_ssid').mousedown(function() {
    $('#wifiparty_ssid').css('fontSize', (parseInt($('#wifiparty_ssid').css('fontSize')) + 5) + "px");
  });

  $('#wifiparty_zoomout_ssid').mousedown(function() {
    $('#wifiparty_ssid').css('fontSize', (parseInt($('#wifiparty_ssid').css('fontSize')) - 5) + "px");
  });

  $('#wifiparty_zoomin_passphrase').mousedown(function() {
    $('#wifiparty_passphrase').css('fontSize', (parseInt($('#wifiparty_passphrase').css('fontSize')) + 7) + "px");
  });

  $('#wifiparty_zoomout_passphrase').mousedown(function() {
    $('#wifiparty_passphrase').css('fontSize', (parseInt($('#wifiparty_passphrase').css('fontSize')) - 7) + "px");
  });

  $('#wifiparty_close').click(function() {
    $('#wifiparty_screen').hide();
  });
});

$(document).keydown(function(e) {
  if(e.keyCode == 27) {
    $('#wifiparty_close').click();
  }
});
