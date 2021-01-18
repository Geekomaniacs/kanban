function onDragStart(event) {
  event.dataTransfer.setData('text/plain', event.target.id);
}

function onDragOver(event) {
  event.preventDefault();
}

function onDrop(event) {
  event.preventDefault();
  const id = event.dataTransfer.getData('text');
  const draggableElement = document.getElementById(id);
  if (event.target.classList.contains("box")) {
    const dropzone = event.target;
    dropzone.append(draggableElement);
  }
}