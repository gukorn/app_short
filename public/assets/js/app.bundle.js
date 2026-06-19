function errorStatus(jqXHR, textStatus) { var textErr = ""; if (jqXHR.status === 0) { textErr = 'ไม่เชื่อมต่อเครือข่าย. ตรวจสอบเครือข่าย.'; } else if (jqXHR.status == 404) { textErr = 'ไม่พบหน้าที่เรียกหา. [404]'; } else if (jqXHR.status == 200 || jqXHR.status == 401) { textErr = 'ไม่ได้ใช้งานนานเกิน กรุณาเข้าระบบใหม่'; setTimeout(function () { location.reload(); }, 2000); } else if (jqXHR.status == 500) { textErr = JSON.parse(jqXHR.responseText).message; } else if (textStatus === 'parsererror') { textErr = 'การเรียก JSON ล้มเหลว.'; } else if (textStatus === 'timeout') { textErr = 'ผิดพลาด หมดเวลาเชื่อมต่อเครือข่าย.'; } else if (textStatus === 'abort') { textErr = 'การเรียกขอถูกยกเลิก.'; } else if (Number.isInteger(jqXHR.status)) { var text = "", myArr = JSON.parse(jqXHR.responseText); for (var c in myArr.errors) text += "- " + myArr.errors[c] + "</br>"; textErr = myArr.message + "</br>" + text; } else { textErr = 'ข้อผิดพลาด.! ' + jqXHR.responseText; } return textErr; }
var urlMain = $('body').data('url'), urlDashboard = $('body').data('dashboard'), iframeBox = $("#dee-iframe"), reloadChange = false;
jQuery(function ($) {
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });
    $('#toggle-btn').on('click', function () {
        $('body').toggleClass('sidebar-collapsed');
    });
});


