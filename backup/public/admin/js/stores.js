$(function () {});

const store_status_change = (id, status) => {
    $.ajax({
        url: baseUrl + "/stores/status",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        method: "post",
        data: {
            store_id: id,
            status: status,
        },
        success: function (res) {
            console.log("success:", res, res);
            if (res.status) {
                location.reload();
            }
        },
        error: function (err) {
            console.log(err);
        },
    });
};
