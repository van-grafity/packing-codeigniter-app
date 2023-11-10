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



// async function using_fetch(url = "", data = {}, method = "GET") {

//     let fetch_data = {
//         mode: "cors",
//         cache: "no-cache",
//         credentials: "same-origin",
//         redirect: "follow",
//         referrerPolicy: "no-referrer",
//     };

//     if (method === "GET") {
//         query_string = new URLSearchParams(data).toString();
//         url = url + "?" + query_string

//         fetch_data.method = method;
//         fetch_data.headers = {
//             "Content-Type": "application/json",
//         };
//     }

//     if (method === "DELETE") {
//         fetch_data.method = method;
//         fetch_data.headers = {
//             "Content-Type": "application/json",
//             "X-CSRF-TOKEN": data.token,
//         };
//     }

//     if (method === "PUT") {
//         fetch_data.method = method;
//         fetch_data.headers = {
//             "Content-Type": "application/json",
//             "X-CSRF-TOKEN": data.token,
//         };

//         fetch_data.body = JSON.stringify(data.body);
//     }

//     if (method === "POST") {
//         fetch_data.method = method;
//         fetch_data.headers = {
//             "Content-Type": "application/json",
//             "X-CSRF-TOKEN": data.token,
//         };

//         fetch_data.body = JSON.stringify(data.body);
//         console.log(fetch_data);
//     }

//     const response = await fetch(url, fetch_data);
//     return response.json();
// }


// async function using_fetch(url = "", data = {}, method = "GET", token = null) {
//     let fetch_data = {
//         method: method,
//         headers: {
//             "Content-Type": "application/json",
//         },
//         mode: "cors",
//         cache: "no-cache",
//         credentials: "same-origin",
//         redirect: "follow",
//         referrerPolicy: "no-referrer",
//     };

//     if (method === "GET") {
//         const query_string = new URLSearchParams(data).toString();
//         url = url + "?" + query_string;
//     }

//     if (method === "DELETE" || method === "PUT" || method === "POST") {
//         fetch_data.headers["X-CSRF-TOKEN"] = token;
//     }

//     if (method === "PUT" || method === "POST") {
//         fetch_data.body = JSON.stringify(data);
//     }

//     const response = await fetch(url, fetch_data);
//     return response.json();
// }


async function using_fetch(url = "", data = {}, method = "GET", token = null) {
    const headers = {
        "Content-Type": "application/json",
    };

    const fetch_data = {
        method,
        headers,
        mode: "cors",
        cache: "no-cache",
        credentials: "same-origin",
        redirect: "follow",
        referrerPolicy: "no-referrer",
    };

    if (method === "GET") {
        const query_string = new URLSearchParams(data).toString();
        url = `${url}?${query_string}`;
    }

    if (["DELETE", "PUT", "POST"].includes(method)) {
        headers["X-CSRF-TOKEN"] = token;
    }

    if (["PUT", "POST"].includes(method)) {
        fetch_data.body = JSON.stringify(data);
    }

    try {
        const response = await fetch(url, fetch_data);

        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }

        return response.json();
    } catch (error) {
        console.error("Fetch error:", error);
        throw error;
    }
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

const swal_info = (data = { title: "Success", reload_option: false }) => {
    const afterClose = () => {
        if (data.reload_option == true) {
            location.reload();
        } else {
            return false;
        }
    }
    Swal.fire({
        icon: "success",
        title: data.title,
        showConfirmButton: false,
        timer: 2000,
        didClose: afterClose,
    });
};

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

const avoid_submit_on_enter = () => {
    $(window).keydown(function (event) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
    });
}

const swal_confirm = (data = {}) => {
    const swalComponent = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-primary m-2",
            cancelButton: "btn btn-secondary m-2",
        },
        buttonsStyling: false,
    });

    let title = data.title ? data.title : "Are you sure?";
    let confirm_button = data.confirm_button ? data.confirm_button : "Save";
    let success_message = data.success_message
        ? data.success_message
        : "Success!";
    let failed_message = data.failed_message
        ? data.failed_message
        : "Cancel Action";

    return new Promise((resolve, reject) => {
        swalComponent
            .fire({
                title: title,
                text: data.text,
                confirmButtonText: confirm_button,
                icon: "question",
                showCancelButton: true,
                reverseButtons: true,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    resolve(true);
                }
                resolve(false);
            })
            .catch((error) => {
                reject(error);
            });
    });
}

const update_row_numbers = (options) => {
    const { table_id, target_column_index = 0, footer_option = true } = options
    let table = document.getElementById(table_id);
    let rows = table.getElementsByTagName("tr");
    let rows_length = footer_option ? rows.length - 1 : rows.length;

    for (let i = 1; i < rows_length; i++) {
        let cells = rows[i].getElementsByTagName("td");
        if (cells.length > target_column_index) {
            cells[target_column_index].innerText = i;
        }
    }
}