var ModalAjax = {

    // modal: '<div class="modal fade" id="modalshow" data-bs-backdrop="static" data-bs-keyboard="false" data-blur="true" role="dialog" aria-hidden="true"><div class="modal-dialog modal-lg modal-dialog-centered" role="document"><div class="modal-content shadow border-none radius-2"><div class="modal-body p-0"></div></div></div></div>',
    // show: function (e, link) {
    //     if ($("body").find('#modalshow').hasClass("modal") == false) {
    //         $('body').append(this.modal);
    //     }
    //     if (e.hasClass("modal-xl") == true) {
    //         $('#modalshow').find(".modal-lg").addClass('modal-xl');
    //     } else {
    //         $('#modalshow').find(".modal-xl").removeClass('modal-xl');
    //     }
    //     $('#modalshow').find(".modal-body").html('<div class="text-center"><div class="spinner-border" role="status"></div></div>');
    //     $('#modalshow').find(".modal-body").load(link);
    //     $('#modalshow').on('hidden.bs.modal', function () {
    //         $('body').removeClass('modal-blur');
    //     }).modal('show');
    // },
    // close: function () {
    //     $('#modalshow').modal('hide');
    // }
    _generateUniqueId: function () {
        return 'modalshow_' + Date.now() + Math.floor(Math.random() * 1000);
    },
    show: function (element, link) {
        // 1. ก่อนเปิดตัวใหม่: ถ้ามี modal เปิดอยู่แล้ว ให้เบลอตัวที่เปิดอยู่ก่อน
        // $('.modal.show').find('.modal-content').addClass('modal-content-blur');
        const uniqueModalId = this._generateUniqueId();
        const modalHtml = `
            <div class="modal fade" id="${uniqueModalId}" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content shadow border-none radius-2">
                        <div class="modal-body p-0"></div>
                    </div>
                </div>
            </div>
        `;
        $('body').append(modalHtml);
        const $currentModal = $('#' + uniqueModalId);
        if (element && element.hasClass && element.hasClass("modal-xl")) {
            $currentModal.find(".modal-dialog").addClass('modal-xl');
        }
        $currentModal.find(".modal-body").html('<div class="text-center p-5"><div class="spinner-border" role="status"></div></div>');
        const $previousActiveElement = $(document.activeElement);

        $currentModal.find(".modal-body").load(link, function (response, status, xhr) {
            if (status == "error") {
                $currentModal.find(".modal-body").html("<div class='alert alert-danger m-3'>ไม่สามารถโหลดเนื้อหาได้: " + xhr.status + " " + xhr.statusText + " <button type='button' class='btn btn-light btn-sm' data-bs-dismiss='modal'>ปิด</button></div>");
            }
        });

        // เมื่อ modal นี้กำลังจะถูกปิด
        $currentModal.on('hide.bs.modal', function () {
            $(this).focus();
        });

        $currentModal.on('hidden.bs.modal', function () {
            const self = this;
            setTimeout(function () {
                $(self).remove(); // ลบ HTML ทิ้งทันที

                const remainingVisibleModals = $('.modal.show').length;
                if (remainingVisibleModals === 1) {
                    // *** กรณีไม่เหลือ Modal แล้ว: ล้างเบลอออกให้หมด ***
                    // $('body').removeClass('body-blur');
                    // $('body').removeClass('modal-blur'); // กันพลาดชื่อคลาสเก่า
                    $('body').css('overflow', ''); // คืนค่าการเลื่อนหน้าจอ

                    if ($previousActiveElement && $previousActiveElement.length) {
                        $previousActiveElement.focus();
                    }
                } else {
                    // *** กรณีเหลือ Modal ตัวล่าง: เอาเบลอออกจากตัวบนสุดที่เหลืออยู่ ***
                    const $topModal = $('.modal.show').last();
                    // $topModal.find('.modal-content').removeClass('modal-content-blur');
                    $topModal.focus();
                }
            });
        });

        $currentModal.modal('show');
        // 3. ใส่เบลอที่เนื้อหาเว็บ (ถ้ายังไม่ได้ใส่)
        if (!$('body').hasClass('body-blur')) {
            // $('body').addClass('body-blur');
        }
    },

    close: function () {
        const $topModal = $('.modal.show').last();
        if ($topModal.length) {
            // --- ส่วนที่แก้เพื่อลบ Warning ---
            // 1. หาว่ามีอะไรใน Modal นี้ที่ถูกโฟกัสอยู่ไหม
            const $focusedElement = $topModal.find(':focus');
            if ($focusedElement.length > 0) {
                // 2. ถ้ามี ให้ 'เตะ' โฟกัสออกมาที่ body ก่อนจะสั่งปิด
                $focusedElement.blur(); // เอาโฟกัสออก
                $('body').focus();      // ย้ายไปที่จุดปลอดภัย
            }
            // ------------------------------

            $topModal.modal('hide');
        }
    }
}

