jQuery(document).ready(function(a) {
    a("*[data-eal-amazon-tracking-id-input]").keyup(function() {
        var b = a(this).data("eal-amazon-tracking-id-input"), c = a(this).val(), d = a('[data-eal-select-amazon-store-option="' + b + '"]');
        c ? d.prop("disabled", !1) : d.prop("disabled", !0);
    });
});