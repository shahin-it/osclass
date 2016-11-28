/**
 * Created by shahin on 05-Aug-16.
 */
var app = {
    ajaxBase: function(controller, action) {
        var base = window._osc_commerce_admin_ajax_base;
        if(!base) {
            base = _osc_commerce_ajax_base;
        }
        base = base.replace("##controller##", controller).replace("##action##", action);
        return base;
    },
    base: function(controller, action) {
        var base = _osc_commerce_base;
        base = base.replace("##controller##", controller).replace("##action##", action);
        return base;
    },
    tab: {}
}

Object.defineProperty(String.prototype, "jq", {
    get: function () {
        return jQuery("" + this)
    }
});

Object.defineProperty(Element.prototype, "jq", {
    get: function () {
        return jQuery(this)
    }
});

$.extend($.prototype, {
    loader: function(show) {
        if(show === false) {
            this.mask(false);
        } else {
            var l = this.mask().addClass("loader");
            if(this.is("body")) {
                l.css({position: "fixed"})
            }
        }
        return this;
    },
    mask: function(show) {
        if(show === false) {
            this.find(".sui-overlay").remove();
        } else {
            this.append('<div class="sui-overlay"></div>');
        }
        return this.find(".sui-overlay");
    },
    serializeObject: function () {
        var o = {};
        var a = (this.is("form") ? this : this.find(":input")).serializeArray();
        $.each(a, function () {
            if (o[this.name] !== undefined) {
                if (!$.isArray(o[this.name])) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = this.value || '';
            }
        });
        return o;
    },
    updateUi: function() {
        this.find(".sui-file-chooser").on("change", "input[type=file]:last", function() {
            if(this.value) {
                if((this.files[0].size/1024) > (+this.jq.attr("max-size"))) {
                    sui.alert("Max size 2 MB");
                    this.jq.replaceWith(this.jq.val('').clone(true));
                    return false;
                }
                var input = $('<div class="input"><input type="file" name="s_image[]" value="" max-size="2048"><i class="action remove fa fa-times color-red" title="Remove"></i></div>');
                this.jq.parents(".input").after(input);
                input.find(".remove").click(function() {
                    this.jq.parents(".input").remove();
                })
            }
        });
        this.find(".sui-accordion-panel").each(function() {
            sui.accordion(this.jq);
        })
    }
});

var _to_fixed = Number.prototype.toFixed;
$.extend(Number.prototype, {
    /**
     * removes trailing 0s from fixed values if true is passed as trimmed
     */
    toFixed: function (count, trimmed) {
        var fixed = _to_fixed.call(this, count);
        if (trimmed) {
            return fixed.replace(/\.?0+$/, '');
        }
        return fixed;
    }
});