/**
 * jsPDFEditor
 * @return {[type]} [description]
 */
var jsPDFEditor = function() {
	
	var editor;

	var aceEditor = function() {
		editor = ace.edit("editor");
		editor.setTheme("ace/theme/twilight");
		//editor.setTheme("ace/theme/ambiance");
		editor.getSession().setMode("ace/mode/javascript");
		
		var timeout = setTimeout(function(){ }, 0);

		editor.getSession().on('change', function() {
			// Hacky workaround to disable auto refresh on user input
			if ($('#auto-refresh').is(':checked') && $('#template').val() != 'user-input.js') {
				clearTimeout(timeout);
				timeout = setTimeout(function() {
					jsPDFEditor.update();

				}, 200);
			}

		});
	};

	var loadSelectedFile = function() {
		if ($('#template').val() == 'user-input.js') {
			$('.controls .checkbox').hide();
			$('.controls .alert').show();
			jsPDFEditor.update(true);
		} else {
			$('.controls .checkbox').show();
			$('.controls .alert').hide();
		}


		$.get('examples/js/from-html.js', function(response) {
			editor.setValue(response);
			editor.gotoLine(0);

			// If autorefresh isn't on, then force it when we change examples
			if (! $('#auto-refresh').is(':checked')) {
				jsPDFEditor.update();
			}

		});
	};

	var initAutoRefresh = function() {
		$('#auto-refresh').on('change', function() {
			if ($('#auto-refresh').is(':checked')) {
				$('.run-code').hide();
				jsPDFEditor.update();
			} else {
				$('.run-code').show();
			}
		});

		$('.run-code').click(function() {
			jsPDFEditor.update();
			return false;
		});
	};

	var initDownloadPDF = function() {
		$('.download-pdf').click(function(){
			eval(editor.getValue());

			var file = demos[$('#template').val()];
			if (file === undefined) {
				file = 'demo';
			}
			doc.save(file + '.pdf');
		});
		return false;
	};

	return {
		/**
		 * Start the editor demo
		 * @return {void}
		 */
		init: function() {

			// Init the ACE editor
			aceEditor();

			//populateDropdown();
			loadSelectedFile();
			// Do the first update on init
			jsPDFEditor.update();

			initAutoRefresh();

			initDownloadPDF();
		},
		/**
		 * Updates the preview iframe
		 * @return {void}
		 */
		update: function(skipEval) {
			setTimeout(function() {
				if (! skipEval) {
					eval(editor.getValue());
				}
				var string = doc.output('datauristring');

				$('.preview-pane').attr('src', string);
			}, 0);
		}
	};

}();

$(document).ready(function() {
	jsPDFEditor.init();
});
