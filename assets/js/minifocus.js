;(function (factory) {

    if (typeof module !== "undefined" && module.exports) {
        // Node.js environment
        module.exports = factory(require("jquery"));
    } else {
        // Browser environment
        factory(jQuery);
    }

}(function ($, undefined) {

    // Add as a jQuery plugin
    $.extend({
        minifocus: {
            init: initMinifocus,
            setRuleForSelector: setRuleForSelector,
            removeRuleForSelector: removeRuleForSelector,
            setPreventDefaultTabBehavoir: setPreventDefaultTabBehavoir
        }
    });

    // Automatically initialize on document's ready event
    $(document).ready(function () {
        initMinifocus();
    });

    // Use a map to store customized rules
    const gRuleMap = new Map();

    // Prevent default Tab behavior by default.
    let gPreventDefaultTabBehavior = true;

    // The default rule to judge if the focus should be passed to another element
    function defaultRule(key, $focusSrc) {
        if (
            $focusSrc.is("button") ||
            $focusSrc.is("textarea") ||
            $focusSrc.is("select") ||
            $focusSrc.is("a") ||
            $focusSrc.is("input[type='button']") ||
            $focusSrc.is("input[type='submit']") ||
            $focusSrc.is("input[type='image']") ||
            $focusSrc.is("input[type='reset']") ||
            $focusSrc.is("input[type='file']")
        ) {
            return key === "Tab";
        }
        return key === "Enter" || key === "Tab";
    }

    // Find a proper rule and call
    function testRule(key, $focusSrc) {
        for (let selector of gRuleMap.keys()) {
            if ($focusSrc.is(selector)) {
                let method = gRuleMap.get(selector);
                return method(key, $focusSrc);
            }
        }
        return defaultRule(key, $focusSrc);
    }

    // Let minifocus manage focus-switching logics
    function initMinifocus() {
        $(document).keydown(function (event) {
            if (event.key === "Tab" && gPreventDefaultTabBehavior) {
                event.preventDefault();
            }

            let $focusSrc = $(event.target);

            let mfIndex = $focusSrc.attr("data-mfindex");
            if (!mfIndex) {
                return;
            }
            mfIndex = parseInt(mfIndex);

            let $focusGroup = $focusSrc.parents("[data-mfgroup]").first();
            if ($focusGroup.length === 0) {
                return;
            }

            let $focusTarget = $focusGroup.find(`[data-mfindex=${mfIndex + 1}]`);
            if ($focusTarget.length === 0) {
                $focusTarget = $focusGroup.find("[data-mfindex='1']");
            }

            if ($focusTarget.length > 0 && testRule(event.key, $focusSrc)) {
                event.preventDefault();
                $focusTarget.focus();
				$focusTarget.select();
            }
        });
    }

    // Add a customized rule to minifocus
    function setRuleForSelector(selector, method) {
        gRuleMap.set(selector, method);
    }

    // Remove a customized rule
    function removeRuleForSelector(selector) {
        gRuleMap.delete(selector);
    }

    // Set if we want to prevent the default Tab behavior.
    function setPreventDefaultTabBehavoir(preventDefaultTabBehavoir) {
        gPreventDefaultTabBehavior = preventDefaultTabBehavoir;
    }

    return $.minifocus;

}));