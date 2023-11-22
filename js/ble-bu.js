const ebuGradeSyncCheck = document.getElementById("ebuGradeSync");
const divHidden = document.getElementById("ebuGradeSyncDiv");
let orgSelectTag = document.getElementById("ebuOrganization");
let eventSelectTag = document.getElementById("ebuEvent");
//searchable select
$(document).ready(function() {
  $('.searchable').select2({
    placeholder: 'Select an option', // Placeholder text
    allowClear: true, // Option to clear selection
    width: '100%', // Adjust the width as needed
  });

  $('#ebuOrganization').on('select2:select', function (e) {
    const selectedValue = e.params.data.id;
    const selectedText = e.params.data.text;
    const selectId = $(this).attr('id'); // Get the ID of the changed select

    console.log('Select ID:', selectId);
    console.log('Selected Value:', selectedValue);
    console.log('Selected Text:', selectedText);
    // Add your custom logic here based on the selected value/text and select ID
    $.get('src/experienceBU.php?organizationId='+selectedValue, function (data) {
      data = JSON.parse(data); 
      data.forEach(function(each){
        const optionElement = document.createElement("option");
        optionElement.value = each.id;
        optionElement.text = each.name;
        eventSelectTag.appendChild(optionElement);
      });
    }).fail(function (xhr, status, error) {
      console.error('GET request failed:', status, error);
    });
  });

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

// Add an event listener to the checkbox
ebuGradeSyncCheck.addEventListener("change", function () {
  if (ebuGradeSyncCheck.checked) {
    divHidden.classList.remove("hidden");
  } else {
    divHidden.classList.add("hidden");
  }
});
