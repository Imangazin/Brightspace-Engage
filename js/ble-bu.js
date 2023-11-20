const ebuGradeSyncCheck = document.getElementById("ebuGradeSync");
const divHidden = document.getElementById("ebuGradeSyncDiv");
let orgSelectTag = document.getElementById("ebuOrganization");

//searchable select
$(document).ready(function() {
  $('.searchable').select2({
    placeholder: 'Select an option', // Placeholder text
    allowClear: true, // Option to clear selection
    width: '100%', // Adjust the width as needed
  });

  $.get('events.php', function (data) {
    console.log("data: " + data);
    data.forEach(option => {
      const optionElement = document.createElement("option");
      optionElement.value = data.id;
      optionElement.text = data.name;
      orgSelectTag.appendChild(optionElement);
    });
  }).fail(function (xhr, status, error) {
    console.error('GET request failed:', status, error);
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

orgSelectTag.addEventListener("change", function(event){
  const selectedValue = event.target.value;
  console.log(selectedValue);
});


