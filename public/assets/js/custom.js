console.log("Hollaa")

function setDataSelect(id, url, id_select, text, valueOption, textOption) {

    $.ajax({
        url: url,
        method: 'get',
        dataType: 'JSON',
        data: {
            id: id
        },
        complete: function(result) {
            console.log(result.responseJSON)
            $(id_select).empty(); // remove old options
            $(id_select).append($("<option disable></option>").text(text));

            result.responseJSON.forEach(function(item) {
                $(id_select).append($("<option></option>").attr("value", item[valueOption]).text(item[textOption]));
            });
        }
    });
}