function addEvent(form) {
    $(form).validationEngine('attach', {
        promptPosition: "topLeft",
        autoHidePrompt: true,
        onValidationComplete: function (form, status) {
            if (status) {
                bgBlur();
                $(form).prepend('<div class="bs-card-loading-overlay"><i class="bs-card-loading-icon bi bi-arrow-repeat fa-spin fa-2x text-white"></i></div>');
                var formData = new FormData($(form)[0]);
                if ($(form).data('confirm')) {
                    bgBlurRemoved();
                    Swal.fire({
                        title: $(form).data('confirm'), icon: "warning",
                        showCancelButton: true, confirmButtonText: $(form).data('confirm-confirmbutton') ? $(form).data('confirm-confirmbutton') : "บันทึก",
                        cancelButtonText: $(form).data('confirm-cancelbutton') ? $(form).data('confirm-cancelbutton') : "ยกเลิก"
                    }).then(function (result) {
                        if (result.value) {
                            bgBlur();
                            setTimeout(function () {
                                upload_data(form, formData);
                            }, 100);
                        } else {
                            bgBlurRemoved()
                            $(form).find('.bs-card-loading-overlay').remove();
                        }
                    });
                } else {
                    setTimeout(function () {
                        upload_data(form, formData);
                    }, 100);
                }
            }
        }
    });
    //event.preventDefault();event.stopPropagation();//form.classList.add('was-validated');
    return false;
}
function upload_data(form, formData) {
    if (typeof $(form).attr('actionCallback') !== typeof undefined) {
        if ($(form).attr('actionCallback') == "") {
            var fn = window[$(form).attr('formcallback')];//|| options.customFunctions[ $(form).attr('formcallback')];
            if (typeof fn === "function") fn();
            else formcallback();
        } else {
            var fn = window[$(form).attr('actionCallback')];//|| options.customFunctions[ $(form).attr('actionCallback')];
            if (typeof fn === "function") fn();
            else formcallback();
        }
        bgBlurRemoved();
    } else {

        if ($(form).attr('method') == "GET") {
            var data_url = $(form).attr('action');
            const asString = new URLSearchParams(formData).toString();
            window.history.pushState("object or string", "Title", urlMain + '#!/' + data_url.substr(urlMain.length, data_url.length) + "?" + asString);
            dee_Load($(form).attr('action') + "?" + asString);
            return;
        }

        $.ajax({
            url: $(form).attr('action'), data: formData, type: "POST", dataType: "json", timeout: 10000, async: false, cache: false, contentType: false, processData: false,
            complete: function (data) { bgBlurRemoved(); $(form).find('.bs-card-loading-overlay').remove(); },
            success: function (data) {
                if (data.status) {
                    if (typeof $(form).attr('formcallback') !== typeof undefined) {

                        var fn = window[$(form).attr('formcallback')];
                        if (typeof fn === "function") fn(data);
                        else formcallback(data);
                    } else {

                        if (data.message) toastrSuccess(data.message);
                        if (data.url) {
                            if (urlMain) {
                                window.history.pushState("object or string", "Title", urlMain + '#!/' + data.url.substr(urlMain.length, data.url.length));
                                dee_Load((data.url.indexOf(":") >= 0) ? data.url : urlMain + "/" + data.url);
                            } else {
                                location = data.url;
                            }
                        }
                    }
                } else {
                    Swal.fire({ icon: "error", title: "มีข้อผิดพลาดบางอย่าง.", text: data.message, focusConfirm: false, allowOutsideClick: false });
                }
            }, error: function (jqXHR, textStatus, error) {
                if (jqXHR.status == 200) location.reload();
                else Swal.fire({ icon: "error", title: "ผิดพลาด.[" + jqXHR.status + "]", html: errorStatus(jqXHR, textStatus), focusConfirm: false, allowOutsideClick: false });
            }
        });
    }
}
function bgBlur() {
    setTimeout(function () {
        $("[id^='tooltip']").remove();
    }, 400);
    $('#loadingg').css('display', 'block');
    $('body').addClass('modal-blur');
}
function bgBlurRemoved() {
    $('#loadingg').css('display', 'none');
    $('body').removeClass('modal-blur');
}

function checkIDCard(value) {
    if ($.trim(value) !== '' && value.length === 13) {
        var id = value.replace(/-/g, "");
        var result = Script_checkID(id);
        if (result === false) {
            parent.Swal.fire({ icon: "warning", title: "คำเตือน!", text: "กรุณากรอกเลขบัตรให้ถูกต้อง" });
            value.replace("");
        } else {
            $('span.error').addClass('true').html('<i class="fa fa-check"></i>');
        }
    } else {
        $('span.error').removeClass('true').text('');
    }
}

