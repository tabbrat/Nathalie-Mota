document.addEventListener("DOMContentLoaded", function (e) {
  // default
  const els = document.querySelectorAll(".selectize");
  //console.log(els);

  els.forEach(function (select) {
    NiceSelect.bind(select);
    //console.log(select);
  });
});
