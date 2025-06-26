["num1", "num2"].forEach(id => {
  document.getElementById(id).oninput = function () {
    if (/[^0-9]/.test(this.value)) {
      alert("Only numbers allowed");
      this.value = this.value.replace(/[^0-9]/g, '');
    }
  };
});