function isEmpty(el) {
    return !$.trim(el.html())
}
function SetLoaderbox(index, url) {
    $(index).data('loaderbox', url);
    ReLoaderbox(index);
}
function ReLoaderbox(index) {
    var $this = $(index);
    if (isEmpty($this.find('.loader'))) {
        if (isEmpty($this.find('.card')))
            $this.prepend('<div class="bs-card-loading-overlay pos-rel p-2 m-2"><i class="bs-card-loading-icon fa fa-spinner fa-spin fa-2x text-white"></i></div>');
        else
            $this.find('.card').prepend('<div class="bs-card-loading-overlay p-2"><i class="bs-card-loading-icon fa fa-spinner fa-spin fa-2x text-white"></i></div>');
    }
    var urlGo = ($this.data('loaderbox').lastIndexOf("://") >= 0) ? $this.data('loaderbox') : urlMain + "/" + $this.data('loaderbox');
    $this.addClass("enable-loader");
    $.ajax({
        url: urlGo, type: "GET", timeout: 30000,
        // complete:function(data) {  $this.find('.bs-card-loading-overlay').remove(); },
        success: function (data) {
            $this.html(data);
        }, error: function (jqXHR, textStatus, error) {
            Swal.fire({ icon: "error", title: "ผิดพลาด.", text: errorStatus(jqXHR, textStatus) });
            $this.html('<div class="text-center m-3"><button type="button" class="btn btn-sm btn-outline-warning waves-effect waves-themed" data-loaderbox-reload >โหลดใหม่</button></div>');
        }
    });
}
function ReLoaderval(value) {
    $("[data-loaderval='" + value + "']").html('<i class="bs-card-loading-icon fa fa-spinner fa-spin fa-2x text-white"></i>');
    var urlGo = (value.lastIndexOf("://") >= 0) ? value : urlMain + "/" + value;
    $.ajax({
        url: urlGo, type: "GET", timeout: 30000, dataType: "json",
        success: function (data) {
            $.each(data, function (i, v) { $("#" + i).html(v); });
        }, error: function (jqXHR, textStatus, error) {
            $("[data-loaderval='" + value + "']").html('<button type="button" class="btn btn-sm btn-outline-warning waves-effect waves-themed" data-loaderval-reload >โหลดใหม่</button>');
            Swal.fire({ icon: "error", title: "ผิดพลาด.", text: errorStatus(jqXHR, textStatus) });
        }
    });
}
function funModalBox(e) {
    var $this = e;

    Swal.fire({
        title: $this.data('modalbox'), icon: $this.data('modalbox-icon'), input: $this.data('modalbox-input'), confirmButtonColor: $this.data('modalbox-confirmcolor') ? '#' + $this.data('modalbox-confirmcolor') : '#d33', cancelButtonColor: '#CCC', reverseButtons: true,
        inputPlaceholder: $this.data('modalbox-placeholder'), showCancelButton: true, confirmButtonText: $this.data('modalbox-confirmbutton') ? $this.data('modalbox-confirmbutton') : "บันทึก", cancelButtonText: $this.data('modalbox-cancelbutton') ? $this.data('modalbox-cancelbutton') : "Cancel",
        inputValidator: (value) => { if (!value) return $this.data('modalbox-placeholder'); }
    }).then(function (result) {
        if (result.value) {
            var $method = $this.data('modalbox-method') ? $this.data('modalbox-method') : 'POST';
            var formData = new FormData();
            formData.append('val', result.value);
            formData.append('_method', $method);
            bgBlur();
            $.ajax({
                url: $this.data('modalbox-href'), data: formData, type: $method, dataType: "json", timeout: 10000, async: false, cache: false, contentType: false, processData: false,
                success: function (data) {
                    if (data.status) {
                        if (typeof $this.attr('funcallback') !== typeof undefined) {
                            var fn = window[$this.attr('funcallback')];
                            if (typeof fn === "function") fn(data);
                            else funcallback(data);
                        } else {
                            if (data.message) toastrSuccess(data.message);
                            if (data.url) {
                                window.history.pushState("object or string", "Title", urlMain + '#!/' + data.url.substr(urlMain.length, data.url.length));
                                dee_Load((data.url.indexOf(":") >= 0) ? data.url : urlMain + "/" + data.url);
                            }
                        }
                    } else {
                        Swal.fire({ icon: "error", title: "ผิดพลาด.", text: data.message });
                    }
                    bgBlurRemoved();
                }, error: function (jqXHR, textStatus, error) {
                    bgBlurRemoved();
                    Swal.fire({ icon: "error", title: "ผิดพลาด.[" + jqXHR.status + "]", html: errorStatus(jqXHR, textStatus) });
                }
            });
        }

    });
}
function toastrSuccess(msg) {
    // $.aceToaster.add({
    //     placement: 'tr',
    //     body: '<div class="alert d-flex bgc-white brc-success-m4 border-1 p-0 m-0" role="alert">\
    //     <div class="bgc-success p-25 text-center m-n1px radius-l-1">\
    //       <i class="fa fa-check text-150 text-white"></i>\
    //     </div>\
    //     <span class="ml-3 align-self-center text-success-d3 text-110">'+ msg + '</span>\
    //     <a href="#" role="button" class="btn btn-xs radius-round position-tr btn-outline-success border-0 px-1 pt-0 pb-1 text-110 m-1" data-dismiss="alert" aria-label="Close">\
    //     <i class="fa fa-times text-sm w-2 mx-1px" aria-hidden="true"></i>\
    //     </a>\
    //     </div>',
    //     width: 300,
    //     delay: 3000,
    //     close: true,
    //     className: 'bgc-white-tp1 shadow border-0',
    //     bodyClass: 'border-0 p-0 text-dark-tp2',
    //     headerClass: 'd-none',
    // });
}
function funAction(e, url) {
    var _this = e;
    bgBlur();
    _this.addClass('disabled');
    setTimeout(function () {
        $.ajax({
            url: url, data: null, type: "POST", dataType: "json", timeout: 10000, async: false, cache: false, contentType: false, processData: false,
            complete: function (data) { _this.removeClass('disabled'); },
            success: function (data) {
                if (data.status) {
                    if (typeof _this.attr('formcallback') !== typeof undefined) {
                        var fn = window[_this.attr('formcallback')];
                        if (typeof fn === "function") fn(data);
                        else formcallback(data);
                    } else {
                        if (data.message) toastrSuccess(data.message);
                        if (data.url) {
                            if (urlMain) {
                                window.history.pushState("object or string", "Title", urlMain + '#!/' + data.url.substr(urlMain.length, data.url.length));
                                dee_Load((data.url.indexOf(":") >= 0) ? data.url : urlMain + "/" + data.url);
                            } else {
                                location = data.url;
                            }
                        }
                    }
                } else {
                    Swal.fire({ icon: "error", title: "มีข้อผิดพลาดบางอย่าง.", text: data.message , focusConfirm: false, allowOutsideClick: false});
                }
                bgBlurRemoved();
            }, error: function (jqXHR, textStatus, error) {
                bgBlurRemoved();
                if (jqXHR.status == 200) location.reload();
                else Swal.fire({ icon: "error", title: "ผิดพลาด.[" + jqXHR.status + "]", html: errorStatus(jqXHR, textStatus) });
            }
        });
        _this.removeClass('disabled');
    }, 200);

}
// (function(){'use strict';window.addEventListener('load', function(){
$('body').append('<div id="loadingg" class="modal modal-alert fade show " style="display: none;top: 40%;z-index: 9999999;" ><div class="modal-dialog position-center" role="document"><div class="modal-content "  style="border: none;background-color: rgba(0, 0, 0, 0.3); "><div class="modal-body text-center text-white ">กำลังโหลด... <div class="spinner-border" role="status"></div></div></div></div></div>');


