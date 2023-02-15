!function (n) {
    "use strict";
    !function () {
        if (0 != n("#Dash_Date").length) {
            var i = n("#Dash_Date"), t = moment(), a = moment();
            i.daterangepicker({
                startDate: t,
                endDate: a,
                opens: "left",
                applyClass: "btn btn-sm btn-primary",
                cancelClass: "btn btn-sm btn-secondary",
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],
                    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                }
            }, e), e(t, a, "")
        }

        function e(t, a, e) {
            var n = "", s = "";
            a - t < 100 || "Today" == e ? (n = "Today:", s = t.format("MMM D")) : "Yesterday" == e ? (n = "Yesterday:", s = t.format("MMM D")) : s = t.format("MMM D") + " - " + a.format("MMM D"), i.find("#Select_date").html(s), i.find("#Day_Name").html(n)
        }
    }(), n(".metismenu").metisMenu(), n(".button-menu-mobile").on("click", function (t) {
        t.preventDefault(), n("body").toggleClass("enlarge-menu")
    }), n(window).width() < 1025 ? n("body").addClass("enlarge-menu") : n("body").removeClass("enlarge-menu"), n('[data-toggle="tooltip"]').tooltip(), n(".main-icon-menu .nav-link").on("click", function (t) {
        n("body").removeClass("enlarge-menu"), t.preventDefault(), n(this).addClass("active"), n(this).siblings().removeClass("active"), n(".main-menu-inner").addClass("active");
        var a = n(this).attr("href");
        n(a).addClass("active"), n(a).siblings().removeClass("active")
    }), n(".leftbar-tab-menu a, .left-sidenav a").each(function () {
        var t = window.location.href.split(/[?#]/)[0];
        if (this.href == t) {
            n(this).addClass("active"), n(this).parent().addClass("active"), n(this).parent().parent().addClass("in"), n(this).parent().parent().addClass("mm-show"), n(this).parent().parent().parent().addClass("mm-active"), n(this).parent().parent().prev().addClass("active"), n(this).parent().parent().parent().addClass("active"), n(this).parent().parent().parent().parent().addClass("mm-show"), n(this).parent().parent().parent().parent().parent().addClass("mm-active");
            var a = n(this).closest(".main-icon-menu-pane").attr("id");
            n("a[href='#" + a + "']").addClass("active")
        }
    }), feather.replace(), n(".navigation-menu a").each(function () {
        var t = window.location.href.split(/[?#]/)[0];
        this.href == t && (n(this).parent().addClass("active"), n(this).parent().parent().parent().addClass("active"), n(this).parent().parent().parent().parent().parent().addClass("active"))
    }), n(".navbar-toggle").on("click", function (t) {
        n(this).toggleClass("open"), n("#navigation").slideToggle(400)
    }), n(".navigation-menu>li").slice(-2).addClass("last-elements"), n('.navigation-menu li.has-submenu a[href="#"]').on("click", function (t) {
        n(window).width() < 992 && (t.preventDefault(), n(this).parent("li").toggleClass("open").find(".submenu:first").toggleClass("open"))
    }), Waves.init()
}(jQuery);