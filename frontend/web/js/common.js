/**
 * Объект общих функций.
 * @type {{}}
 */
var sgkh = {};

/**
 * Действия во время начала/концы ajax запроса
 * @param end string - конец ли это запроса ('end') или начало (не устанавливать в начале запроса)
 */
sgkh.ajaxWait = function (end) {
    if (end == 'end') {
        $("body").css("cursor", "default");
    } else {
        $("body").css("cursor", "progress");
    }
};