// $('[data-toggle]').tooltip();
// $('.tooltip-secondary').tooltip({ template: '<div class="tooltip" role="tooltip"><div class="brc-secondary-d3 arrow"></div><div class="bgc-secondary-d3 tooltip-inner text-105 text-600"></div></div>'});
// $('.tooltip-danger').tooltip({template: '<div class="tooltip" role="tooltip"><div class="arrow brc-danger-d3"></div><div class="bgc-danger-d3 tooltip-inner text-110 text-600 p-2"></div></div>' });
// $('.tooltip-success').tooltip({template: '<div class="tooltip" role="tooltip"><div class="arrow brc-success-d3"></div><div class="bgc-success-d3 tooltip-inner text-600 text-110 px-2 pb-15"></div></div>'});
// $('.tooltip-warning').tooltip({ template: '<div class="tooltip" role="tooltip"><div class="arrow brc-warning-d1"></div><div class="bgc-warning-d1 tooltip-inner text-110 text-600 px-2 pb-15"></div></div>'});
// $('.tooltip-primary').tooltip({ template: '<div class="tooltip" role="tooltip"><div class="arrow brc-primary-d1"></div><div class="bgc-primary-d1 tooltip-inner text-110 text-600 px-2 pb-15"></div></div>'});


// $('.tooltip-1').tooltip({ template: '<div class="tooltip" role="tooltip"><div class="arrow brc-purple-d2"></div><div class="shadow border-2 radius-2 brc-purple-d2 bgc-purple-l4 tooltip-inner text-dark-tp1 text-110 text-600 px-2 pb-15"></div></div>' });


