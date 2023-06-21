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


const show_flash_message = (session = {}) => {
    if ("success" in session) {
        Swal.fire({
            icon: "success",
            title: session.success,
            showConfirmButton: false,
            timer: 3000,
        });
    }
    if ("error" in session) {
        Swal.fire({
            icon: "error",
            title: session.error,
            confirmButtonColor: "#007bff",
        });
    }
}

const swal_failed = (data) => {
    Swal.fire({
        icon: "error",
        title: data.title ? data.title : "Something Error",
        text: 'Please contact the Administrator',
        showConfirmButton: true,
    });
}

const swal_warning = (data) => {
    Swal.fire({
        icon: "warning",
        title: data.title ? data.title : "Caution!",
        text: data.text ? data.text : null,
        showConfirmButton: true,
    });
}