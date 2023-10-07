(function (window, undefined) {

    'use strict';

    _.templateSettings.variable = "__tData";

    window.__globals = {
        translate_strings: {},
        default_show_message: false
    };

    if (window.appConfig['locale']) {
        var localeNumberFormat = new Intl.NumberFormat(window.appConfig.locale);
    } else {
        var localeNumberFormat = null;
    }

    /**
      * Common Functions : 08 JAN 2020
      * LivelyWorks
      *
      *-------------------------------------------------------- */
    window.__Utils = {
        log: function (text, textStyle) {

            if (window.appConfig && window.appConfig.debug) {

                var consoleTextStyle = '',
                    prependForStyle = '';

                if (textStyle && _.isString(text)) {
                    consoleTextStyle = textStyle;
                    prependForStyle = '%c ';

                    console.log(prependForStyle + text, consoleTextStyle);
                } else {
                    console.log(text);
                }
                consoleTextStyle = prependForStyle = null;
            }
        },

        syntaxHighlight: function (json) {
            json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
            return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
                var cls = 'color: darkorange;'; /*number*/
                if (/^"/.test(match)) {
                    if (/:$/.test(match)) {
                        cls = 'color: red;'; /*key*/
                    } else {
                        cls = 'color: green;'; /*string*/
                    }
                } else if (/true|false/.test(match)) {
                    cls = 'color: blue;'; /*boolean*/
                } else if (/null/.test(match)) {
                    cls = 'color: magenta;'; /*null*/
                }
                return '<span style="' + cls + '">' + match + '</span>';
            });
        },

        displayInTabWindow: function (text) {

            if (window.appConfig && window.appConfig.debug) {
                if (text) {
                    var textToPrint = '';
                    if (_.isObject(text)) {
                        if (_.has(text, 'data')) {
                            textToPrint = '<pre style="font-size:14px; outline: 1px solid #ccc; padding: 10px; margin: 0px;"><strong>URL: </strong>' + (text.config ? text.config.url : '') + ' <strong><br>Method: </strong>' + (text.config ? text.config.method : '') + ' <strong><br>statusText: </strong>' + text.statusText + ' (' + text.status + ') <strong style="color:red"><br>Error Message: ' + text.data.message + '</strong></pre>';
                        }
                        textToPrint += '<pre style="outline: 1px solid #ccc; padding: 5px; margin: 0px;">' + __Utils.syntaxHighlight(JSON.stringify(text, null, 4)) + '</pre>';
                    } else {
                        textToPrint = text;
                    }
                    var dynamicTabWindow = window.open('', '_blank');
                    dynamicTabWindow.document.write(textToPrint);
                    dynamicTabWindow.document.close(); // necessary for IE >= 10
                    dynamicTabWindow.focus(); // necessary for IE >= 10
                } else {
                    console.log("__Utils: Text not found for window.")
                }
                text = textToPrint = null;
            }
        },

        openEmailDebugView: function (url) {
            if (window.appConfig && window.appConfig.debug) {
                window.open(url, "__emailDebugView");
                __Utils.info("Request Sent to open Email Debug View.");
            }
        },

        error: function (text) {
            if (window.appConfig && window.appConfig.debug) {
                console.error(text);
            }
        },

        info: function (text) {
            if (window.appConfig && window.appConfig.debug) {
                console.info(text);
            }
        },

        warn: function (text) {
            if (window.appConfig && window.appConfig.debug) {
                console.warn(text);
            }
        },

        throwError: function (text) {
            if (window.appConfig && window.appConfig.debug) {
                throw new Error(text);
            }
        },

        jsdd: function (response) {
            if (window.appConfig && window.appConfig.debug) {
                if (response.__dd && response.__pr) {
                    if (!response.__prExecuted) {
                        var prCount = 1;
                        _.forEach(response.__pr, function (__prValue) {
                            var debugBacktrace = '';
                            console.log('%c Server __pr ' + prCount + " --------------------------------------------------", 'color:#f0ad4e');
                            _.forEach(__prValue, function (value, key) {
                                if (key !== 'debug_backtrace') {
                                    console.log(value);
                                } else {
                                    debugBacktrace = value;
                                }
                            });
                            console.log('%c Reference  --------------------------------------------------', 'color:#f0ad4e');
                            console.log(debugBacktrace);
                            prCount++;
                        });
                        response.__prExecuted = true;
                        console.log("%c ------------------------------------------------------------ __pr end", 'color: #f0ad4e');
                    }
                }
                if (response.__dd && response.__clog) {
                    if (!response.__clogExecuted) {
                        __Utils.clog(response);
                        response.__clogExecuted = true;
                    }
                }

                if (response.__dd && response.__dd === '__dd') {
                    if (!response.__ddExecuted) {
                        console.log('%c Server __dd  --------------------------------------------------', 'color:#ff0000');
                        var ddCount = 1;
                        _.forEach(response.data, function (value, key) {
                            if (key !== 'debug_backtrace') {
                                console.log(value);
                                ddCount++;
                            } else {
                                console.log('%c Reference  --------------------------------------------------', 'color:#ff0000');
                                console.log(value);
                            }
                        });
                        response.__ddExecuted = true;
                    }
                    console.log("%c ------------------------------------------------------------ __dd end", 'color: #ff0000');
                    throw '------------------------------------------------------------ __dd end.';
                }
            }
        },
        /**
         * Console the items requested from __clog Laraware helper function
         *
         *-------------------------------------------------------- */
        clog: function (clogData) {
            if (!__globals) {
                var __globals = {
                    __clogCount: 0
                }
            }
            var clCount = 1,
                clogType = clogData.__clogType ? clogData.__clogType : '';
            _.forEach(clogData.__clog, function (__clogValue) {
                _.forEach(__clogValue, function (value) {
                    console.log('%c __clog ' + clogType + ' ' + clCount + " --------------------------------------------------", 'color: #bada55');
                    console.log('%c ' + value, 'color: #9c9c9c');
                    clCount++;
                    __globals.__clogCount++;
                });
            });

            console.log("%c ------------------------------------------------------------ __clog " + clogType + " items end." + ' TotalCount: ' + __globals.__clogCount, 'color: #bada55');
        },
        /**
         * detect IE
         * returns version of IE or false, if browser is not Internet Explorer
         *
         */
        detectIE: function () {

            var ua = window.navigator.userAgent;

            // Test values; Uncomment to check result …

            // IE 10
            // ua = 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)';

            // IE 11
            // ua = 'Mozilla/5.0 (Windows NT 6.3; Trident/7.0; rv:11.0) like Gecko';

            // Edge 12 (Spartan)
            // ua = 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/39.0.2171.71 Safari/537.36 Edge/12.0';

            // Edge 13
            // ua = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/46.0.2486.0 Safari/537.36 Edge/13.10586';

            var msie = ua.indexOf('MSIE ');
            if (msie > 0) {
                // IE 10 or older => return version number
                return parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
            }

            var trident = ua.indexOf('Trident/');
            if (trident > 0) {
                // IE 11 => return version number
                var rv = ua.indexOf('rv:');
                return parseInt(ua.substring(rv + 3, ua.indexOf('.', rv)), 10);
            }

            var edge = ua.indexOf('Edge/');
            if (edge > 0) {
                // Edge (IE 12+) => return version number
                return parseInt(ua.substring(edge + 5, ua.indexOf('.', edge)), 10);
            }

            // other browser
            return false;
        },

        time: function (text) {
            if (window.appConfig && window.appConfig.debug && (__Utils.detectIE() >= 11 || __Utils.detectIE() == false)) {
                console.time(text);
                text = null;
            }
        },

        timeEnd: function (text) {
            if (window.appConfig && window.appConfig.debug && (__Utils.detectIE() >= 11 || __Utils.detectIE() == false)) {
                console.timeEnd(text);
                text = null;
            }
        },
        /**
        * Templating Modal
        * @param templateId string template identifer
        * @param responseCallback callback function should return values required for template
        * return void
        *-------------------------------------------------------- */
        modalTemplatize: function (templateId, responseCallback, closeCallback) {
            var $templateStructure = $(templateId),
                _thisDeferred = $.Deferred(),
                modalEvent = $templateStructure.data('modalEvent'),
                modalCloseEvent = $templateStructure.data('modalCloseEvent'),
                modalId = $templateStructure.data('modalId'),
                compiledTemplate = _.template($templateStructure.html()),
                replaceId = $templateStructure.data('replaceTarget');

            var callbackResponse = {};
            if (responseCallback) {
                $(modalId).on((modalEvent ? modalEvent : 'show') + '.bs.modal', function (e) {
                    var $templateStructure = $(templateId),
                        compiledTemplate = _.template($templateStructure.html()),
                        replaceId = $templateStructure.data('replaceTarget');
                    if (typeof responseCallback === 'function') {
                        callbackResponse = responseCallback(e, $(e.relatedTarget).data());
                        _thisDeferred.resolve(callbackResponse);
                    } else {
                        __Utils.error('responseCallback should be function');
                    }
                    //append rather than replace!
                    $(replaceId ? replaceId : 'modal-body').html(compiledTemplate(callbackResponse));
                });
            } else {
                _thisDeferred.resolve(callbackResponse);
            }

            if (closeCallback) {
                $(modalId).on((modalCloseEvent ? modalCloseEvent : 'hidden') + '.bs.modal', function (hiddenEvent) {
                    if (typeof closeCallback === 'function') {
                        closeCallback(hiddenEvent, callbackResponse);
                    } else {
                        __Utils.error('closeCallback should be function');
                    }
                });
            }
            $templateStructure = modalCloseEvent = modalId = compiledTemplate = replaceId = callbackResponse = null;
            return _thisDeferred.promise();
        },
        /**
         * Convert the query string to object
         */
        queryConvertToObject: function (queryStr) {
            if (_.isString(queryStr)) {
                var queryArr = (queryStr).replace('?', '&').split('&'),
                    queryParams = {};
                for (var q = 0, qArrLength = queryArr.length; q < qArrLength; q++) {
                    var qArr = queryArr[q].split('=');
                    queryParams[decodeURIComponent(qArr[0])] = decodeURIComponent(qArr[1]);
                }
                queryStr = queryArr = null;
                return queryParams;
            } else {
                return queryStr;
            }
        },

        viewReload: function () {
            location.reload();
        },

        /**
         * Underscore template compilation utility
         *
         * @param string {templateName} - html template identifier including (# for id or . for class)
         * @param object {dataObj}
         *
         * @return formatted html
         *-------------------------------------------------------- */

        template: function (templateName, dataObj) {
            var $templateHtml = $("script" + templateName).html();
            if ($templateHtml) {
                var _template = _.template($templateHtml);
                $templateHtml = templateName = null;
                return _template(dataObj);
            } else {
                return dataObj;
            }
        },

        /**
         * Get URL string based on Laravel Routes.
         *
         * @param  string/object route
         * @param  params object
         *
         * @return string
         *-------------------------------------------------------- */

        apiURL: function (route, params) {
            // Check if route is string
            if (_.isString(route)) {
                if (!_.isEmpty(params) && _.isObject(params)) {
                    _.forEach(params, function (value, key) {
                        route = route.replace(key, value);
                    });
                }
            } else {
                __Utils.error("__Utils:: Invalid API url");
            }
            params = null;
            return route;
        },

        /**
         * Get translate
         *
         * @param  string stringKey
         *
         * @return string
         *-------------------------------------------------------- */

        getTranslation: function (stringKey, fallBackString) {
            // Check if translation available
            if (__globals.translate_strings[stringKey]) {
                return __globals.translate_strings[stringKey]
            } else {
                return fallBackString ? fallBackString : stringKey;
            }
        },

        /**
         * Get translate
         *
         * @param  string stringKey
         *
         * @return string
         *-------------------------------------------------------- */
        setTranslation: function (stringKey, stringTranslation) {
            if (_.isObject(stringKey)) {
                __globals.translate_strings = _.assign(__globals.translate_strings, stringKey);
                stringKey = stringTranslation = null;
                return true;
            } else if (_.isString(stringKey) && stringTranslation) {
                __globals.translate_strings[stringKey] = stringTranslation;
                stringKey = stringTranslation = null;
                return true;
            }
            stringKey = stringTranslation = null;
            return false;
        },
        lwReInitPlugins: function ($responseTemplate) {
            var $reInit = $responseTemplate.find('[data-lw-plugin]');
            if ($reInit.length) {
                $.each($reInit, function (index, element) {
                    var $element = $(element);
                    window.lwPluginFuncs[$element.data('lw-plugin')]('[data-lw-plugin=' + $element.data('lw-plugin') + ']');
                });
            }
        },
        /**
         * Get localized number
         *
         * @param  number numberValue
         * @since 04 MAY 2022
         * @updated 19 DEC 2022
         * @return number
         *-------------------------------------------------------- */
        formatAsLocaleNumber: function (numberValue) {
            if (localeNumberFormat && _.isNumber(numberValue)) {
                return localeNumberFormat.format(numberValue);
            } else {
                return numberValue;
            }
        },
    };

    __globals['clog'] = __Utils.clog;

    window.__DataRequest = {
        __formValidateInit: function ($thisForm) {
            $thisForm.find('label.lw-validation-error').hide();
            $thisForm.validate({
                errorClass: "lw-validation-error",
                errorPlacement: function (error, element) {
                    var $element = $(element);
                    if ($('.lw-error-container-' + $element.prop('name')).length) {
                        $('.lw-error-container-' + $element.prop('name')).addClass('lw-validation-error').html(error).show();
                    } else if ($element.siblings('.input-group-prepend').length || $element.siblings('.input-group-append').length) {
                        error.insertAfter($element.parents('.input-group')).show();
                    } else if ($(element).parent().hasClass('selectize-input')) {
                        error.insertAfter($element.parents('.selectize-input')).show();
                    } else {
                        error.insertAfter(element).show();
                    }
                    $element = error = null;
                }

            });
            return $thisForm;
        },
        __processSubmitForm: function ($this, $thisForm) {
            $thisForm = __DataRequest.__formValidateInit($thisForm);
            if ($thisForm.valid()) {
                if ($thisForm.data('show-processing')) {
                    $thisForm.addClass('lw-form-in-process').prepend('<div class="lw-spinner-box"><div class="text-center align-middle"><div class="lds-ring"><div></div><div></div><div></div><div></div></div><div></div>');
                }

                if ($this.data('action')) {
                    $thisForm.attr('action', $this.data('action'));
                }

                __DataRequest.process($thisForm).then(function (responseData) {
                    if ($thisForm.data('show-processing')) {
                        var responseJSONData = responseData.responseJSON;
                        // don't remove the disabled attribute and form in process class if response is for redirect
                        if ((responseJSONData.reaction == 21) || (responseJSONData.response_action && (responseJSONData.response_action.type == 'redirect'))) {
                        } else {
                            $thisForm.removeClass('lw-form-has-errors').removeClass('lw-form-in-process').removeClass($thisForm.data('error-class')).find('.lw-spinner-box').remove();
                        }
                    }
                });
            } else {
                $thisForm.addClass('lw-form-has-errors').addClass($thisForm.data('error-class'));
                return false;
            }
        },
        process: function ($this) {
            var isFormRequest = $this.is('form'),
                requestMethod = $this.data('method') ? $this.data('method') : ($this.attr('method') ? $this.attr('method') :  ((isFormRequest === true) ? 'post' : 'get')),
                unsecuredFields = $this.data('unsecured-fields'),
                isSecuredForm = $this.data('secured'),
                requestURL = isFormRequest ? $this.attr('action') : ($this.data('action') ? $this.data('action') : $this.attr('href')),
                processFormFieldsOptions = {};
            if (unsecuredFields) {
                processFormFieldsOptions.unsecuredFields = unsecuredFields.split(',');
            }
            if (isSecuredForm == true) {
                var inputData = __InputSecurity.processFormFields(__Utils.queryConvertToObject(
                    (isFormRequest === true) ? $this.serialize() : $this.data('post-data')
                ), processFormFieldsOptions);
            } else {
                var inputData = (isFormRequest === true) ? $this.serialize() : $this.data('post-data');
            }

            var responseCallback = _.get(window, $this.data('callback')),
                optionsForRequest = {
                    thisScope: $this,
                };

            if (_.isUndefined(responseCallback)) {
                responseCallback = null;
            }
            // callback before form submit
            // it returns values are assigned to form inputs
            if ($this.data('pre-callback')) {
                optionsForRequest['preCallback'] = _.get(window, $this.data('pre-callback'))
            }
            // callback parameters
            optionsForRequest['callbackParams'] = null;
            // check it present
            if ($this.data('callback-params')) {
                optionsForRequest['callbackParams'] = $this.data('callbackParams');
            }

            if ($this.data('showMessage')) {
                optionsForRequest['showMessage'] = $this.data('showMessage')
            }
            optionsForRequest['responseTemplate'] = null;
            if ($this.data('responseTemplate')) {
                optionsForRequest['responseTemplate'] = $this.data('responseTemplate')
            }
            var returnRequest = __DataRequest.__protectedAjaxProcess(requestURL, inputData, responseCallback, requestMethod, optionsForRequest);
            isFormRequest = requestMethod = unsecuredFields = isSecuredForm = requestURL = processFormFieldsOptions = processFormFieldsOptions = inputData = responseCallback = optionsForRequest = null;
            return returnRequest;
        },

        /**
         * Post request
         */
        post: function (requestURL, inputData, responseCallback, options) {
            inputData = inputData ? inputData : {};
            responseCallback = responseCallback ? responseCallback : null;
            if (!options) {
                var options = {};
            }
            var unsecuredFields = options['unsecuredFields'] ? options['unsecuredFields'] : [],
                isSecuredRequest = options['secured'] ? options['secured'] : false,
                processFormFieldsOptions = {};
            if (unsecuredFields) {
                processFormFieldsOptions.unsecuredFields = unsecuredFields;
            }
            if (isSecuredRequest == true) {
                inputData = __InputSecurity.processFormFields(inputData, processFormFieldsOptions);
            }
            var returnRequest = __DataRequest.__protectedAjaxProcess(requestURL, inputData, responseCallback, 'post', options);
            requestURL = inputData = responseCallback = options = null;
            return returnRequest;
        },

        get: function (requestURL, inputData, responseCallback, options) {
            inputData = inputData ? inputData : {};
            responseCallback = responseCallback ? responseCallback : null;
            var returnRequest = __DataRequest.__protectedAjaxProcess(requestURL, inputData, responseCallback, 'get', options);
            requestURL = inputData = responseCallback = options = null;
            return returnRequest;
        },

        __protectedAjaxProcess: function (requestURL, inputData, responseCallback, requestMethod, options) {
            var _thisDeferred = $.Deferred();

            if (!options) {
                options = {};
            }

            inputData = __Utils.queryConvertToObject(inputData);

            options = _.assign({
                csrf: true,
                thisScope: $(this),
                preCallback: null,
                showMessage: false,
                /*
                useful for the nested key values serverside validations
                */
                'trimKeyName': null
            }, options);

            var headers = {};
            if (options.thisScope instanceof jQuery) {
                var $thisScope = options.thisScope;
            } else {
                var $thisScope = $(options.thisScope);
            }

            $thisScope.data('is-request-processing', true).addClass('lw-form-processing');;

            if (options.csrf === true) {
                headers['X-CSRF-TOKEN'] = appConfig.csrf_token;
            }

            if (options.preCallback && _.isFunction(options.preCallback)) {
                inputData = options.preCallback(inputData, $thisScope);
            }

            $.ajax({
                type: requestMethod ? requestMethod : 'get',
                // context: this,
                url: requestURL,
                dataType: "JSON",
                data: inputData ? inputData : {},
                headers: headers,
                error: function (errorResponse) {
                    $thisScope.prop('disabled', false).removeClass('disabled');
                    $thisScope.data('is-request-processing', false).removeClass('lw-form-processing');
                    _thisDeferred.resolve(errorResponse);
                    showErrorMessage(errorResponse.responseJSON && errorResponse.responseJSON.message ? errorResponse.responseJSON.message : (errorResponse.responseJSON && errorResponse.responseJSON.data && errorResponse.responseJSON.data.message ? errorResponse.responseJSON.data.message : 'Message not available'));
                    if (errorResponse.status === 422) {
                        $.each(errorResponse.responseJSON.errors, function (key, value) {
                            // Convert dots(.) to square brackets
                            var underscoreKey = key;
                            if (_.includes(key, '.')) {
                                underscoreKey = key.replace(/\.(.+?)(?=\.|$)/g, function (m, s) { return ("_" + s); });
                                key = key.replace(/\.(.+?)(?=\.|$)/g, function (m, s) { return ("[" + s + "]"); });
                                if (options.trimKeyName) {
                                    underscoreKey = underscoreKey.replace(options.trimKeyName, '');
                                }
                            }
                            if ($thisScope.find('#' + underscoreKey + '-error').length) {
                                $thisScope.find('#' + underscoreKey + '-error').text(value).show();
                            } else {
                                if ($('.lw-error-container-' + $thisScope.find('[name="' + key + '"]').prop('name')).length) {
                                    $('.lw-error-container-' + $thisScope.find('[name="' + key + '"]').prop('name')).addClass('lw-validation-error').html(value).show();
                                } else if ($thisScope.find('.input-group-prepend ~ [name="' + key + '"]').length || $thisScope.find('[name="' + key + '"] ~ .input-group-append').length) {
                                    $('<div id="' + underscoreKey + '-error" class="lw-validation-error">' + value + '</div>').insertAfter($thisScope.find('[name="' + key + '"]').parents('.input-group')).show();
                                } else if ($thisScope.find('div > [name="' + key + '"]').length) {
                                    $('<div id="' + underscoreKey + '-error" class="lw-validation-error">' + value + '</div>').insertAfter($($thisScope.find('[name="' + key + '"]')[0]).parent()).show();
                                } else if ($thisScope.find('[name="' + key + '"] ~ .selectize-control').length) {
                                    $('<div id="' + underscoreKey + '-error" class="lw-validation-error">' + value + '</div>').insertAfter($thisScope.find('[name="' + key + '"] ~ .selectize-control')).show();
                                } else {
                                    $('<div id="' + underscoreKey + '-error" class="lw-validation-error">' + value + '</div>').insertAfter($thisScope.find('[name="' + key + '"]')[0]).show();
                                }
                            }
                        });
                    } else {
                        if (errorResponse.responseJSON && !errorResponse.responseJSON.reaction) {
                            __Utils.displayInTabWindow(errorResponse.responseJSON);
                        }
                    }
                },
                beforeSend: function () {
                    if (options.responseTemplate) {
                        var $responseTemplate = $(options.responseTemplate),
                            $parentForm = $responseTemplate.parents('form.lw-form');
                        if ($parentForm.length) {
                            $parentForm.addClass('lw-form-processing');
                        }
                    }

                    $thisScope.prop('disabled', 'disabled').addClass('disabled');
                    // Handle the beforeSend event
                    __Utils.time("DataRequest." + requestMethod + ' ' + requestURL + ' ');
                },
                success: function (successResponse) {
                    successResponse = __InputSecurity.processResponseData(successResponse);
                    // check if the response template is present and reaction is 1
                    // if so forward data accordingly
                    if (options.responseTemplate && (successResponse.reaction == 1)) {
                        var $templateStructure = $('script' + options.responseTemplate + '-template'),
                            $responseTemplate = $(options.responseTemplate),
                            compiledTemplate = _.template($templateStructure.html());
                        $responseTemplate.html(compiledTemplate(successResponse.data));

                        if ($responseTemplate.find('.lw-file-uploader').length) {
                            window.initUploader();
                        }
                        // check if any function needs to call to initialize
                        __Utils.lwReInitPlugins($responseTemplate);
                        var $parentForm = $responseTemplate.parents('form.lw-form');
                        if ($parentForm.length) {
                            $parentForm.removeClass('lw-form-processing');
                        }
                    }
                    var showMessage = false;
                    if (successResponse.show_message || options.showMessage || (successResponse.data && successResponse.data.show_message)) {
                        showMessage = true;
                    }
                    if (window.__globals.default_show_message === true) {
                        if (successResponse.hide_message || options.hideMessage) {
                            showMessage = false;
                        } else {
                            showMessage = true;
                        }
                    }

                    if (successResponse.message && showMessage) {
                        if ((successResponse.reaction_code == 1) || (_.get(successResponse, 'messageType') === 'success')) {
                            showSuccessMessage(successResponse.message);
                        } else if ((successResponse.reaction_code == 14) || (_.get(successResponse, 'messageType') === 'warning')) {
                            showWarnMessage(successResponse.message);
                        } else {
                            showErrorMessage(successResponse.message);
                        }
                    } else {
                        if (successResponse.data && showMessage) {
                            var messageItem = successResponse.data.message ? successResponse.data.message : null;
                            if (messageItem) {
                                if ((successResponse.reaction == 1) || (_.get(successResponse, 'data.messageType') === 'success')) {
                                    showSuccessMessage(messageItem);
                                } else if ((successResponse.reaction == 14) || (_.get(successResponse, 'data.messageType') === 'warning')) {
                                    showWarnMessage(messageItem);
                                } else {
                                    showErrorMessage(messageItem);
                                }
                            }

                        }
                    }
                    if (successResponse.data && successResponse['client_models'] && !_.isEmpty(successResponse['client_models'])) {
                        __DataRequest.updateModels(successResponse['client_models']);
                    }
                    if (successResponse.data && successResponse.data.errors) {
                        $.each(successResponse.data.errors, function (key, value) {

                            // Convert dots(.) to square brackets
                            var underscoreKey = key;
                            if (_.includes(key, '.')) {
                                underscoreKey = key.replace(/\.(.+?)(?=\.|$)/g, function (m, s) { return ("_" + s); });
                                key = key.replace(/\.(.+?)(?=\.|$)/g, function (m, s) { return ("[" + s + "]"); });
                                if (options.trimKeyName) {
                                    underscoreKey = underscoreKey.replace(options.trimKeyName, '');
                                }
                            }

                            if ($thisScope.find('#' + underscoreKey + '-error').length) {
                                $thisScope.find('#' + underscoreKey + '-error').text(value).show();
                            } else {
                                if ($('.lw-error-container-' + $thisScope.find('[name="' + key + '"]').prop('name')).length) {
                                    $('.lw-error-container-' + $thisScope.find('[name="' + key + '"]').prop('name')).addClass('lw-validation-error').html(value).show();
                                } else if ($thisScope.find('.input-group-prepend ~ [name="' + key + '"]').length || $thisScope.find('[name="' + key + '"] ~ .input-group-append').length) {
                                    $('<div id="' + underscoreKey + '-error" class="lw-validation-error">' + value + '</div>').insertAfter($thisScope.find('[name="' + key + '"]').parents('.input-group')).show();
                                } else if ($thisScope.find('div > [name="' + key + '"]').length) {
                                    $('<div id="' + underscoreKey + '-error" class="lw-validation-error">' + value + '</div>').insertAfter($($thisScope.find('[name="' + key + '"]')[0]).parent()).show();
                                } else if ($thisScope.find('[name="' + key + '"] ~ .selectize-control').length) {
                                    $('<div id="' + underscoreKey + '-error" class="lw-validation-error">' + value + '</div>').insertAfter($thisScope.find('[name="' + key + '"] ~ .selectize-control')).show();
                                } else {
                                    $('<div id="' + underscoreKey + '-error" class="lw-validation-error">' + value + '</div>').insertAfter($thisScope.find('[name="' + key + '"]')[0]).show();
                                }
                            }
                        });
                    }

                    //check if redirect reaction and redirect when url is present
                    if (successResponse.reaction == 21) {
                        if (_.has(successResponse.data, 'reloadPage') && (successResponse.data.reloadPage === true)) {
                            _.delay(function () {
                                __Utils.viewReload();
                            }, 500);
                        } else if (_.has(successResponse.data, 'redirectUrl')) {
                            window.location = successResponse.data.redirectUrl;
                        } else if (_.has(successResponse.data, 'redirect_to')) {
                            window.location = successResponse.data.redirect_to;
                        }
                    }
                    if (responseCallback && typeof responseCallback === 'function') {
                        responseCallback(successResponse, options.callbackParams, $thisScope);
                    }

                    if (successResponse.response_action) {
                        if (successResponse.response_action.type === 'redirect') {
                            if (window['CURRENT_PAGE_URL'] && successResponse.response_action.url === window['CURRENT_PAGE_URL']) {
                                window.location.reload();
                            } else {
                                window.location = successResponse.response_action.url;
                            }
                        } else if (successResponse.response_action.type === 'replace') {
                            $(successResponse.response_action.target).html(
                                successResponse.response_action.content
                            );
                            // change the browser url and window title etc.
                            if ($thisScope.hasClass('lw-action-with-url')) {
                                /*
                                if needed ad following block to your project if you want to back and forward button should work
                                // as state is set programmatically we needs to force back button work.
                                $(window).on('popstate', function(event) {
                                    location.reload();
                                });
                                */
                                // set the window title
                                document.title = $thisScope.data('title') ? $thisScope.data('title').trim() : $thisScope.text().trim();
                                // set the url
                                window.history.pushState(successResponse, "", requestURL);
                                // Trigger the event. Do not use dot in name
                                $(document).trigger('lw_events_ajax_success_replace',  {
                                    response: successResponse,
                                    scopeElement:$thisScope
                                });
                                var urlHashValue = (requestURL ? new URL(requestURL).hash : '').trim();
                                $('html, body').stop().animate({
                                    scrollTop: ($(urlHashValue ? urlHashValue : 'body').offset().top)
                                }, 500, 'easeInOutExpo');
                            }
                        }
                    }
                     // Trigger the event. Do not use dot in name
                    // if set at the link (data-event-callback) level
                    if ($thisScope.data('eventCallback')) {
                        $(document).trigger($thisScope.data('eventCallback'),  {
                            response: successResponse,
                            scopeElement:$thisScope
                        });
                    }
                    // Trigger the event. Do not use dot in name
                    $(document).trigger('lw_events_ajax_success',  {
                        response: successResponse,
                        scopeElement:$thisScope
                    });
                    successResponse = null;
                },
                complete: function (requestResponse) {
                    // note: __pr not working here use console.log
                    var responseData = __InputSecurity.processResponseData(requestResponse.responseJSON);
                    _thisDeferred.resolve(_.assign(requestResponse, {
                        responseJSON: responseData
                    }));
                    // don't remove the disabled attribute and form in process class if response is for redirect
                    if ((responseData.reaction == 21) || (responseData.response_action && (responseData.response_action.type == 'redirect'))) {
                    } else {
                        $thisScope.prop('disabled', false).removeClass('disabled');
                        $thisScope.data('is-request-processing', false).removeClass('lw-form-processing');
                    }
                    __Utils.timeEnd("DataRequest." + requestMethod + ' ' + requestURL + ' ');
                    // open email debug view if available
                    if (responseData && responseData.__emailDebugView) {
                        __Utils.openEmailDebugView(responseData.__emailDebugView);
                    }
                    // check if __dd is performed
                    if (responseData && responseData.__dd) {
                        __Utils.jsdd(responseData);
                    }
                    requestResponse = null;
                }
            });
            return _thisDeferred.promise();
        },
        updateModels: function (scopeName, dataObject) {
            if (scopeName && _.isObject(scopeName)) {
                dataObject = scopeName;
                scopeName = '';
            } else if (!scopeName || !_.isString(scopeName)) {
                scopeName = '';
            } else {
                scopeName = scopeName + '.';
            }
            if (dataObject && !_.isObject(dataObject)) {
                __Utils.error('dataObject should be present as object');
            }
            // get the alpineJS js data models
            var alpineXDataElements = document.querySelectorAll('[x-data]'),
                sizeOfDataObject = _.size(dataObject),
                countIndex = 1;
            // go through each item
            for (var key in dataObject) {
                if (dataObject && dataObject.hasOwnProperty(key)) {
                    var element = dataObject[key];
                    // alpineJS data models update
                    // it should be in object form
                    if (alpineXDataElements.length) {
                        _.each(alpineXDataElements, function (el) {
                            // AlpineJs version 3 compatible - 05 JUL 2021
                            if (el._x_dataStack && el._x_dataStack[0] && (!_.isUndefined(el._x_dataStack[0][scopeName + key]))) {
                                el._x_dataStack[0][scopeName + key] = element;
                            }
                            if (countIndex === sizeOfDataObject) {
                                // check if any function needs to call to initialize
                                _.delay(function () {
                                    var $lwPlugins = $('[data-lw-plugin-on-model-update]');
                                    if ($lwPlugins.length) {
                                        $.each($lwPlugins, function (index, element) {
                                            var $element = $(element);
                                            window.lwPluginFuncs[$element.data('lw-plugin-on-model-update')]('[data-lw-plugin-on-model-update=' + $element.data('lw-plugin-on-model-update') + ']');
                                        });
                                    }
                                }, 500);
                            }
                            countIndex++;
                        });
                    }
                    // alpineJS models update end
                    var $elements = $.find('[data-model="' + scopeName + key + '"]');
                    if ($elements.length) {
                        $.each($elements, function (index, elementItem) {
                            var $elementItem = $(elementItem);
                            if ($elementItem.is('input:radio') || $elementItem.is('input:checkbox')) {
                                if (element && ($elementItem.val() == element)) {
                                    $elementItem.prop('checked', true);
                                } else {
                                    $elementItem.prop('checked', false);
                                }
                            } else if ($elementItem.is('input') || $elementItem.is('select')) {
                                $elementItem.val(element);
                            } else {
                                $elementItem.text(element);
                            }
                            $elementItem = null;
                        });
                    }
                    var $htmlElements = $.find('[data-model-html="' + scopeName + key + '"]');
                    if ($htmlElements.length) {
                        $.each($htmlElements, function (index, elementItem) {
                            var $htmlElementItem = $(elementItem);
                            $htmlElementItem.html(element);
                            $htmlElementItem = null;
                        });
                    }
                    // show element if
                    var $ifShowHtmlElements = $.find('[data-show-if="' + scopeName + key + '"]');
                    if ($ifShowHtmlElements.length) {
                        $.each($ifShowHtmlElements, function (index, elementItem) {
                            var $ifShowHtmlElementItem = $(elementItem),
                                evalElement = _.get(window, element);
                            if (!evalElement) {
                                evalElement = element;
                            }
                            if (evalElement) {
                                $ifShowHtmlElementItem.show();
                            } else {
                                $ifShowHtmlElementItem.hide();
                            }
                            $ifShowHtmlElementItem = null;
                        });
                    }
                    $elements = $htmlElements = $ifShowHtmlElements = element = null;
                }
            }
            scopeName = dataObject = null;
        }
    };

    /*----------------------DIRECT GLOBALS ---------------------------------------------------------------------------------- */
    /**
    * Dump and die
    * @param n number of parameters
    *
    * return void
    *-------------------------------------------------------- */
    window.__dd = function (arg1, arg2) {

        if (window.appConfig && window.appConfig.debug) {

            console.error("JS __dd --------------------------------------------------");

            var args = Array.prototype.slice.call(arguments);

            for (var i = 0; i < args.length; ++i) {
                console.debug(args[i]);
            }

            throw new Error("-------------------------------------------------- JS __dd END");
        }
    }

    /**
    * Print data
    * @param n number of parameters
    *
    * return void
    *-------------------------------------------------------- */
    window.__pr = function () {

        if (window.appConfig && window.appConfig.debug) {

            console.info("JS __pr --------------------------------------------------");

            var args = Array.prototype.slice.call(arguments);

            for (var i = 0; i < args.length; ++i) {
                console.debug(args[i]);
            }

            console.groupCollapsed("-------------------------------------------------- JS __pr END");
            console.trace();
            console.groupEnd();
        }
    }

    /*
    * for handling cookies
    */
    window.__Cookie = {

        set: function (cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toUTCString();
            document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
        },
        get: function (cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                    c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
    }

    /**
     * Create JSON string so it can be sent via data parameters
     */
    window.toJsonString = function (params) {
        return JSON.stringify(params);
    }

    /**
      * Ajax form submission based on form submit
      *
      *-------------------------------------------------------- */
    // bind submit event for the form
    $('body').on('submit', 'form.lw-ajax-form', function (e) {
        e.preventDefault();
        var $this = $(e.target),
            $thisForm = $(this),
            confirmMessage = $thisForm.data('confirm'),
            options = $thisForm.data('confirm-options'),
            confirmParams = $thisForm.data('confirm-params');
        if (confirmMessage) {
            showConfirmation(confirmMessage, function () {
                var returnRequest = __DataRequest.__processSubmitForm($this, $thisForm);
                $this = $thisForm = null;
                confirmMessage = options = confirmParams = null;
                return returnRequest;
            }, options ? options : {}, confirmParams ? confirmParams : {});
        } else {
            var returnRequest = __DataRequest.__processSubmitForm($this, $thisForm);
            $this = $thisForm = null;
            confirmMessage = options = confirmParams = null;
            return returnRequest;
        }
    });
    /**
     * Ajax form submission based on form on change
     *
     *-------------------------------------------------------- */
    $('body').on('change', 'form.lw-ajax-form[lwSubmitOnChange]', function (e) {
        e.preventDefault();
        var $this = $(e.target),
            $thisForm = $(this);
        var returnRequest = __DataRequest.__processSubmitForm($this, $thisForm);
        $this = $thisForm = null;
        return returnRequest;
    });

    // enable for pointer events
    $('body').addClass('lw-ajax-form-ready');

    /**
      * Ajax form submission based on click
      *
      *-------------------------------------------------------- */
    $('body').on('click', '.lw-ajax-form-submit-action', function (e) {
        e.preventDefault();
        var $this = $(this),
            $thisForm = $this.parents('form');
        var returnRequest = __DataRequest.__processSubmitForm($this, $thisForm);
        $this = $thisForm = null;
        return returnRequest;
    });

    /**
    * Ajax form submission based on click
    *
    *-------------------------------------------------------- */
    $('body').on('click', '.lw-ajax-link-action', function (e) {
        e.preventDefault();
        var $this = $(this),
            confirmMessage = $this.data('confirm'),
            options = $this.data('confirm-options'),
            confirmParams = $this.data('confirm-params');
        if (confirmMessage) {
            showConfirmation(confirmMessage, function () {
                confirmMessage = options = confirmParams = null;
                return __DataRequest.process($this);
            }, options ? options : {}, confirmParams ? confirmParams : {});
        } else {
            confirmMessage = options = confirmParams = null;
            return __DataRequest.process($this);
        }
    });

    /**
    * Ajax form submission based on click
    * @deprecated 22 JUN 2021 instead use .lw-ajax-link-action with data-confirm attribute
    *-------------------------------------------------------- */
    $('body').on('click', '.lw-ajax-link-action-via-confirm', function (e) {
        e.preventDefault();
        var $this = $(this),
            confirmMessage = $this.data('confirm'),
            options = $this.data('confirm-options'),
            confirmParams = $this.data('confirm-params');
        if (confirmMessage) {
            showConfirmation(confirmMessage, function () {
                return __DataRequest.process($this);
            }, options ? options : {}, confirmParams ? confirmParams : {});
        }
        confirmMessage = options = confirmParams = null;
    });
    /*
    Init clint side form validations
    */
    $('form.lw-ajax-form').each(function () {
        __DataRequest.__formValidateInit($(this));
    });
})(window);