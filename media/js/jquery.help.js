$.fn.makeHelpPanels = function() {

    var helpSources = $('.help').hide();
    console.log(helpSources);

    $('.help-invokers').each(function() {
        var invoker = $(this),
            helpId = invoker.attr('href'),
            helpSource = helpSources.find(helpId);
            invoker.toggle(
                function() {
                    invoker.removeClass('close').addClass('open');
                    helpSource.show('fast');
                    return false;
                },
                function() {
                    invoker.removeClass('open').addClass('close');
                    helpSource.hide('fast');
                    return false;
                }
            );

    })

}



