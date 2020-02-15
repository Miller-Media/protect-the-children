/**
 * This code is for non-gutenberg editor
 */

PROTECT_THE_CHILDREN = {} || PROTECT_THE_CHILDREN;

PROTECT_THE_CHILDREN = {

    _init: function () {
        PROTECT_THE_CHILDREN.onChange();
    },

    // detect changes to the edit visibility button
    onChange: function () {
        jQuery('.edit-post-post-visibility .edit-post-post-visibility__toggle').on('click', function () {      
            PROTECT_THE_CHILDREN.onVisibilityPopupDisplay();
        });

        // wp 5.2.3
        jQuery('.misc-pub-visibility .edit-visibility').on('click', function () {
            PROTECT_THE_CHILDREN.onVisibilityPopupDisplay();
        });

    },

    // detect changes to the radio buttons
    onVisibilityPopupDisplay: function () {

        jQuery('.editor-post-visibility__choice input[type="radio"]').on('change', function () {
            PROTECT_THE_CHILDREN.showOption(jQuery(this).val());
        });

        // wp 5.2.3
        jQuery('#post-visibility-select input[type="radio"]').on('change', function () {
            PROTECT_THE_CHILDREN.showOption(jQuery(this).val());
        });

    },

    // add or remove the ptc checkbox depending on the option chosen
    showOption: function (option_value) {

        var extra_field = '<div id="protect-children-div"><input type="checkbox" name="protect_children" /><strong>Password Protect</strong> all child posts</div>'

        if (option_value == "password" && jQuery('div#protect-children-div').length == 0) {
            jQuery('#editor-post-visibility__dialog-password-input-0').after( extra_field );

            // wp 5.2.3
            jQuery('#post_password').after( extra_field );
        }

        if (option_value != "password" && jQuery('div#protect-children-div').length > 0) {
            jQuery('div#protect-children-div').remove();
        }

    }
};

jQuery(document).ready(function () {

    PROTECT_THE_CHILDREN._init();

});
