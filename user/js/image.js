var loadFile = function(event) {
	var image = document.getElementById('output');
	image.src = URL.createObjectURL(event.target.files[0]);

    const reader = new FileReader();
    reader.addEventListener('load', function() {preview.src = reader.result}, false);
};