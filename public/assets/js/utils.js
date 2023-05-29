const clear_form = ( data ) => {  
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

    $(`#${data.modal_id} .modal-title`).text( data.modal_title );
    $(`#${data.modal_id} .btn-submit`).text( data.modal_btn_submit );
    $(`#${data.modal_id} form`).attr(`action`, data.form_action_url );
    $(`#${data.modal_id} form`).find("input[type=text], input[type=number], textarea").val("");
    $(`#${data.modal_id} form`).find(`select`).val("").trigger(`change`);
}