$(".needs-validation").each(function (index) {
    addEvent(this);
});

$("[data-loaderbox]").each(function (index) {
    ReLoaderbox(this);
});

var arrLoaderval = [];
$("[data-loaderval]").each(function () {
    if (arrLoaderval.includes($(this).data('loaderval')) == false)
        arrLoaderval.push($(this).data('loaderval'));
    $(this).prepend('<i class="bs-card-loading-icon fa fa-spinner fa-spin fa-2x text-white"></i>');
});
if (arrLoaderval.length > 0) {
    $.each(arrLoaderval, function (index, value) {
        ReLoaderval(value);
    });
}

$("body").on("click", "[data-loaderbox-reload]", function (e) {
    ReLoaderbox($(this).closest('[data-loaderbox]'));
}).on("click", "[data-loaderval-reload]", function (e) {
    ReLoaderval($(this).closest('[data-loaderval]').data('loaderval'));
}).on("click", "[data-alerterro]", function (e) {
    e.preventDefault();
    Swal.fire({ icon: "error", title: "ผิดพลาด.", text: $(this).data('alerterro') });
}).on("click", "[data-modalbox]", function (e) {
    e.preventDefault();
    funModalBox($(this));
}).on("click", ".href-show", function (e) {
    e.preventDefault();
    var href = $(this).attr("href");
    ModalAjax.show(href);
}).on("click", ".load-iframe", function (e) {
    e.preventDefault();
    var href = $(this).attr("href");
    dee_Load(href);
}).on("change", '[data-check-none]', function () {
    if ($(this).data("none") == true) $("." + $(this).data("check-none")).removeClass('d-none');
    if ($(this).data("none") == false) $("." + $(this).data("check-none")).addClass('d-none');
}).on("change", '[data-check-disabled]', function () {
    if (this.checked) $("." + $(this).data("check-disabled")).prop('disabled', false);
    else $("." + $(this).data("check-disabled")).prop('disabled', true).val('');
}).on("click", '[data-bt_action_confirm]', function () {
    var _this = $(this);
    Swal.fire({
        title: _this.data('confirm-title') ? _this.data('confirm-title') : "ยืนยันการดำเนินการ", icon: 'warning', confirmButtonColor: _this.data('confirm-btcolor') ? '#' + _this.data('confirm-btcolor') : '#1e802eff', cancelButtonColor: '#CCC', reverseButtons: true,
        text: _this.data('confirm-text'), showCancelButton: true, confirmButtonText: _this.data('confirm-confirmbutton') ? _this.data('confirm-confirmbutton') : "ยืนยัน", cancelButtonText: _this.data('confirm-cancelbutton') ? _this.data('confirm-cancelbutton') : "ยกเลิก",
    }).then(function (result) {
        if (result.value) {
            funAction(_this, _this.data('bt_action_confirm'));
        }
    });
}).on("click", '[data-bt_action]', function () {
    var _this = $(this);
    funAction(_this, _this.data('bt_action'));
}).on("change", '[data-checkbox]', function () {
    if (this.checked) $("." + $(this).data("checkbox")).prop('checked', true);
    else $("." + $(this).data("checkbox")).prop('checked', false);
    var cl = $(this).data("checkbox");
    $("body").on("change", "." + cl, function (e) {
        if (!this.checked) $("[data-checkbox='" + cl + "']").prop('checked',);
    })

}).on("click", ".modal-show", function (e) {
    e.preventDefault();
    $('.dropdown-menu').removeClass('show').removeAttr('style');
    $('[data-bs-toggle="dropdown"]').attr('aria-expanded', 'false');
    var href = $(this).attr("href");
    href += (href.lastIndexOf("?") >= 0) ? "&" : "?";
    if ($(this).data("lat") && $(this).data("lat")) {
        if ($(this).data("lat").length > 0 || parseFloat($(this).data("lat")) != 0) href += "lat=" + $(this).data("lat");
        if ($(this).data("long").length > 0 || $(this).data("long") != 0) href += "&long=" + $(this).data("long");
    }
    ModalAjax.show($(this), href);
}).on("click", '[data-action="iframe-print"]', function (e) {
    window.print();
}).on("click", "#dee-iframe a:not([target='_blank'],[href^='#'],[href^='javascript'],[data-reload], .tab-no, .modal-show, .load-iframe)", function (e) {
    var href = $(this).attr("href");
    if (typeof href !== 'undefined' && href !== false && href.lastIndexOf("javascript") < 0) {
        e.preventDefault();
        window.history.pushState("object or string", "Title", urlMain + '#!/' + href.substr(urlMain.length, href.length));
        dee_Load(href);
    }
}).on("click", ".sidebar-nav a", function (e) {
    var dee_hash = $(this).attr("href");
    if (dee_hash.lastIndexOf("#!") >= 0) {
        dee_Load(dee_hash);
        $(".sidebar-nav  .active").removeClass('active open is-toggling');
        // $("#js-nav-menu  li .active,#js-nav-menu > li.active").removeClass('active open is-toggling');
        // $("#js-nav-menu  li .show").removeClass('show active');
        // $("#js-nav-menu  li .open").addClass('active');
        // $(this).closest('#js-nav-menu > li').addClass('active open');//open
        // $(this).closest('#js-nav-menu>li>div>ul>li').addClass('active');//open
        // $(".active > .submenu ").addClass('show');
        $(this).addClass("active");
        // if ($("#js-nav-menu > li.active").length >= 2) $("#js-nav-menu >li.active.open").removeClass('active open');
        // if ($("#js-nav-menu  li.active").length == 1) $("#js-nav-menu >li.active.open").removeClass('open');
    }
}).on("click", "[data-reload]", function (e) {
    $.ajax({
        url: $(this).data("reload"), type: "GET", timeout: 30000, success: function () {
            location.reload();
        }
    });
}).on('keypress , paste', '.number-separator', function (e) {
    if (/^-?\d*[,.]?(\d{0,3},)*(\d{3},)?\d{0,3}$/.test(e.key) || e.type == "paste") {
        $('.number-separator').on('input', function () {
            e.target.value = numberSeparator(e.target.value);
        });
    } else {
        e.preventDefault();
        return false;
    }
}).on("click", '[href="javascript:history.go(-1);"]', function (e) {
    e.preventDefault();
    history.back(1);
    // setTimeout(function(){
    //     dee_Load(window.location.hash);
    // },50);
});


