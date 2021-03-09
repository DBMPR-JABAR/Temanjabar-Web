console.log("Hollaa");

function setDataSelect(id, url, id_select, text, valueOption, textOption) {
    $.ajax({
        url: url,
        method: "get",
        dataType: "JSON",
        data: {
            id: id,
        },
        complete: function (result) {
            console.log(result.responseJSON);
            $(id_select).empty(); // remove old options
            $(id_select).append($("<option disable></option>").text(text));

            result.responseJSON.forEach(function (item) {
                $(id_select).append(
                    $("<option></option>")
                        .attr("value", item[valueOption])
                        .text(item[textOption])
                );
            });
        },
    });
}
document.addEventListener("DOMContentLoaded", function () {
    const ele = document.getElementById("dttable");
    ele.style.cursor = "grab";

    let pos = { top: 0, left: 0, x: 0, y: 0 };

    const mouseDownHandler = function (e) {
        ele.style.cursor = "grabbing";
        ele.style.userSelect = "none";

        pos = {
            left: ele.scrollLeft,
            top: ele.scrollTop,
            // Get the current mouse position
            x: e.clientX,
            y: e.clientY,
        };

        document.addEventListener("mousemove", mouseMoveHandler);
        document.addEventListener("mouseup", mouseUpHandler);
    };

    const mouseMoveHandler = function (e) {
        // How far the mouse has been moved
        const dx = e.clientX - pos.x;
        const dy = e.clientY - pos.y;
        const xa = document.getElementsByClassName("dt-responsive")[0];

        // Scroll the element
        xa.scrollTop = pos.top - dy;
        xa.scrollLeft = pos.left - dx;
    };

    const mouseUpHandler = function () {
        ele.style.cursor = "grab";
        ele.style.removeProperty("user-select");

        document.removeEventListener("mousemove", mouseMoveHandler);
        document.removeEventListener("mouseup", mouseUpHandler);
    };

    // Attach the handler
    ele.addEventListener("mousedown", mouseDownHandler);
});
