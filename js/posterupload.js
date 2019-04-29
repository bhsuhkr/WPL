+ function($) {
    'use strict';

    // UPLOAD CLASS DEFINITION
    // ======================

    var dropZone = document.getElementById('drop-zone');
    var uploadForm = document.getElementById('js-upload-form');

    var startUpload = function(files) {
        console.log(files)
    }

    uploadForm.addEventListener('submit', function(e) {
        var uploadFiles = document.getElementById('js-upload-files').files;
        e.preventDefault()

        startUpload(uploadFiles)
    })

    dropZone.ondrop = function(e) {
        e.preventDefault();
        this.className = 'upload-drop-zone';

        startUpload(e.dataTransfer.files)
    }

    dropZone.ondragover = function() {
        this.className = 'upload-drop-zone drop';
        return false;
    }

    dropZone.ondragleave = function() {
        this.className = 'upload-drop-zone';
        return false;
    }

}(jQuery);



$("#file_input").withDropZone("#drop_zone", {
  url: null,
  action: null,
  multiUploading: true,
  ifWrongFile: "show",
  maxFileSize: Number.POSITIVE_INFINITY,
  autoUpload: false,
  fileNameMatcher: /.*/,
  fileMimeTypeMatcher: /.*/,
  wrapperForInvalidFile: function(fileIndex) {
    return "<p>File: \"" + this.files[fileIndex].name + "\" doesn't support</p>'";
  },
  validateAll: function(files) {
    return files;
  },
  uploadBegin: function(fileIndex, blob) {},
  uploadEnd: function(fileIndex, blob) {},
  done: function() {},
  ajaxSettings: function(settings, fileIndex, blob) {}
});

