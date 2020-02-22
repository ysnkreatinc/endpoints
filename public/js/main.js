"use strict";

function _typeof(obj) { if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

// initialize place holder
$('input, textarea').placeholder(); // Center Modal

function centerModal() {
  $(this).css('display', 'block');
  var $dialog = $(this).find(".modal-dialog"),
      offset = ($(window).height() - $dialog.height()) / 2,
      bottomMargin = parseInt($dialog.css('marginBottom'), 10); // Make sure you don't hide the top part of the modal w/ a negative margin if it's longer than the screen height, and keep the margin equal to the bottom margin of the modal

  if (offset < bottomMargin) offset = bottomMargin;
  $dialog.css("margin-top", offset);
}

(function ($) {
  $(document).on('show.bs.modal', '.modal', centerModal);
  $(window).on("resize", function () {
    $('.modal:visible').each(centerModal);
  });
})(jQuery); // initialize tooltip


$('body').tooltip({
  selector: '[data-toggle="tooltip"]'
});
$(function () {
  $('[data-hover="tooltip"]').tooltip({
    container: 'body',
    trigger: 'hover'
  });
  /*
  // add this if there's multiple data-toggle
  $('[data-hover="tooltip"]').tooltip({
    container: 'body',
    trigger: 'hover'
  }); 
  */
}); // Lity.js =======================================================

$('[data-lity]').on('click', function () {
  var lityButton = '<button class="lity-mini" id="lityMini" title="Maximize the video"><i class="fa fa-expand" aria-hidden="true"></i></button><button class="lity-external" id="lityExternal" title="Open the video in a new window"><i class="fa fa-external-link" aria-hidden="true"></i></button>';

  if ($('.lity-opened')) {
    $('.lity-opened').remove();
  }

  setTimeout(function () {
    $('.lity-opened .lity-container').append(lityButton);
  }, 100);
});
$(document).on('click', '#lityExternal', function () {
  var lityLink = $('.lity-iframe-container iframe').attr('src');
  window.open(lityLink, 'Listings-To-Leads', 'width=600,height=338');
  $('[data-lity-close]').trigger('click');
});
$(document).on('click', '#lityMini', function () {
  var t = $(this);

  if ($('.lity-controls').hasClass('lity-minimized')) {
    $('.lity-controls').removeClass('lity-minimized');
    t.attr('title', 'Minimize the video').find('.fa-expand').addClass('fa-compress').removeClass('fa-expand');
  } else {
    setTimeout(function () {
      $('.lity-opened').addClass('lity-minimized');
      t.attr('title', 'Maximize the video').find('.fa-compress').addClass('fa-expand').removeClass('fa-compress');
    }, 100);
  }
}); // /Lity.js ==============================================================
// Noty.js default options

Noty.overrideDefaults({
  theme: 'default',
  layout: "bottomLeft",
  timeout: 6000
}); // initialize date
// Add [data-type="date-picker"]

$('[data-type="date-picker"]').datetimepicker({
  format: "MM/DD/YYYY"
}); // Preserve the width of table cells when using sortable
// Add  this function to sortable

var PreserveCellWidth = function PreserveCellWidth(e, ui) {
  ui.children().each(function () {
    $(this).width($(this).width());
  });
  return ui;
}; // initialize custom select used in themes


$('[data-type="select-custom"]').chosen({}); // Initialize dropzone for MLS photos & Add listing

Dropzone.autoDiscover = false;
$('[data-type="dropzone-photos"]').dropzone({
  url: "/uploads",
  acceptedFiles: "image/*",
  thumbnailWidth: 190,
  thumbnailHeight: 190,
  dictDefaultMessage: '<i class="fa fa-picture-o" aria-hidden="true"></i> Drop here or click to upload',
  previewTemplate: '<div class="dz-preview dz-file-preview ui-state-default"><div class="dz-image"><img data-dz-thumbnail /></div><div class="dz-details"><div class="dz-filename"><span data-dz-name></span></div><div class="dz-size" data-dz-size></div></div><div class="dz-description"><div class="dz-head"><div class="unb checkbox pull-left"><label><input type="checkbox" checked> Unbranded</label></div><a class="btn btn-xs btn-danger pull-right" data-hover="tooltip" data-placement="bottom" title="Delete" data-dz-remove>&times;</a></div><input type="text" class="form-control" placeholder="Title"><textarea class="form-control" placeholder="Subtitle"></textarea><div class="radio llp"><label><input type="radio" name="llp" checked> Listing Landing Page</label></div></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-success-mark"><span>✔</span></div><div class="dz-error-mark"><span>✘</span></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div>',
  init: function init() {
    this.on("addedfile", function (file) {
      $('[data-hover="tooltip"]').tooltip();
    });
  }
}); // Initialize dropzone for VT photos & Add listing

$('[data-type="dropzone-vt"]').dropzone({
  url: "/uploads",
  acceptedFiles: "image/*",
  thumbnailWidth: 190,
  thumbnailHeight: 190,
  dictDefaultMessage: '<i class="fa fa-picture-o" aria-hidden="true"></i><br>Drop here or click to upload',
  previewTemplate: '<div class="dz-preview dz-file-preview ui-state-default"><div class="dz-image"><img data-dz-thumbnail /></div><div class="dz-details"></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-success-mark"><span>✔</span></div><div class="dz-error-mark"><span>✘</span></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div>',
  init: function init() {
    this.on("addedfile", function (file) {
      $('[data-hover="tooltip"]').tooltip();
    });
  }
}); // Initialize dropzone for banner

$('[data-type="dropzone-banner"]').dropzone({
  url: "/uploads",
  acceptedFiles: "image/*",
  uploadMultiple: false,
  thumbnailWidth: 777,
  maxFiles: 1,
  thumbnailHeight: 130,
  dictRemoveFile: true,
  dictDefaultMessage: '<i class="fa fa-picture-o" aria-hidden="true"></i> Drop here or Click to upload',
  previewTemplate: '<div class="dz-preview dz-file-preview"><img data-dz-thumbnail class="img-responsive" data-hover="tooltip" data-placement="top" title="Drop Custom Banner here or click to upload"/><div class="dz-details"><div class="dz-filename"><span data-dz-name></span></div><div class="dz-size" data-dz-size></div></div><div class="dz-head"><a class="btn btn-xs btn-danger pull-right" data-hover="tooltip" data-placement="bottom" title="Delete" data-dz-remove>&times;</a></div><div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div><div class="dz-success-mark"><span>✔</span></div><div class="dz-error-mark"><span>✘</span></div><div class="dz-error-message"><span data-dz-errormessage></span></div></div>',
  accept: function accept(file, done) {
    console.log("uploaded");
    done();
  },
  init: function init() {
    // if a file added remove the older one
    this.on("addedfile", function () {
      if (this.files[1] !== null && this.files[0] !== null) {
        this.removeFile(this.files[0]);
      }
    });
  }
}); // initialize sortable

$('[data-type="dropzone-photos"]').sortable(); // mls photos

$('[data-type="dropzone-vt"]').sortable(); // virtual tour photos

$('[data-type="photos-sort"]').sortable(); // sort photos
// Remove/Delete Image from dropzone

$(document).on('click', '[data-type="dz-photo-del"]', function () {
  $('body').addClass('noty-backdrop');
  var t = $(this);
  var n = new Noty({
    text: 'Permanently delete this image?',
    layout: 'center',
    type: 'alert',
    closeWith: 'button',
    timeout: false,
    buttons: [Noty.button('Delete', 'btn btn-danger btn-sm', function () {
      t.closest('.dropzone').addClass('dz-delete');
      t.closest('.dz-preview').remove();

      if (!$('.dz-delete').find('.dz-preview').length) {
        $('.dz-started').removeClass('dz-started');
      }

      t.closest('.dropzone').removeClass('dz-delete');
      $('.tooltip').hide();
      new Noty({
        text: 'Image was deleted successfully.',
        type: 'success'
      }).show();
      n.close();
    }, {
      id: 'button1',
      'data-status': 'ok'
    }), Noty.button('Cancel', 'btn btn-success btn-sm', function () {
      n.close();
    })]
  }).on('onClose', function () {
    setTimeout(function () {
      $('body').removeClass('noty-backdrop');
    }, 300);
  }).show();
}); /// data-type="switch"

$('[data-type="switch"]').bootstrapSwitch();
$('[data-type="share"]').click(function () {
  var window_size = "width=585,height=511";
  var url = this.href;
  var domain = url.split("/")[2];

  switch (domain) {
    case "www.facebook.com":
      window_size = "width=585,height=368";
      break;

    case "www.twitter.com":
      window_size = "width=585,height=261";
      break;

    case "plus.google.com":
      window_size = "width=517,height=511";
      break;

    case "linkedin.com":
      window_size = "width=550,height=527";
      break;

    case "pinterest.com":
      window_size = "width=750,height=555";
      break;
  }

  window.open(url, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,' + window_size);
  return false;
}); // Image Preview Tooltip

$('[data-toggle="tooltip-img"]').tooltip({
  container: 'body',
  animated: 'fade',
  placement: 'bottom',
  html: true,
  trigger: 'click',
  template: '<div class="tooltip tooltip-img"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
});
$('[data-toggle="tooltip-img-hover"]').tooltip({
  container: 'body',
  animated: 'fade',
  placement: 'bottom',
  html: true,
  trigger: 'hover',
  template: '<div class="tooltip tooltip-img"><div class="tooltip-arrow"></div><div class="tooltip-inner"></div></div>'
}); // Image Preview Tooltip Fallback

$('[data-toggle="tooltip-img"]').on('show.bs.tooltip', function () {
  $('[data-toggle="tooltip-img"][aria-describedby]').not(this).trigger('click');
  $('body').addClass('data-toggle-img-active');
});
$('[data-toggle="tooltip-img"]').on('hidden.bs.tooltip', function () {
  if (!$(".tooltip-img")[0]) {
    $('body').removeClass('data-toggle-img-active');
  }
});
$(document).on("click", ".data-toggle-img-active", function () {
  $('[data-toggle="tooltip-img"][aria-describedby]').trigger('click');
});
$('[data-toggle="tooltip-img"]').click(function (e) {
  e.stopPropagation();
}); // Rotate Image

$(document).on('click', '[data-name="rotate-left"]', function () {
  var thisPic = $(this).closest('.dz-image');

  if (thisPic.find("img")[0]) {
    thisPic.find('img').rotate(-90);
  } else {
    thisPic.find('canvas').rotate(-90);
  }
});
$(document).on('click', '[data-name="rotate-right"]', function () {
  var thisPic = $(this).closest('.dz-image');

  if (thisPic.find("img")[0]) {
    thisPic.find("img").rotate(90);
  } else {
    thisPic.find('canvas').rotate(90);
  }
}); // Character count limit

function charLimit(input, output, textMax) {
  $(output).html('0 / ' + textMax);
  var textLength = $(input).val().length;
  $(output).html(textLength + ' / ' + textMax);

  if (textLength >= textMax - 5) {
    $(output).addClass("text-danger");
  } else {
    $(output).removeClass("text-danger");
  }
} // Preview Text


function previewText(input, title) {
  var textValue = $(input).val();
  $(title).html(textValue);
} // this to stop the dropdown from closing if we click inside it


$(document).on('click', '.dropdown', function (e) {
  e.stopPropagation();
}); // This script controls the affix position of the nav-pills

function affixFunc(el, top) {
  if ($(window).width() > 767) {
    var elClass = el.hasClass('nav'),
        elementOffset = top.offset().top;
    el.affix({
      offset: {
        top: function top() {
          return this.top = elementOffset - 73;
        },
        bottom: function bottom() {
          var bottomHeight;

          if (elClass) {
            bottomHeight = $('footer').outerHeight(true) + 48;
          } else {
            bottomHeight = $('footer').outerHeight(true) + 134;
          }

          return this.bottom = bottomHeight;
        }
      }
    });
  }
} // This controls the position of fix-pos icons after the modal-alt is shown


$(window).on('shown.bs.modal', function () {
  if ($('.modal.in').hasClass('modal-alt')) {
    var fixPosAlt = $('.modal-alt.in').find('.modal-dialog').outerWidth(true) + 20;
    $('.fix-top-right').css('right', fixPosAlt);
  }
});
$(window).on('hide.bs.modal', function () {
  $('.fix-top-right').css('right', '');
}); // This controls the backdrop (shadow) of the modal when there is a modal and another one opens

$(document).on('show.bs.modal', '.modal', function (event) {
  var zIndex = 1040 + 10 * $('.modal:visible').length;
  $(this).css('z-index', zIndex);
  setTimeout(function () {
    $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
  }, 0);
}); // initializing popover

$(function () {
  $('[data-toggle="popover"]').popover();
}); // REmove comma from tagsinput

$(document).on('keyup', '.bootstrap-tagsinput input', function () {
  if ($(this).val() === ',') {
    $(this).val('');
  }
}); // Themes start =================================================================================================
// convert rgb to hex color

function rgb2hex(orig) {
  var rgb = orig.replace(/\s/g, '').match(/^rgba?\((\d+),(\d+),(\d+)/i);
  return rgb && rgb.length === 4 ? "#" + ("0" + parseInt(rgb[1], 10).toString(16)).slice(-2) + ("0" + parseInt(rgb[2], 10).toString(16)).slice(-2) + ("0" + parseInt(rgb[3], 10).toString(16)).slice(-2) : orig;
} // Darken or lighten a hex color


function LightenDarkenColor(col, amt) {
  var usePound = false;

  if (col[0] == "#") {
    col = col.slice(1);
    usePound = true;
  }

  var R = parseInt(col.substring(0, 2), 16);
  var G = parseInt(col.substring(2, 4), 16);
  var B = parseInt(col.substring(4, 6), 16); // to make the colour less bright than the input
  // change the following three "+" symbols to "-"

  R += amt;
  G += amt;
  B += amt;
  if (R > 255) R = 255;else if (R < 0) R = 0;
  if (G > 255) G = 255;else if (G < 0) G = 0;
  if (B > 255) B = 255;else if (B < 0) B = 0;
  var RR = R.toString(16).length == 1 ? "0" + R.toString(16) : R.toString(16);
  var GG = G.toString(16).length == 1 ? "0" + G.toString(16) : G.toString(16);
  var BB = B.toString(16).length == 1 ? "0" + B.toString(16) : B.toString(16);
  return (usePound ? "#" : "") + RR + GG + BB;
} // Return black or white color depending on a hex color


function invertColor(hex, bw) {
  if (hex.indexOf('#') === 0) {
    hex = hex.slice(1);
  } // convert 3-digit hex to 6-digits.


  if (hex.length === 3) {
    hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
  }

  if (hex.length !== 6) {
    throw new Error('Invalid HEX color.');
  }

  var r = parseInt(hex.slice(0, 2), 16),
      g = parseInt(hex.slice(2, 4), 16),
      b = parseInt(hex.slice(4, 6), 16);

  if (bw) {
    return r * 0.299 + g * 0.587 + b * 0.114 > 160 ? '#000000' : '#FFFFFF';
  } // invert color components


  r = (255 - r).toString(16);
  g = (255 - g).toString(16);
  b = (255 - b).toString(16); // pad each with zeros and return

  return "#" + padZero(r) + padZero(g) + padZero(b);
} // Calculations for the first color


function themeColorBg(el, bool) {
  var bodyBg;
  var cardBg;
  var tableStriped;
  var tableHover;

  if (bool) {
    bodyBg = el.toRgbString();
  } else {
    bodyBg = el;
  }

  if (bodyBg) {
    var convertRgbToHex = rgb2hex(bodyBg);
    var invertTheColor = invertColor(convertRgbToHex, true);
    cardBg = LightenDarkenColor(convertRgbToHex, 10);

    if (invertTheColor.toString() === '#000000') {
      tableStriped = LightenDarkenColor(convertRgbToHex, -10);
      tableHover = LightenDarkenColor(convertRgbToHex, -20);
      $('[data-theme="themePreview"] .theme-preview-heading').css('color', '#212529');
      $('[data-theme="themePreview"]').css('color', '#484848');
      $('[data-theme="themePreview"] .theme-preview-link').css('color', '#212529');
      $('[data-theme="body-color"]').val('#484848');
      $('[data-theme="headings-color"]').val('#212529');

      if ($('[data-logo-default]').length > 0) {
        if ($('[data-theme="themePreview-logo"]').attr('data-logo-default').length > 0) $('[data-theme="themePreview-logo"]').attr('src', $('[data-theme="themePreview-logo"]').attr('data-logo-default'));
      }
    } else {
      tableStriped = LightenDarkenColor(convertRgbToHex, 10);
      tableHover = LightenDarkenColor(convertRgbToHex, 20);
      $('[data-theme="themePreview"] .theme-preview-heading').css('color', '#fff');
      $('[data-theme="themePreview"]').css('color', '#f5f5f5');
      $('[data-theme="themePreview"] .theme-preview-link').css('color', '#fff');
      $('[data-theme="body-color"]').val('#f5f5f5');
      $('[data-theme="headings-color"]').val('#fff');

      if ($('[data-logo-darker]').length > 0) {
        if ($('[data-theme="themePreview-logo"]').attr('data-logo-darker').length > 0) $('[data-theme="themePreview-logo"]').attr('src', $('[data-theme="themePreview-logo"]').attr('data-logo-darker'));
      }
    }

    $('[data-theme="themePreview"]').css('background-color', bodyBg);
    $('[data-theme="themePreviewCard"]').css('background-color', cardBg);
    $('[data-theme="body-bg"]').val(bodyBg);
    $('[data-theme="card-bg"]').val(cardBg);
    $('[data-theme="table-striped"]').val(tableStriped);
    $('[data-theme="table-hover"]').val(tableHover);
  }
} // Calculations for the second color


function themeColorNav1(el, bool) {
  var themePreviewNav1;

  if (bool) {
    themePreviewNav1 = el.toRgbString();
  } else {
    themePreviewNav1 = el;
  }

  if (themePreviewNav1) {
    var themePreviewNav2 = $('[data-theme="themeColorNav2"]').siblings('.sp-replacer').find('.sp-preview-inner').css('background-color');
    var navbarGradientBg = 'linear-gradient(to right, ' + themePreviewNav1 + ', ' + themePreviewNav2 + ')';
    var convertRgbToHex = rgb2hex(themePreviewNav1);
    var invertTheColor = invertColor(convertRgbToHex, true);
    $('[data-theme="themePreviewNav"] span').css('color', invertTheColor);
    $('[data-theme="navbar-link-color"]').val(invertTheColor);

    if (invertTheColor.toString() === '#000000') {
      $('[data-theme="navbar-link-hover-color"]').val('#555555');
    } else {
      $('[data-theme="navbar-link-hover-color"]').val('#eeeeee');
    }

    if (themePreviewNav1 === themePreviewNav2) {
      $('[data-theme="themePreviewNav"]').css('background', themePreviewNav1);
      $('[data-theme="navbar-bg"]').val(themePreviewNav1);
    } else {
      $('[data-theme="themePreviewNav"]').css('background', navbarGradientBg);
      $('[data-theme="navbar-bg"]').val(navbarGradientBg);
    }
  }
} // Calculations for the third color


function themeColorNav2(el, bool) {
  var themePreviewNav2;

  if (bool) {
    themePreviewNav2 = el.toRgbString();
  } else {
    themePreviewNav2 = el;
  }

  if (themePreviewNav2) {
    var themePreviewNav1 = $('[data-theme="themeColorNav1"]').siblings('.sp-replacer').find('.sp-preview-inner').css('background-color');
    var navbarGradientBg = 'linear-gradient(to right, ' + themePreviewNav1 + ', ' + themePreviewNav2 + ')';

    if (themePreviewNav1 === themePreviewNav2) {
      $('[data-theme="themePreviewNav"]').css('background', themePreviewNav2);
      $('[data-theme="navbar-bg"]').val(themePreviewNav2);
    } else {
      $('[data-theme="themePreviewNav"]').css('background', navbarGradientBg);
      $('[data-theme="navbar-bg"]').val(navbarGradientBg);
    }
  }
} // Calculations for the fourth color


function themeColorBtn(el, bool) {
  var bgColor;
  var bgDark;
  var bgDarker;

  if (bool) {
    bgColor = el.toRgbString();
  } else {
    bgColor = el;
  }

  if (bgColor) {
    var convertRgbToHex = rgb2hex(bgColor);
    var textColor = invertColor(convertRgbToHex, true);

    if (textColor.toString() === '#000000') {
      bgDark = LightenDarkenColor(convertRgbToHex, -20);
      bgDarker = LightenDarkenColor(convertRgbToHex, -40);
    } else {
      bgDark = LightenDarkenColor(convertRgbToHex, 20);
      bgDarker = LightenDarkenColor(convertRgbToHex, 40);
    }

    $('[data-theme="themePreviewBtn"]').css({
      'background-color': bgColor,
      'border-color': bgDark,
      'color': textColor
    });
    $('[data-theme="btn-bg"]').val(bgColor);
    $('[data-theme="btn-border"]').val(bgDark);
    $('[data-theme="btn-color"]').val(textColor);
    $('[data-theme="btn-bg-hover"]').val(bgDark);
    $('[data-theme="btn-border-hover"]').val(bgDarker);
  }
} // Calculations for the fifth color


function themeColorStatus(el, bool) {
  var statusBg;

  if (bool) {
    statusBg = el.toRgbString();
  } else {
    statusBg = el;
  }

  if (statusBg) {
    var convertRgbToHex = rgb2hex(statusBg);
    var statusColor = invertColor(convertRgbToHex, true);
    $('[data-theme="themePreviewStatus"]').css({
      'background-color': statusBg,
      'color': statusColor
    });
    $('[data-theme="status-bg"]').val(statusBg);
    $('[data-theme="status-color"]').val(statusColor);
  }
} // Calculations for the sixth color


function themeColorBorder(el, bool) {
  var borderColor;
  var borderColorFocus;

  if (bool) {
    borderColor = el.toRgbString();
  } else {
    borderColor = el;
  }

  if (borderColor) {
    $('[data-theme="themePreviewBorder"]').css('border-color', borderColor);
    $('[data-theme="themePreviewCard"]').css('border-color', borderColor);
    $('[data-theme="themePreviewNav"]').css('border-color', borderColor);
    var convertRgbToHex = rgb2hex(borderColor);
    var invertTheColor = invertColor(convertRgbToHex, true);

    if (invertTheColor.toString() === '#000000') {
      borderColorFocus = LightenDarkenColor(convertRgbToHex, -20);
    } else {
      borderColorFocus = LightenDarkenColor(convertRgbToHex, 20);
    }

    $('[data-theme="border-color-base"]').val(borderColor);
    $('[data-theme="border-color-focus"]').val(borderColorFocus);
  }
} // Determining the font family


function themeFontFamily(el) {
  if (el.val() === 'proxima-nova') {
    $('[data-theme="themePreview"]').addClass('ff-proxima-nova').removeClass('ff-montserrat ff-default ff-avenir-next ff-futura-pt');
    $('[data-theme="body-font-family"]').val("'proxima-nova'");
    $('[data-theme="theme-fontFamily"]').val('proxima-nova');
    $('[data-theme="themePreviewFontFamily"]').find('option').attr('selected', false);
    $('[data-theme="themePreviewFontFamily"]').find('option[value="proxima-nova"]').attr('selected', true);
    $('[data-theme="themePreviewFontFamily"]').val('proxima-nova');
  } else if (el.val() === 'futura-pt') {
    $('[data-theme="themePreview"]').addClass('ff-futura-pt').removeClass('ff-montserrat ff-proxima-nova ff-avenir-next ff-default');
    $('[data-theme="body-font-family"]').val("'futura-pt'");
    $('[data-theme="theme-fontFamily"]').val('futura-pt');
    $('[data-theme="themePreviewFontFamily"]').find('option').attr('selected', false);
    $('[data-theme="themePreviewFontFamily"]').find('option[value="futura-pt"]').attr('selected', true);
    $('[data-theme="themePreviewFontFamily"]').val('futura-pt');
  } else if (el.val() === 'avenir-next') {
    $('[data-theme="themePreview"]').addClass('ff-avenir-next').removeClass('ff-montserrat ff-proxima-nova ff-default ff-futura-pt');
    $('[data-theme="body-font-family"]').val("'Avenir Next'");
    $('[data-theme="theme-fontFamily"]').val('avenir-next');
    $('[data-theme="themePreviewFontFamily"]').find('option').attr('selected', false);
    $('[data-theme="themePreviewFontFamily"]').find('option[value="avenir-next"]').attr('selected', true);
    $('[data-theme="themePreviewFontFamily"]').val('avenir-next');
  } else if (el.val() === 'montserrat') {
    $('[data-theme="themePreview"]').addClass('ff-montserrat').removeClass('ff-proxima-nova ff-avenir-next ff-default ff-futura-pt');
    $('[data-theme="body-font-family"]').val("'montserrat'");
    $('[data-theme="theme-fontFamily"]').val('montserrat');
    $('[data-theme="themePreviewFontFamily"]').find('option').attr('selected', false);
    $('[data-theme="themePreviewFontFamily"]').find('option[value="montserrat"]').attr('selected', true);
    $('[data-theme="themePreviewFontFamily"]').val('montserrat');
  } else if (el.val() === 'default') {
    $('[data-theme="themePreview"]').addClass('ff-default').removeClass('ff-montserrat ff-proxima-nova ff-avenir-next ff-futura-pt');
    $('[data-theme="body-font-family"]').val("'Arial'");
    $('[data-theme="theme-fontFamily"]').val('default');
    $('[data-theme="themePreviewFontFamily"]').find('option').attr('selected', false);
    $('[data-theme="themePreviewFontFamily"]').find('option[value="default"]').attr('selected', true);
    $('[data-theme="themePreviewFontFamily"]').val('default');
  }
}

function settingTheTheme() {
  var color1 = $('[data-theme="theme-color-1"]').val(),
      color2 = $('[data-theme="theme-color-2"]').val(),
      color3 = $('[data-theme="theme-color-3"]').val(),
      color4 = $('[data-theme="theme-color-4"]').val(),
      color5 = $('[data-theme="theme-color-5"]').val(),
      color6 = $('[data-theme="theme-color-6"]').val(),
      colorText = $('[data-theme="theme-colorText"]').val(),
      fontFamily = $('[data-theme="theme-fontFamily"]'),
      name = $('[data-theme="theme-name"]').val();

  if (name !== undefined) {
    name = name.replace(/-/g, ' ');
  }

  $('#themePreviewPredefined').find('[data-theme="name"]').text(name);
  $('#themePreviewPredefined').find('[data-theme="span-1"]').css('background-color', color1);
  $('#themePreviewPredefined').find('[data-theme="span-2"]').css('background-color', color2);
  $('#themePreviewPredefined').find('[data-theme="span-3"]').css('background-color', color3);
  $('#themePreviewPredefined').find('[data-theme="span-4"]').css('background-color', color4);
  $('#themePreviewPredefined').find('[data-theme="span-5"]').css('background-color', color5);
  $('#themePreviewPredefined').find('[data-theme="span-6"]').css('background-color', color6);
  $('[data-theme="themeColorBg"]').spectrum('set', color1);
  $('[data-theme="themeColorNav1"]').spectrum('set', color2);
  $('[data-theme="themeColorNav2"]').spectrum('set', color3);
  $('[data-theme="themeColorBtn"]').spectrum('set', color4);
  $('[data-theme="themeColorStatus"]').spectrum('set', color5);
  $('[data-theme="themeColorBorder"]').spectrum('set', color6);
  $('[data-theme="themeImageBanner"]').spectrum('set', color5);
  themeColorBg(color1, false);
  themeColorNav1(color2, false);
  themeColorNav2(color3, false);
  themeColorBtn(color4, false);
  themeColorStatus(color5, false);
  themeColorBorder(color6, false);
  themeFontFamily(fontFamily);

  if (colorText === 'dark') {
    $('[data-theme="body-color"]').val('#f5f5f5');
    $('[data-theme="headings-color"]').val('#fff');
  } else if (colorText === 'light') {
    $('[data-theme="body-color"]').val('#484848');
    $('[data-theme="headings-color"]').val('#212529');
  }
} // color picker initialization


$('[data-theme="themeColorBg"]').spectrum({
  showAlpha: false,
  showButtons: false,
  showInput: true,
  showInitial: true,
  preferredFormat: 'rgb',
  showPalette: true,
  palette: [['#ffffff', '#B2ABA3', '#919295', '#666666'], ['#474c59', '#6C6256', '#ADA485', '#000000'], ['#EAE3D4', '#FF0000', '#fb3e5e', '#ab2328'], ['#f48024', '#FF5F00', '#61367a', '#552448'], ['#521F1E', '#769CCD', '#007cc2', '#4B7076'], ['#81D8D0', '#58c887', '#ABB400', '#BADA55']],
  move: function move(color) {
    themeColorBg(color, true);
    $('[data-theme="theme-color-1"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-1"]').css('background-color', color.toRgbString());
  },
  change: function change(color) {
    themeColorBg(color, true);
    $('[data-theme="theme-color-1"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-1"]').css('background-color', color.toRgbString());
  }
});
$('[data-theme="themeColorNav1"]').spectrum({
  showAlpha: false,
  showButtons: false,
  showInput: true,
  showInitial: true,
  preferredFormat: 'rgb',
  showPalette: true,
  palette: [['#ffffff', '#B2ABA3', '#919295', '#666666'], ['#474c59', '#6C6256', '#ADA485', '#000000'], ['#EAE3D4', '#FF0000', '#fb3e5e', '#ab2328'], ['#f48024', '#FF5F00', '#61367a', '#552448'], ['#521F1E', '#769CCD', '#007cc2', '#4B7076'], ['#81D8D0', '#58c887', '#ABB400', '#BADA55']],
  move: function move(color) {
    themeColorNav1(color, true);
    $('[data-theme="theme-color-2"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-2"]').css('background-color', color.toRgbString());
  },
  change: function change(color) {
    themeColorNav1(color, true);
    $('[data-theme="theme-color-2"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-2"]').css('background-color', color.toRgbString());
  }
});
$('[data-theme="themeColorNav2"]').spectrum({
  showAlpha: false,
  showButtons: false,
  showInput: true,
  showInitial: true,
  preferredFormat: 'rgb',
  showPalette: true,
  palette: [['#ffffff', '#B2ABA3', '#919295', '#666666'], ['#474c59', '#6C6256', '#ADA485', '#000000'], ['#EAE3D4', '#FF0000', '#fb3e5e', '#ab2328'], ['#f48024', '#FF5F00', '#61367a', '#552448'], ['#521F1E', '#769CCD', '#007cc2', '#4B7076'], ['#81D8D0', '#58c887', '#ABB400', '#BADA55']],
  move: function move(color) {
    themeColorNav2(color, true);
    $('[data-theme="theme-color-3"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-3"]').css('background-color', color.toRgbString());
  },
  change: function change(color) {
    themeColorNav2(color, true);
    $('[data-theme="theme-color-3"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-3"]').css('background-color', color.toRgbString());
  }
});
$('[data-theme="themeColorBtn"]').spectrum({
  showAlpha: false,
  showButtons: false,
  showInput: true,
  showInitial: true,
  preferredFormat: 'rgb',
  showPalette: true,
  palette: [['#ffffff', '#B2ABA3', '#919295', '#666666'], ['#474c59', '#6C6256', '#ADA485', '#000000'], ['#EAE3D4', '#FF0000', '#fb3e5e', '#ab2328'], ['#f48024', '#FF5F00', '#61367a', '#552448'], ['#521F1E', '#769CCD', '#007cc2', '#4B7076'], ['#81D8D0', '#58c887', '#ABB400', '#BADA55']],
  move: function move(color) {
    themeColorBtn(color, true);
    $('[data-theme="theme-color-4"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-4"]').css('background-color', color.toRgbString());
  },
  change: function change(color) {
    themeColorBtn(color, true);
    $('[data-theme="theme-color-4"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-4"]').css('background-color', color.toRgbString());
  }
});
$('[data-theme="themeColorStatus"]').spectrum({
  showAlpha: false,
  showButtons: false,
  showInput: true,
  showInitial: true,
  preferredFormat: 'rgb',
  showPalette: true,
  palette: [['#ffffff', '#B2ABA3', '#919295', '#666666'], ['#474c59', '#6C6256', '#ADA485', '#000000'], ['#EAE3D4', '#FF0000', '#fb3e5e', '#ab2328'], ['#f48024', '#FF5F00', '#61367a', '#552448'], ['#521F1E', '#769CCD', '#007cc2', '#4B7076'], ['#81D8D0', '#58c887', '#ABB400', '#BADA55']],
  move: function move(color) {
    themeColorStatus(color, true);
    $('[data-theme="theme-color-5"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-5"]').css('background-color', color.toRgbString());
  },
  change: function change(color) {
    themeColorStatus(color, true);
    $('[data-theme="theme-color-5"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-5"]').css('background-color', color.toRgbString());
  }
});
$('[data-theme="themeColorBorder"]').spectrum({
  showAlpha: false,
  showButtons: false,
  showInput: true,
  showInitial: true,
  preferredFormat: 'rgb',
  showPalette: true,
  palette: [['#ffffff', '#B2ABA3', '#919295', '#666666'], ['#474c59', '#6C6256', '#ADA485', '#000000'], ['#EAE3D4', '#FF0000', '#fb3e5e', '#ab2328'], ['#f48024', '#FF5F00', '#61367a', '#552448'], ['#521F1E', '#769CCD', '#007cc2', '#4B7076'], ['#81D8D0', '#58c887', '#ABB400', '#BADA55']],
  move: function move(color) {
    themeColorBorder(color, true);
    $('[data-theme="theme-color-6"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-6"]').css('background-color', color.toRgbString());
  },
  change: function change(color) {
    themeColorBorder(color, true);
    $('[data-theme="theme-color-6"]').val(color);
    $('[data-theme="theme-name"]').val('custom');
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
    $('#themePreviewPredefined').find('[data-theme="span-6"]').css('background-color', color.toRgbString());
  }
});
$('[data-theme="themeImageBanner"]').spectrum({
  showAlpha: false,
  showButtons: false,
  showInput: true,
  showInitial: true,
  preferredFormat: 'rgb',
  showPalette: true,
  palette: [['#ffffff', '#B2ABA3', '#919295', '#666666'], ['#474c59', '#6C6256', '#ADA485', '#000000'], ['#EAE3D4', '#FF0000', '#fb3e5e', '#ab2328'], ['#f48024', '#FF5F00', '#61367a', '#552448'], ['#521F1E', '#769CCD', '#007cc2', '#4B7076'], ['#81D8D0', '#58c887', '#ABB400', '#BADA55']]
});
settingTheTheme();
$('.theme-preview-dropdown-menu [data-theme="link"]').each(function () {
  var name = $(this).find('[data-theme="name"]').text().replace(/\s+/g, '-');
  var colour1 = $(this).find('[data-theme="span-1"]').css('background-color');
  var colour2 = $(this).find('[data-theme="span-2"]').css('background-color');
  var colour3 = $(this).find('[data-theme="span-3"]').css('background-color');
  var colour4 = $(this).find('[data-theme="span-4"]').css('background-color');
  var colour5 = $(this).find('[data-theme="span-5"]').css('background-color');
  var colour6 = $(this).find('[data-theme="span-6"]').css('background-color');
  var themeSelected = $(this).find('.theme-preview-selected');
  themeSelected.attr('data-theme-name', name);
  themeSelected.attr('data-theme-color-1', colour1);
  themeSelected.attr('data-theme-color-2', colour2);
  themeSelected.attr('data-theme-color-3', colour3);
  themeSelected.attr('data-theme-color-4', colour4);
  themeSelected.attr('data-theme-color-5', colour5);
  themeSelected.attr('data-theme-color-6', colour6);
});
$('[data-theme="themePreviewFontFamily"]').change(function () {
  if ($('[data-theme="theme-fontFamily"]').val() !== $(this).val()) {
    $('#themePreviewPredefined').find('[data-theme="name"]').text('Custom');
  }

  themeFontFamily($(this));
});
$('[data-theme="link"]').on('click', function (e) {
  e.preventDefault();
  var themeSelected = $(this).find('.theme-preview-selected');
  $(this).find('input[type="radio"]').prop('checked', true);
  var name = themeSelected.attr('data-theme-name').toString();
  var colorText = themeSelected.attr('data-theme-colortext').toString();
  var fontFamily = themeSelected.attr('data-theme-fontfamily').toString();
  var colorBg = themeSelected.attr('data-theme-color-1').toString();
  var colorNav1 = themeSelected.attr('data-theme-color-2').toString();
  var colorNav2 = themeSelected.attr('data-theme-color-3').toString();
  var colorBtn = themeSelected.attr('data-theme-color-4').toString();
  var colorStatus = themeSelected.attr('data-theme-color-5').toString();
  var colorBorder = themeSelected.attr('data-theme-color-6').toString();
  $('[data-theme="theme-name"]').val(name);
  $('[data-theme="theme-colorText"]').val(colorText);
  $('[data-theme="theme-fontFamily"]').val(fontFamily);
  $('[data-theme="theme-color-1"]').val(colorBg);
  $('[data-theme="theme-color-2"]').val(colorNav1);
  $('[data-theme="theme-color-3"]').val(colorNav2);
  $('[data-theme="theme-color-4"]').val(colorBtn);
  $('[data-theme="theme-color-5"]').val(colorStatus);
  $('[data-theme="theme-color-6"]').val(colorBorder);
  settingTheTheme();
});
$('[data-type="thumbnail-select"]').click(function () {
  $('[data-type="thumbnail-select"]').removeClass('active');
  $(this).addClass('active');
  $(this).find('input:radio[name=theme]').prop('checked', true);
}); // End of Theme ====================================================================================================

$(document).ready(function () {
  // nav-tabs-mobile-fix
  function tabFix() {
    if ($(window).width() < 768) {
      $('.nav-stacked').removeClass('nav-pills nav-stacked').addClass('nav-tabs nav-tabs-mobile-fix');
    } else {
      $('.nav-tabs-mobile-fix').addClass('nav-pills nav-stacked').removeClass('nav-tabs');
    }
  }

  tabFix();
  $(window).resize(function () {
    tabFix();
  });
}); // textarea autoExpand function

var autoExpand = function autoExpand(field) {
  // Reset field height
  field.style.height = 'inherit'; // Get the computed styles for the element

  var computed = window.getComputedStyle(field); // Calculate the height

  var height = parseInt(computed.getPropertyValue('border-top-width'), 10) + parseInt(computed.getPropertyValue('padding-top'), 10) + field.scrollHeight + parseInt(computed.getPropertyValue('padding-bottom'), 10) + parseInt(computed.getPropertyValue('border-bottom-width'), 10);
  field.style.height = height + 'px';
};

$('[data-expand="true"]').on('change keydown paste input', function () {
  autoExpand(this);
});
$(".nav-tabs a").on('shown.bs.tab', function () {
  var tabId = $(this).attr("href");
  $(tabId).find('[data-fix="aside"]').parent().siblings().first().css('min-height', $(tabId).find('[data-fix="aside"]').height());
}); /// ---
// General Toggle for checkboxes, radios and buttons
// This function will show/hide sections based on on which radio is selected.

function toggleRadio(dataName) {
  var radio = '[name="' + $(dataName).attr('name') + '"]';
  $(radio).each(function () {
    dataName = $(this).attr('data-toggle-radio');

    if ($(this).prop('checked')) {
      $('[data-toggle-radio-target=' + dataName + ']').removeAttr('hidden');
    } else {
      $('[data-toggle-radio-target=' + dataName + ']').attr('hidden', '');
    }
  });
}

;
$('[data-toggle-radio]').change(function () {
  toggleRadio(this);
}); // ToggleCheckbox
// This function will show/hide sections based on if the checkbox is selected or not

function toggleCheckbox(dataName) {
  dataName = $(dataName).attr('data-toggle-chk');

  if ($('[data-toggle-chk=' + dataName + ']').prop('checked')) {
    $('[data-toggle-chk-target=' + dataName + ']').removeAttr('hidden');
  } else {
    $('[data-toggle-chk-target=' + dataName + ']').attr('hidden', '');
  }
}

;
$('[data-toggle-chk]').change(function () {
  toggleCheckbox(this);
}); // ToggleCheckbox
// This function will show/hide sections based on if the checkbox is selected or not

function toggleButton(dataName) {
  var target = '[data-toggle-btn-target="' + $(dataName).attr('data-toggle-btn') + '"]';

  if (_typeof($(target).attr('hidden')) !== (typeof undefined === "undefined" ? "undefined" : _typeof(undefined)) && $(target).attr('hidden') !== false) {
    $(target).removeAttr('hidden');
  } else {
    $(target).attr('hidden', '');
  }
}

;
$('[data-toggle-btn]').click(function () {
  toggleButton(this);
});