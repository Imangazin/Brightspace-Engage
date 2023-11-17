const ebuGradeSyncCheck = document.getElementById("ebuGradeSync");
const divHidden = document.getElementById("ebuGradeSyncDiv");

//searchable select
$(document).ready(function() {
  $('.searchable').select2({
    placeholder: 'Select an option', // Placeholder text
    allowClear: true, // Option to clear selection
    width: '100%', // Adjust the width as needed
  });
});

// Add an event listener to the checkbox
ebuGradeSyncCheck.addEventListener("change", function () {
  if (ebuGradeSyncCheck.checked) {
    divHidden.classList.remove("hidden");
  } else {
    divHidden.classList.add("hidden");
  }
});

