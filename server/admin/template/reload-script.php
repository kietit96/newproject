<script src="plugins/tag/bootstrap-tagsinput.js"></script>

<script type="text/javascript" src="new-template/tinymce/jquery.tinymce.min.js"></script>
<script type="text/javascript" src="new-template/tinymce/tinymce.min.js"></script>
<script>
	tinymce.init({
		selector: 'textarea.tinymce',
		plugins: 'print preview fullpage importcss searchreplace autolink autosave save directionality visualblocks visualchars fullscreen image link media table charmap hr pagebreak nonbreaking toc insertdatetime advlist lists wordcount imagetools textpattern help charmap noneditable emoticons',
		menubar: 'file edit view insert format tools table tc help',
		toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed link | a11ycheck ltr rtl | showcomments addcomment | toc | emoticons',
		content_style: 'body { font-family: Arial; font-size: 14px; }',
		fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 24px 26px 28px 30px 32px 34px 36px",
		content_css: "new-template/tinymce/tinymce/content.css",
		autosave_ask_before_unload: true,
		autosave_interval: "30s",
		autosave_retention: "2m",
		image_advtab: true,
		importcss_append: true,
		image_caption: true,
		noneditable_noneditable_class: true,
		toolbar_drawer: 'wrap',
		spellchecker_dialog: true,
		height: 450,
		formats: {
			bold: {
				inline: 'span',
				styles: {
					fontWeight: 'bold'
				}
			},
			italic: {
				inline: 'span',
				styles: {
					fontStyle: "italic"
				}
			},
			underline: {
				inline: 'span',
				styles: {
					textDecoration: "underline"
				}
			}
		},
		convert_urls: false,
		automatic_uploads: false,


		// without images_upload_url set, Upload tab won't show up
		images_upload_url: '../modules/upload.php',

		images_upload_base_path: '/upload',
		images_upload_credentials: true,

		// override default upload handler to simulate successful upload
		images_upload_handler: function(blobInfo, success, failure) {
			var xhr, formData;

			xhr = new XMLHttpRequest();
			xhr.withCredentials = false;
			xhr.open('POST', '../modules/upload.php');

			xhr.onload = function() {
				var json;

				if (xhr.status != 200) {
					failure('HTTP Error: ' + xhr.status);
					return;
				}

				json = JSON.parse(xhr.responseText);

				if (!json || typeof json.location != 'string') {
					failure('Invalid JSON: ' + xhr.responseText);
					return;
				}

				success(json.location);
			};

			formData = new FormData();
			formData.append('file', blobInfo.blob(), blobInfo.filename());

			xhr.send(formData);
		},
		setup: function(editor) {
			editor.on('PreInit', function(event) {
				var editor = event.target,
					dom = editor.dom;
				dom.setAttrib(editor.getBody(), 'contenteditable', 'true');

			});

		}
	});
</script>