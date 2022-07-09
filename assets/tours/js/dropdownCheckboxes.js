(function($) {
    var dropdownMethods = {
        init: function(options) {
            $(this).find(".dropdown-menu li").click(function(e) {
                e.stopPropagation()
            });
            var dropdowns = $(this);
            dropdowns.each(function(i) {
                var dropdown = $(this);
                dropdown.addClass("dropdownCheckboxes");
                dropdown.data("default-label", dropdown.find(".dropdown-toggle").html().trim());
                dropdown.append($("<input/>", {
                    type: "hidden",
                    class: "hidden-input",
                    name: dropdown.data("name"),
                    value: ""
                }));
                dropdown.find("input[type=checkbox]").click(function() {
                    $(this).dropdownCheckboxes("eval")
                });
                dropdown.find("button.save").click(function() {
                    $(this).dropdownCheckboxes("eval")
                });
                dropdown.find("button.clear").click(function() {
                    $(this).closest(".dropdownCheckboxes").find("input[type=checkbox]").prop("checked", false);
                    $(this).dropdownCheckboxes("eval")
                });
                dropdown.dropdownCheckboxes("eval")
            });
            return this
        },
        eval: function() {
            if ($(this).hasClass("dropdownCheckboxes")) {
                var container = $(this)
            } else {
                var container = $(this).closest(".dropdownCheckboxes")
            }
            var labels = [];
            var values = [];
            let counterLimit    = 3;
            container.find("input[type=checkbox]:checked").each(function(ind,val) {
                if(ind < counterLimit){
                    labels.push($(this).closest("label").text().trim());
                    values.push($(this).val())
                }else{
                    $(this).prop('checked',false);
                }
            });
            if (values.length > 200) {
                container.find(".dropdown-toggle").html(labels.length + " selected")
            } else if (values.length > 0) {
                container.find(".dropdown-toggle").html(labels.join(", "))
            } else {
                container.find(".dropdown-toggle").html(container.data("default-label"))
            }
            container.find("input.hidden-input").val(JSON.stringify(values));
            //custom function by gaurav 
            changeCountry();
            if ($(this).hasClass("save") || $(this).hasClass("close-dropdown")) {
                $(this).closest(".dropdown-menu").prev().dropdown("toggle")
            }
            return this
        },
        apply: function() {
            return this
        },
        cancel: function() {
            return this
        }
    };
    $.fn.dropdownCheckboxes = function(methodOrOptions) {
        if (dropdownMethods[methodOrOptions]) {
            return dropdownMethods[methodOrOptions].apply(this, Array.prototype.slice.call(arguments, 1))
        } else if (typeof methodOrOptions === "object" || !methodOrOptions) {
            return dropdownMethods.init.apply(this, arguments)
        }
    }
}
)(jQuery);
