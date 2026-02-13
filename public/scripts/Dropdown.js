function ToggleDropdown(dropdown) {
  dropdown.classList.toggle("open");
  UpdateDropdown(dropdown);
}

function UpdateDropdown(dropdown) {
  if (dropdown.classList.contains("open")) {
    const newHeight = Math.round(dropdown.scrollHeight);
    const currentHeight = parseInt(dropdown.style.maxHeight) || 0;

    if (Math.abs(newHeight - currentHeight) >= 2) {
      dropdown.style.maxHeight = newHeight + "px";
    }
  } else {
    if (dropdown.style.maxHeight !== "25px") {
      dropdown.style.maxHeight = "25px";
    }
  }
}

function DropdownLoop() {
  const dropdowns = Array.from(document.getElementsByClassName("dropdown"));

  dropdowns.forEach((dropdown) => {
    UpdateDropdown(dropdown);
  });
}

const speed = 50;
const dropdownInterval = setInterval(DropdownLoop, speed);
