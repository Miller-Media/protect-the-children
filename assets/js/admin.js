PROTECT_THE_CHILDREN = {} || PROTECT_THE_CHILDREN;

PROTECT_THE_CHILDREN = {
    _init: function () {
        PROTECT_THE_CHILDREN.onChange();
    },

    onChange: function () {

        jQuery('div#post-visibility-select input[type="radio"]').on('change', function () {
            PROTECT_THE_CHILDREN.showOption(jQuery(this).val());
        });

    },

    showOption: function (option_value) {

        if (option_value == "password" && jQuery('div#protect-children-div').length == 0)
            jQuery('div.misc-pub-curtime').after('<div id="protect-children-div"><input type="checkbox" name="protect-children" /><strong>Password Protect</strong> all child posts</div>');

        if (option_value != "password" && jQuery('div#protect-children-div').length > 0)
            jQuery('div#protect-children-div').remove();

    }
};

jQuery(document).ready(function () {

    PROTECT_THE_CHILDREN._init();

});