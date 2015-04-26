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

function wifiSecureBtn() {
  if($(this).parent().hasClass('off')) {
    $(this).closest('.form-group').next().hide('slow');
  } else {
    $(this).closest('.form-group').next().show('slow');
  }
}

function tabsClick() {
  var ssid = $(this).closest('.ssid');
  var tab = $(this).parent().attr('data-tab');

  ssid.find('li.active').removeClass('active');
  $(this).parent().addClass('active');

  ssid.find('.tabs').hide();
  ssid.find('.tab' + tab).show();

  return false;
}

function dropDownClick() {
  var menu = $(this).parent();
  var items = menu.children();
  var button = menu.prev();
  var input = button.prev();

  items.removeClass('active');
  $(this).addClass('active');

  button.text($(this).text());
  button.append(' <span class="caret"></span>');

  input.val($(this).text());
}

$(document).ready(function() {
  $('.btn-group').button();
  $('[data-toggle="tooltip"]').tooltip();

  $('.dropdown-menu li').click(dropDownClick);

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

  $('.wifiparty').click(function() {
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

  $('.wifi_secure').change(wifiSecureBtn);

  $('#service_enabled').change(function() {
    if($('#service_enabled').parent().hasClass('off')) {
      $('.enabled').hide('slow');
    } else {
      $('.enabled').show('slow');
    }
  });

  $('.nav-tabs a').click(tabsClick);

  $('#newssid').click(function() {
    var clone = $('#ssids').children().first().clone();
    var id = parseInt($('.ssid').length);

    clone.find('.dropdownmenu').each(function(i) {
      var initial = $('#ssids').children().first().find('.dropdownmenu');
      var clone = initial.eq(i).clone(true, true);

      $(this).after(clone);
      $(this).remove();
    });

    clone.find('[name]').each(function() {
      $(this).attr('name', $(this).attr('name').replace('[0]', '[' + id + ']'));
    });

    clone.find('[data-toggle="tooltip"]').tooltip();

    clone.find('input[type=text]').each(function() {
      if($(this).attr('name').match('dns')) {
        $(this).val($(this).attr('placeholder'));

      } else {
        $(this).val('');
      }
    });

    clone.find('input[type=checkbox]').each(function() {
      $(this).parent().after($(this));
      $(this).prev().remove();
      $(this).attr('checked', false);
    });

    clone.find('.switch').bootstrapToggle();
    clone.find('.wifi_secure').change(wifiSecureBtn);
    clone.find('.nav-tabs a').click(tabsClick);
    clone.find('.dropdown-menu li').click(dropDownClick);
    clone.find('.wifi_passphrase').hide();

    clone.find('h3').each(function() {
      $(this).text($(this).data('label') + ' ' + (id + 1));
    });

    $('#ssids').append(clone);
  });
});

$(document).keydown(function(e) {
  if(e.keyCode == 27) {
    $('#wifiparty_close').click();
  }
});
