// Function to fetch and insert the header content
function insertHeader() {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', '../inc/header.html', true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var headerElement = document.querySelector('header');
      headerElement.innerHTML = xhr.responseText;
      //Navigation toggle function
      const toggle = document.querySelector('.toggle-icon');
      toggle.addEventListener('click', () => {
          document.querySelector('.nav-links').classList.toggle('show-nav'); 
      });
    }
  };
  xhr.send();
}

insertHeader();

// Function to fetch and insert the footer content
function insertFooter() {
  var xhr = new XMLHttpRequest();
  xhr.open('GET', '../inc/footer.html', true);
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      var footerElement = document.querySelector('footer');
      footerElement.innerHTML = xhr.responseText;
    }
  };
  xhr.send();
}

insertFooter();

//Function for expanding Images with overlay to darken background
function expandImage(img) {
    const darkOverlay = document.querySelector(".dark-overlay");
    darkOverlay.style.display = "block";
    const clone = img.cloneNode(true);
    clone.classList.add("expanded");
    document.body.appendChild(clone);

    clone.onclick = function() {
        this.remove();
      darkOverlay.style.display = "none";
    };
}

function closeExpandedImage() {
    const expandedImage = document.querySelector(".expanded");
    const darkOverlay = document.querySelector(".dark-overlay");
    if (expandedImage) {
        expandedImage.remove();
      darkOverlay.style.display = "none";
    }
}