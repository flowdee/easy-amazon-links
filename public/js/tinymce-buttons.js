!function() {
    tinymce.PluginManager.add("columns", function(a, b) {
        b.replace("/public/js/", "/public/img/") + "/tinymce-button.png";
        a.addButton("eal", {
            title: "Easy Amazon Affiliate Link",
            cmd: "eal-link",
            icon: "icon eal-tinymce-icon"
        }), a.addCommand("eal-link", function() {
            a.focus();
            var b = a.selection.getContent({
                format: "html"
            });
            return b && b.length > 0 ? (a.execCommand("mceInsertContent", !1, '<span data-eal-link="true">' + b + "</span>"), 
            !1) : (alert("Please select some text."), !1);
        });
    });
}();