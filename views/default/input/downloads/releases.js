define(function(require) {

	var $ = require('jquery');
	var Ajax = require('elgg/Ajax');

	$(document).on('click', '.downloads-add-release-form', function(e) {
		var ajax = new Ajax();
		var $elem = $(this);

		ajax.view($elem.data('view'), {
			data: $elem.data('query')
		}).done(function(output) {
			$elem.closest('.downloads-input-releases').find('.downloads-release-forms').append($(output));
		});
	});
});