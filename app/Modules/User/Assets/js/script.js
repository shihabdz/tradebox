var inputf = document.querySelector("#mobile");
    window.intlTelInput(inputf, {
      nationalMode: false,
      hiddenInput: "phonenumber",     
      utilsScript: "public/assets/website/build/js/utils.js",
    });