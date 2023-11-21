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

window.addEventListener('load', function () {
  $.get('src/experienceBU.php', function (data) {
    data = JSON.parse(data); 
    data.forEach(function(each){
      const optionElement = document.createElement("option");
      optionElement.value = each.id;
      optionElement.text = each.name;
      orgSelectTag.appendChild(optionElement);
    });
  }).fail(function (xhr, status, error) {
    console.error('GET request failed:', status, error);
  });
});