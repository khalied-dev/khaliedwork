// tasks

function dt_custom_view_task(e, t, a, i) {
    var n = void 0 === a ? "custom_view" : a;
    if (void 0 !== i) {
        var s = $("._filter_data li.active");
        s.removeClass("active"),
            $.each(s, (function () {
                var e = $(this).find("a").attr("data-cview");
                $('._filters input[name="' + e + '"]').val("")
            }
            ))
    }
    do_filter_active(n) != n && (e = ""),
        $('input[name="' + n + '"]').val(e),
        $(t).DataTable().ajax.reload()
}