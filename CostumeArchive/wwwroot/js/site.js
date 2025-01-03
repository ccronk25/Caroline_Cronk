// Please see documentation at https://learn.microsoft.com/aspnet/core/client-side/bundling-and-minification
// for details on configuring this project to bundle and minify static web assets.

const { hide } = require("@popperjs/core");

// Write your JavaScript code.

/*-----------------------------*/
/*SOURCE: https://www.w3schools.com/howto/howto_js_dropdown.asp */
/*-----------------------------*/

//https://stackoverflow.com/questions/45892510/getelementby-only-works-with-id-not-with-classes
//https://www.w3schools.com/js/js_loop_for.asp
function showPermissions() {
    const permissions = document.getElementsByClassName('permissions');
    if (permissions[0].style.display === 'none') {
        //show
        document.getElementById('users').className = "users";
        for (let i = 0; i < permissions.length; i++) {
            permissions[i].style.display = 'inline';
        }
    }
    else {
        //hide
        document.getElementById('users').className = "users-collapsed";
        for (let i = 0; i < permissions.length; i++) {
            permissions[i].style.display = 'none';
        }
    }
}

/*-----------------------------*/
/*SOURCE:https://stackoverflow.com/questions/16683176/add-two-functions-to-window-onload */
window.addEventListener("load", function () { showPermissions(); }, false);
window.addEventListener("load", function() { showList(document.getElementById('shareUsername')); }, false);
/*-----------------------------*/

/**----------------------------*
 * SOURCE: https://stackoverflow.com/questions/53423058/hide-datalist-options-when-user-starts-typing
 * @param {any} the text form input it is being called on
 /*-----------------------------*/
function showList(input) {
    var datalist = document.querySelector("datalist");
    if (input.value) {
        datalist.id = "usersList";
    } else {
        datalist.id = "";
    }
}

