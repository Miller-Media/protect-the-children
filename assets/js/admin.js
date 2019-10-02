/**
 * This code is for non-gutenberg editor
 * 
 */

PROTECT_THE_CHILDREN = {} || PROTECT_THE_CHILDREN;

PROTECT_THE_CHILDREN = {
    _init: function () {
        PROTECT_THE_CHILDREN.onChange();
    },

    onChange: function () {

        jQuery('.edit-post-post-visibility .edit-post-post-visibility__toggle').on('click', function () {
            PROTECT_THE_CHILDREN.onVisibilityPopupDisplay();
        });

    },

    onVisibilityPopupDisplay: function () {

        jQuery('.editor-post-visibility__choice input[type="radio"]').on('change', function () {
            PROTECT_THE_CHILDREN.showOption(jQuery(this).val());
        });

    },
    showOption: function (option_value) {

        if (option_value == "password" && jQuery('div#protect-children-div').length == 0)
            jQuery('#editor-post-visibility__dialog-password-input-0').after('<div id="protect-children-div"><input type="checkbox" name="protect_children" /><strong>Password Protect</strong> all child posts</div>');

        if (option_value != "password" && jQuery('div#protect-children-div').length > 0)
            jQuery('div#protect-children-div').remove();

    }
};

