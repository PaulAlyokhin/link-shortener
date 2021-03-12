let url = document.getElementById('url');
let link = document.getElementById('link');

/**
 * @return {boolean}
 */
function GetData(ajaxurl) { // Получение данных из БД через AJAX
    let result = false;
    let request = new XMLHttpRequest();
    request.open('GET', ajaxurl, false);  // `false` делает запрос синхронным
    request.send(null);
    if(request.status === 200) {
        result = request.responseText;
    }
    return result;
}

/**
 * @return {boolean}
 */
function FormSubmit() {
    let query = "index.php?url=" + url.value;
    let result = GetData(query);

    if(result !== false) {
        result = JSON.parse(result);
        link.innerHTML = "<a href='" + result.link + "' target='_blank'>" + result.link + "</a>";
    }
    else {
        link.innerText = "При выполнении запроса произошла ошибка";
    }

    return false;
}