var commaCounter = 10;
function numberSeparator(Number) {
    Number += '';
    for (var i = 0; i < commaCounter; i++) {
        Number = Number.replace(',', '');
    }
    x = Number.split('.');
    y = x[0];
    z = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(y)) {
        y = y.replace(rgx, '$1' + ',' + '$2');
    }
    commaCounter++;
    return y + z;
}
$(document).on('click', '#dee-iframe [data-bs-toggle="dropdown"]', function (e) {
    // ป้องกันไม่ให้มันไปทำงานซ้ำซ้อนกับ Bootstrap ปกติ
    e.stopPropagation();
    var instance = bootstrap.Dropdown.getOrCreateInstance(this);
    instance.toggle();
});
function dee_Load(linkPage, updateUrl = false) {
    if (iframeBox.length) {
        var c = Math.min(400, Math.max(500, parseInt($("html").scrollTop() / 3))); $("html,body").animate({ scrollTop: 0 }, c);
        bgBlur();
        reloadChange = false;
        var fliemodule = linkPage || "";
        if (fliemodule.startsWith("#!/")) {
            fliemodule = fliemodule.slice(3);
        } else if (fliemodule.startsWith("#!")) {
            fliemodule = fliemodule.slice(2);
        }
        if (fliemodule.lastIndexOf(urlMain) >= 0) { fliemodule = fliemodule.substr(urlMain.length, fliemodule.length); }
        if (!fliemodule || fliemodule.length <= 1) fliemodule = urlDashboard;
        if (fliemodule.lastIndexOf("http") >= 0) { fliemodule = fliemodule; } else { fliemodule = urlMain + fliemodule; }
        if (updateUrl) window.history.pushState("object or string", "Title", urlMain + '#!/' + fliemodule);

        $.get(fliemodule, function (data) {
            iframeBox.html(data);

        }).done(function () {
            reloadChange = true;
            bgBlurRemoved();

        }).fail(function (jqXHR, textStatus) {
            bgBlurRemoved();
            history.back(1);
            icon_ = "error";
            title_ = "ผิดพลาด.[" + jqXHR.status + "]";
            if (jqXHR.status == 428) {
                icon_ = "warning";
                title_ = "แจ้งเตือน";
            }
            Swal.fire({ icon: icon_, title: title_, html: errorStatus(jqXHR, textStatus) });
        });
    }

}
dee_Load(window.location.hash);
openMenu(window.location.hash);

