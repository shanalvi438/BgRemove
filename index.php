<!DOCTYPE html>
<html>
<head>
  <title>Image Upload with Drag and Drop and CTRL + V</title>
</head>
<body>
  <input type="file" id="fileInput" style="display: none;" />
  <div id="dropArea" style="border: 2px dashed #ccc; padding: 20px; text-align: center;">
    <p>Drag and drop an image here or use CTRL + V to paste</p>
  </div>
  <img id="previewImage" style="max-width: 300px; display: none;" />
</body>
</html>
<script>
  // Function to handle file selection from input type="file"
  function handleFileSelect(evt) {
    var file = evt.target.files[0];
    showImage(file);
  }

  // Function to handle image paste event
  function handlePaste(evt) {
    var items = evt.clipboardData.items;
    for (var i = 0; i < items.length; i++) {
      if (items[i].type.indexOf("image") !== -1) {
        var file = items[i].getAsFile();
        showImage(file);
        break;
      }
    }
  }

  // Function to handle drag and drop events
  function handleDrop(evt) {
    evt.preventDefault();
    var file = evt.dataTransfer.files[0];
    showImage(file);
  }

  function showImage(file) {
    var reader = new FileReader();
    reader.onload = function (evt) {
      var img = document.getElementById("previewImage");
      img.src = evt.target.result;
      img.style.display = "block";
    };
    reader.readAsDataURL(file);
  }

  // Initialize event listeners
  document.getElementById("fileInput").addEventListener("change", handleFileSelect);
  document.getElementById("dropArea").addEventListener("drop", handleDrop);
  document.getElementById("dropArea").addEventListener("dragover", function (evt) {
    evt.preventDefault();
  });
  document.addEventListener("paste", handlePaste);
</script>
