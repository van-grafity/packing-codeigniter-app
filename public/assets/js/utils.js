const clear_form = (data) => {
    /*
        * --------------------------------------------------------------------
        * Params Example
        * --------------------------------------------------------------------
        data = {
            element_id : 'packinglist_modal',
            title: "Add Product",
            btn_submit: "Add Product",
        };
        * --------------------------------------------------------------------
    */

    $(`#${data.modal_id} .modal-title`).text(data.modal_title);
    $(`#${data.modal_id} .btn-submit`).text(data.modal_btn_submit);
    $(`#${data.modal_id} form`).attr(`action`, data.form_action_url);
    $(`#${data.modal_id} form`).find("input[type=text], input[type=number], textarea").val("");
    $(`#${data.modal_id} form`).find(`select`).val("").trigger(`change`);
}



async function using_fetch(url = "", data = {}, method = "GET") {

    let fetch_data = {
        mode: "cors",
        cache: "no-cache",
        credentials: "same-origin",
        redirect: "follow",
        referrerPolicy: "no-referrer",
    };

    if (method === "GET") {
        query_string = new URLSearchParams(data).toString();
        url = url + "?" + query_string

        fetch_data.method = method;
        fetch_data.headers = {
            "Content-Type": "application/json",
        };
    }

    if (method === "DELETE") {
        fetch_data.method = method;
        fetch_data.headers = {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": data.token,
        };
    }

    if (method === "PUT") {
        fetch_data.method = method;
        fetch_data.headers = {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": data.token,
        };

        fetch_data.body = JSON.stringify(data.body);
    }

    if (method === "POST") {
        fetch_data.method = method;
        fetch_data.headers = {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": data.token,
        };

        fetch_data.body = JSON.stringify(data.body);
    }

    const response = await fetch(url, fetch_data);
    return response.json();
}