function openMenu(linkPage) {
    if (linkPage.lastIndexOf(urlMain) >= 0) { linkPage = linkPage.substr(urlMain.length, linkPage.length); }
    $("#js-nav-menu  li .active,#js-nav-menu > li.active").removeClass('active open is-toggling');
    $("#js-nav-menu  li .show").removeClass('show');
    $("#js-nav-menu  li .open").addClass('active');
    $("[href='" + linkPage + "']").closest('#js-nav-menu>li').addClass('active').addClass('open');
    $("[href='" + linkPage + "']").closest('#js-nav-menu>li>div>ul>li').addClass('active').addClass('open');
    // $("[href='"+linkPage+"']").closest('#js-nav-menu  > li >ul > li').addClass('open').addClass('active');
    $("[href='" + linkPage + "']").closest('li').removeClass('open').addClass('active');
    // $("[href='"+linkPage+"']").closest('div.submenu').addClass('show');
    $(".active > .submenu ").addClass('show');
    if ($("#js-nav-menu > li.active").length >= 2) $("#js-nav-menu >li.active.open").removeClass('active open');
    if ($("#js-nav-menu  li.active").length == 1) $("#js-nav-menu >li.active.open").removeClass('open');
}
document.onmouseover = function () { window.innerDocClick = true; }
document.onmouseleave = function () { window.innerDocClick = false; }
window.onhashchange = function () {
    if (reloadChange) {
        dee_Load(window.location.href);
        openMenu(window.location.href);
    }
}


// }, false);})();

//if (window.location != window.parent.location) window.parent.location="http://"+window.location.hostname+"/Err";

